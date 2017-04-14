@extends('desktop.layouts.app')

@section('title-body')
    @if (old('title'))
        {{old('title')}} - 
    @elseif (isset($topic)) 
        {{ $topic->title }} - 
    @endif
@endsection

@section('content')

<div class="rows">
    <div class="col-lg-12">
        <div class="panel panel-default shadow">
            <div class="panel-heading">{{$title}}<span id="save_topic" style="display:none; float:right;font-size: 12px;">正在保存...</span></div>
            <div class="panel-body">
                <form role="form" method="POST" action="{{ route('topic.update', ['id' => $topic->id]) }}" id="topic_form">
                    <input name="_method" type="hidden" value="PATCH" >
                    {{ csrf_field() }}
                    
                    <div class="form-group{{ $errors->has('classify_id') ? ' has-error' : '' }}">
                        <select name="classify_id" class="form-control">
                            <option value="0" disabled selected>请选择分类</option>
                            @foreach($classify as $value)
                                <option value="{{ $value->id }}" @if (old('classify_id') == $value->id || $topic->classify_id == $value->id) selected @endif>{{ $value->name }}</option>
                            @endforeach
                        </select>
                        
                        @if ($errors->has('classify_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('classify_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" id="title" name="title" placeholder="请填写标题" value="@if(old('title')){{{old('title')}}}@else{{{$topic->title}}}@endif">
                        
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <markdown has-error="{{ $errors->has('body') }}" error-msg="{{ $errors->first('body') }}" ta-content="@if(old('body')){{{old('body')}}}@else{{{$topic->body_original}}}@endif"></markdown>
                    
                    <div class="form-group">
                        <button type="submit" name="save" class="btn btn-default">
                            保存
                        </button>
                        @if(!$topic->is_publish)
                            <button type="submit" name="save_and_publish" class="btn btn-success">
                                保存并发布
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
    // var Vm = new Vue({
    //     el : '#wrapper',
    //     data : {
    //         topic:{}
    //     }
    //     methods: {
    //         submit:function(){
    //             var formData = JSON.stringify(this.topic);
    //             console.log(formData);
    //             return 'hello world';
    //         }
    //     }
    // });
    
    
    $(window).keydown(function(e) {
    	if (e.keyCode == 83 && e.ctrlKey) {
    		e.preventDefault();
    		
            $("#save_topic").html('正在保存...').fadeIn(0);
            
            var data = {}
            data._method = $("#topic_form input[name=_method]").val();
            data._token = $("#topic_form input[name=_token]").val();
            data.classify_id = $("#topic_form select[name=classify_id]").val();
            data.title = $("#topic_form input[name=title]").val();
            data.body = $("#topic_form textarea[name=body]").val();
            data.save = '';
            
            Vue.http.post("{{ route('topic.update', ['id' => $topic->id]) }}", data).then(function(response) {
                $("#save_topic").html('保存成功').fadeOut(3000);
            });
    	}
    });
    
    </script>
@endsection
