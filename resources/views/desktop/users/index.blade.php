@extends('desktop.layouts.app')

@section('title-body')
    {{ $user->name }} - 
@endsection

@section('content')
<div class="rows">
    <div class="col-lg-3">
        <div class="panel panel-default shadow">
            <div class="panel-heading">
                <span class="white-20">{{$user->name}}</span> 的资料
            </div>
            <div class="panel-body text-center">
                <div class="avatar_div">
                    <img src="{{$user->avatar}}" class="user_avatar shadow-5" onerror="this.src='/images/no-user.png'" />
                </div>
                <table class="table user_info">
                    <tr><td>昵称：</td><td>{{$user->name}}</td></tr>
                    <tr><td>编号：</td><td>第<span class="huang"> {{$user->id}} </span>位会员</td></tr>
                    @if($user->email)
                    <tr><td>邮箱：</td><td>{{$user->email}}</td></tr>
                    @endif
                    <tr><td>注册：</td><td>{{$user->created_at->diffForHumans()}}</td></tr>
                </table>
                <hr></hr>
                
                <div class="user_link_tag">
                    @if($user->github_name)
                        <a href="https://github.com/{{$user->github_name}}" target="_blank"><i class="fa fa-github-alt"></i> Github</a>
                    @endif
                    @if($user->personal_website)
                        <a href="{{$user->personal_website}}" target="_blank"><i class="fa fa-globe"></i> Website</a>
                    @endif
                    @if($user->wechat_qrcode)
                        <a href="javascript:;"><i class="fa fa-weixin"></i> Wechat</a>
                    @endif
                    @if($user->qq_qrcode)
                        <a href="javascript:;"><i class="fa fa-qq"></i> QQ</a>
                    @endif
                    @if($user->linked_in)
                        <a href="{{$user->linked_in}}" target="_blank"><i class="fa fa-linkedin"></i> LinkedIn</a>
                    @endif
                    @if($user->company)
                        <a href="javascript:;"><i class="fa fa-group"></i> 公司</a>
                    @endif
                </div>
            </div>
        </div>
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
