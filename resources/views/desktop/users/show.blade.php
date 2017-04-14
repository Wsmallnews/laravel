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
            <div class="panel-heading">
                {{$user->name}} 最近发表的主题
            </div>
            @if(!$topics->isEmpty())
            <div class="panel-body padding-no">
                @include('desktop.includes.topicList', ['type' => 'normal', 'no_paginate' => '1'])
            </div>
            @else
                @include('desktop.layouts.empty')
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
    </script>
@endsection
