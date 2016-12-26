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

    <title>{{ config('app.name', 'Laravel') }} - @yield('title') - 控制台</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css"  href="{{ asset('/css/app.css') }}" >
    <link rel="stylesheet" type="text/css"  href="{{ asset('/css/all.css') }}" >

    <!-- Scripts -->
    <script type="text/javascript">
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!}
    </script>
</head>
<body>
    @yield('content')
    
    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>

    <script type="text/javascript">
    
        @section('script')
            var Vm = new Vue({
                el : '#wrapper',
            });
        @endsection
        
        @yield('script')
    </script>
    
</body>
</html>
