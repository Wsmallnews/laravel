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

    <title>{{ config('app.name', 'Laravel') }} - {{ $title or config('app.name', 'Laravel')}}</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css"  href="{{ asset('/css/app.css') }}" >

    <style>
        body{background-color:#282C34;}
        .navbar {box-shadow:0px 5px 10px #626262;}
        #page-body{padding-top:65px;}
        .navbar-right{margin-right: 0px;}
        .shadow {box-shadow:1px 1px 5px #929292;}       /*设置阴影*/
        #powerby{text-align: center;height:30px;line-height: 30px;margin: 30px 0px;}
        footer{background:#222;padding:20px;}

        .nav.navbar-nav .wechat_login {text-align: center;color:#DFDFDF;padding: 4px 15px;margin: 10px 5px;border: 1px solid #44b549;border-radius: 5px;background-color: #33a438;}
        .nav.navbar-nav .github_login {text-align: center;color:#FFF;padding: 4px 15px;margin: 10px 0px 10px 5px;border: 1px solid #bbbbbb;border-radius: 5px;background-color: #999999;}
        .nav.navbar-nav .wechat_login:hover{background-color: #44b549;color:#FFF}
        .nav.navbar-nav .github_login:hover{background-color: #bbbbbb;color:#FFF}
        .list-group-item:first-child{border-radius: 0px;}
        .list-group-item:last-child{border-radius: 0px;}
    </style>

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
                    <a class="navbar-brand hidden-xs" href="index.html">{{ config('app.name', 'Laravel') }}</a>
                    
                </div>
                <!-- /.navbar-header -->
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    </ul>
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="" class="wechat_login"><b class="fa fa-weixin"></b> 登录</a></li>
                        <li><a href="{{ route('auth.github') }}" class="github_login"><b class="fa fa-github-alt"></b> 登录</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-body">
            <div class="container">
                <div class="col-lg-9 pd-right main-col">
                    <div class="list-group shadow">
                        <a href="#" class="list-group-item pjax-element">
                            这是标题<span class="badge">14</span>
                        </a>
                        <a href="#" class="list-group-item pjax-element">
                            这是标题<span class="badge">14</span>
                        </a>
                        <a href="#" class="list-group-item pjax-element">
                            这是标题<span class="badge">14</span>
                        </a>
                        <a href="#" class="list-group-item pjax-element">
                            这是标题<span class="badge">14</span>
                        </a>
                        <a href="#" class="list-group-item pjax-element">
                            这是标题<span class="badge">14</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="shadow">asdfasdfasdf</div>
                </div>
            </div>
        </div>
        
        <div id="powerby">
            <div class="container">
                <div class="shadow">
                    power by Smallnews
                </div>
            </div>
        </div>
        
        <footer class="footer">
            <div class="container">
                <div class="row">
                    as;dlkfja;slkdfja;lksd
                </div>
            </div>
        </footer>
        
        <!-- 进度条 -->
        <vue-progress-bar></vue-progress-bar>
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>

</body>
</html>
