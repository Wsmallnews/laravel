@extends('desktop.layouts.app')

@section('title-body')
    {{ $user->name }} - 
@endsection

@section('content')

<div class="rows">
    <div class="col-lg-3">
        @include('desktop.layouts.userInfo')
    </div>
    
    <div class="col-lg-9 pd-left pd-no">
        <div class="panel panel-default shadow">
            <div class="panel-heading">{{$title}}</div>
            <div class="panel-body">
                <form role="form" method="POST" action="{{ route('classify.store') }}" id="classify_form" >
                    {{ csrf_field() }}
                    
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" id="name" name="name" placeholder="分类名称" 
                            value="{{old('name')}}">
                        
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <uploader btn-obj="icon" btn-name="添加图标" type="topics/classify"  @if (old('icon')) def-value="{{old('icon')}}" @else def-value="{{ $user->icon }}" @endif></uploader>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="save" class="btn btn-default">
                            保存
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        
    </script>
@endsection
