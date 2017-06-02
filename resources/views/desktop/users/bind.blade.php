@extends('desktop.layouts.app')

@section('title-body')
    {{ $user->name }} - 
@endsection

@section('style')
<style type="text/css">
    .fa-bind {width:40px; height:40px; float: left; margin-right: 15px; font-size: 40px;}
    .fa-qq {color:#3194d0;}
    .fa-weibo {color:#E6162D;}
    .fa-github {color:#F8FCEB; text-align: center;}
    .fa-twitter {color:#1da1f2; text-align: center;}
    .binded {line-height: 40px;}
    .unbind {line-height: 40px;float:right; display:none;}
</style>
@endsection

@section('content')
<div class="rows">
    <div class="col-lg-3">
        @include('desktop.users.userMenu')
    </div>
    
    <div class="col-lg-9 pd-left pd-no">
        <div class="alert alert-warning" role="alert">绑定第三方账号，之后可直接使用第三方账号快捷登录</div>
        <ul class="list-group shadow">
            <li class="list-group-item">
                <b class="fa fa-qq fa-bind"></b>
                @if (empty($user->qq_id))
                    <a href="{{ route('user.thirdBind', ['driver' => 'qq', 'type' => 'bind']) }}" class="btn btn-default">
                        绑定 qq 登录
                    </a>
                @else 
                    <span class="hui-14 binded">已绑定</span><a href="{{ route('user.thirdUnbind', ['driver' => 'qq', 'type' => 'unbind']) }}" class="hui-14 unbind">解除绑定</a>
                @endif
            </li>
            
            <li class="list-group-item">
                <b class="fa fa-weibo fa-bind"></b>
                @if (empty($user->weibo_id))
                    <a href="{{ route('user.thirdBind', ['driver' => 'weibo', 'type' => 'bind']) }}" class="btn btn-default">
                        绑定 微博 登录
                    </a>
                @else 
                    <span class="hui-14 binded">已绑定</span><a href="{{ route('user.thirdUnbind', ['driver' => 'weibo', 'type' => 'unbind']) }}" class="hui-14 unbind">解除绑定</a>
                @endif
            </li>
            
            <li class="list-group-item">
                <b class="fa fa-github fa-bind"></b>
                @if (empty($user->github_id))
                    <a href="{{ route('user.thirdBind', ['driver' => 'github', 'type' => 'bind']) }}" class="btn btn-default">
                        绑定 github 登录
                    </a>
                @else 
                    <span class="hui-14 binded">已绑定</span><a href="{{ route('user.thirdUnbind', ['driver' => 'github', 'type' => 'unbind']) }}" class="hui-14 unbind">解除绑定</a>
                @endif
            </li>
            
            <li class="list-group-item">
                <b class="fa fa-twitter fa-bind"></b>
                @if (empty($user->twitter_id))
                    <a href="{{ route('user.thirdBind', ['driver' => 'twitter', 'type' => 'bind']) }}" class="btn btn-default">
                        绑定 twitter 登录
                    </a>
                @else 
                    <span class="hui-14 binded">已绑定</span><a href="{{ route('user.thirdUnbind', ['driver' => 'twitter', 'type' => 'unbind']) }}" class="hui-14 unbind">解除绑定</a>
                @endif
            </li>
        </ul>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(".list-group-item").hover(function(){
            $(this).find('.unbind').show();
        },function(){
            $(this).find('.unbind').hide();
        });
    </script>
@endsection
