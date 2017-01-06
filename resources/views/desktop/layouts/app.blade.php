<!--
 ____                  _ _                         
/ ___| _ __ ___   __ _| | |_ __   _____      _____ 
\___ \| '_ ` _ \ / _` | | | '_ \ / _ \ \ /\ / / __|
___) | | | | | | (_| | | | | | |  __/\ V  V /\__ \
|____/|_| |_| |_|\__,_|_|_|_| |_|\___| \_/\_/ |___/ 
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title-body'){{ $title or config('app.name', 'Laravel')}} - {{ config('app.name', 'Laravel') }}开发者社区</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css"  href="{{ asset('/css/app.css') }}" >

    <style>
        body{background-color:#495664;color:#F8FCEB;}
        .navbar {box-shadow:0px 5px 15px #222222;}
        #page-body{padding-top:65px;}
        .shadow {box-shadow:1px 1px 5px #222222;}       /*设置阴影*/
        #powerby{text-align: center;height:30px;line-height: 30px;margin: 30px 0px;}
        /*.power {background-color: #F8FCEB}*/
        footer{background:#333C4A;padding:20px;box-shadow:0px -5px 15px #222222;position:fixed;bottom:0;left:0;width:100%;}
        
        .navbar-inverse {background-color: #333C4A;border-color: #222222;}
        .navbar-inverse .navbar-nav > li > a {text-align: center;color:#F8FCEB;}
        .nav.navbar-nav .wechat_login {text-align: center;color:#999999;font-size:18px;padding: 4px 0px;margin: 10px 5px;}
        .nav.navbar-nav .github_login {text-align: center;color:#999999;font-size:18px;padding: 4px 0px;margin: 10px 5px;}
        .nav.navbar-nav .wechat_login:hover{color:#44b549}
        .nav.navbar-nav .github_login:hover{color: #4FA7EF;}
        li.list-group-item{background-color:#495664;border-color: #333C4A;color:#F8FCEB;position:relative;
                            overflow:hidden;border-left:none;border-right:none;}
        li.list-group-item a {color: #F8FCEB; text-decoration: none;}
        li.list-group-item:hover {background-color:#333C4A;color:#F8FCEB;}
        li.list-group-item:focus {background-color:#333C4A;color:#F8FCEB;}
        li.list-group-item > .badge {position: absolute; top: 50%;right: 20px;margin-top: -9px;}
        .list-group-item:first-child{border-radius: 0px;border-top: none;}
        .list-group-item:last-child{border-radius: 0px;}
        .form-control { background-color: #495664;border: 2px solid #333C4A;color: #F8FCEB;}
        .pd-10 {padding:10px;}
        .mr-bo-20 {margin-bottom: 20px;}
        .btn-default:hover{color: #F8FCEB;background-color: #495664;border-color: #333C4A;}
        .btn-default{color: #F8FCEB;background-color: #333C4A;border-color: #495664;}
        .img-file {width:100px;height:100px;border: 2px solid #333C4A;border-radius: 2px;}
        .img-file input {opacity: 0;width:100px;height:100px;}
        
        .panel {margin-bottom: 22px;background-color:#495664;}
        .panel-default {border:none;border-radius: 0px;}
        .panel-default > .panel-heading {color: #F8FCEB;background-color: #495664;border-color: #333C4A;}
        .dropdown-menu {background-color: #495664; box-shadow: 0px 3px 5px #222222}
        .dropdown-menu > li > a {color: #F8FCEB;}
        .dropdown-menu > li > a:hover {color: #F8FCEB;background-color: #333C4A;}
        #md-content{ overflow-x: hidden; overflow-y: auto;word-wrap: break-word; resize: none; width: 100%;}
        #md-html {border: 2px solid #333C4A;display:table;}
        .alert {border-radius: 0px;}
        .list-tag{background-color: #F8FCEB;font-size:12px;color:#333333;padding:1px 3px;border-radius:3px;}
        .list-a-avatar {float:left;}
        .list-spec {background-repeat: no-repeat;background-position: right top;background-size:40px;}
        .list-content {margin:8px 30px 0px 0px;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;}
        
        /* 字体 */
        .hei{color:#333333;}
        .white{color:#F8FCEB;}
        /* alert 框 */
        .sweet-alert {background-color: #F6F7D3;border-radius: 0px;box-shadow:1px 1px 5px #222222;}
        /* alert 框 end */
        
        /* 头像多个规则 */
        .list-avatar {width:40px;height:40px;margin-right: 10px;border:2px solid #333C4A; padding:1px; border-radius: 3px;}
        /* 头像多个规则 end */
        
        /* 没有数据 样式 */
        .desk-no-data{height:50px;width:100%;line-height: 50px;text-align:center;margin-bottom: 20px;}
        
        /* 主题排序 */
        .nav-topic-sort{}
        .nav-topic-sort > li > a {color:#F8FCEB;padding:3px 10px;}
        .nav-topic-sort > li.active > a {background-color: #333C4A;box-shadow:1px 1px 5px #222222;border-radius: 0px;}
        .nav.nav-topic-sort > li > a:hover {background-color: #333C4A;box-shadow:1px 1px 5px #222222;border-radius: 0px;}
        .nav.nav-topic-sort > li > a:focus {background-color: #333C4A;box-shadow:1px 1px 5px #222222;border-radius: 0px;}
        
        /* 主题详情 */
        .topic-spec{ margin:0;color:#929292;font-size:12px;}
        .topic-spec a {color:#F8FCEB;}
        .topic-spec a:hover {color:#F8FCEB;}
    </style>

    <!-- Scripts -->
    <script type="text/javascript">
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!}
    </script>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hidden-xs" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
                </div>
                <!-- /.navbar-header -->
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-left">
                        @foreach(app('nav') as $nav)
                            <li><a href="{{ route('topic.filter', ['classify_id' => $nav->id]) }}" class="pjax-element">{{$nav->name}}</a></li>
                        @endforeach
                    </ul>
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}" class="pjax-element"> 登录</a></li>
                            <li><a href="{{ url('/register') }}" class="pjax-element"> 注册</a></li>
                            <li><a href="" class="wechat_login"> <b class="fa fa-weixin"></b></a></li>
                            <li><a href="{{ route('auth.driver', ['driver' => 'github']) }}" class="github_login"> <b class="fa fa-github-alt"></b></a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <b class="fa fa-plus"></b> 新主题<span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="javascript:void(0);" onclick="showAlert({title:'确定添加新主题？'},createTopic)">
                                            新主题
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <script type="text/javascript">
                                function createTopic(){ // 添加新主题
                                    window.location.href="{{route('topic.create')}}";
                                }
                            </script>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <b class="fa fa-user"></b> {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
    
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="javascript:void(0);" onclick="showAlert({title:'确定要退出吗'},function(){document.getElementById('logout-form').submit();})">
                                            退出
                                        </a>
    
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        
        <div id="page-body">
            <div class="container">
                @include('flash::message')
                @yield('content')
            </div>
        </div>
        
        <div id="powerby">
            <div class="container">
                <div class="shadow power">
                    power by Smallnews
                </div>
            </div>
        </div>
        
        <footer class="footer">
            <div class="container">
                <div class="row">
                    
                </div>
            </div>
        </footer>
        
        <!-- 进度条 -->
        <vue-progress-bar></vue-progress-bar>
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
    
    @section('script')
        <script type="text/javascript">
        </script>
    @endsection

    @yield('script')

</body>
</html>
