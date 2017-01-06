@extends('desktop.layouts.app')

@section('content')
<div class="rows">
    <div class="col-lg-9 pd-right pd-no">
        <div class="panel panel-default shadow">
            <div class="panel-heading">
                <h1>{{ $topic->title }}</h1>
                <p class="topic-spec">
                    <span class="list-tag">{{ $topic->classify->name }}</span> - 
                    <a href="{{ route('user.show', $topic->user_id) }}" class="pjax-element">{{ $topic->user->name }}</a> - 
                    于 <span class="white">{{$topic->created_at->diffForHumans()}}</span> - 
                    <span class="white"> {{ $topic->view_num }} </span>阅读
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
