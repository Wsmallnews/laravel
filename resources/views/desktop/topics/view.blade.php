@extends('desktop.layouts.app')

@section('content')
<div class="rows">
    <div class="col-lg-9 pd-right pd-no">
        <div class="panel panel-default shadow">
            <div class="panel-heading">
                <h1>{{ $topic->title }}</h1>
                <p style="margin:0;color:#929292;font-size:12px;">
                    <a href="{{ url('topic') }}">{{ $topic->classifyName }}</a> - 
                    <a href="{{ url('user') }}">{{ $topic->userName }}</a> - 
                    于5天前 - 最后回复由
                    <a href="{{ url('user') }}">smallnews</a> - 于2天前 - 
                    <span> {{ $topic->view_num }} 阅读</span>
                </p> 
            </div>
            <div class="panel-body">
                {!! $topic->body !!}
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="shadow pd-10">asdfasdfasdf</div>
    </div>
</div>
@endsection
