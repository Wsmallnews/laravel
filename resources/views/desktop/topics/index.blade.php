@extends('desktop.layouts.app')

@section('content')
<div class="rows">
    <div class="col-lg-9 pd-right pd-no">
        <div class="panel panel-default shadow">
            <div class="panel-heading">
                <ul class="nav nav-pills nav-topic-sort" role="tablist">
                    <li role="presentation" class="@if(request()->orderby == '' || request()->orderby == 'default') active @endif">
                        <a href="{{ route('topic.sort', 'default') }}" class="pjax-element">默认</a>
                    </li>
                    <li role="presentation" class="@if(request()->orderby == 'elite') active @endif">
                        <a href="{{ route('topic.sort', 'elite') }}" class="pjax-element">加精</a>
                    </li>
                    <li role="presentation" class="@if(request()->orderby == 'time') active @endif">
                        <a href="{{ route('topic.sort', 'time') }}" class="pjax-element">时间</a>
                    </li>
                    <li role="presentation" class="@if(request()->orderby == 'review') active @endif">
                        <a href="{{ route('topic.sort', 'review') }}" class="pjax-element">评论</a>
                    </li>
                    <li role="presentation" class="@if(request()->orderby == 'support') active @endif">
                        <a href="{{ route('topic.sort', 'support') }}" class="pjax-element">点赞</a>
                    </li>
                    <li role="presentation" class="@if(request()->orderby == 'view') active @endif">
                        <a href="{{ route('topic.sort', 'view') }}" class="pjax-element">浏览</a>
                    </li>
                </ul>
            </div>
            @if(!$topics->isEmpty())
            <div class="panel-body padding-no">
                @include('desktop.includes.topicList', ['type' => 'all'])
            </div>
            @else
                @include('desktop.layouts.empty')
            @endif
        </div>
    </div>
    
    <div class="col-lg-3">
        <div class="shadow pd-10">asdfasdfasdf</div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
    </script>
@endsection
