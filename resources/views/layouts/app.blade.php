<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.rtl.css" rel="stylesheet">
    <link href="/css/icheck.css" rel="stylesheet">

</head>

<body class="bg-user">

<div class="loginColumns animated fadeInDown">


            <div class="ibox-content">
            <p class="text-center m-t">
                <img src="{{ $settings->images["images"]["original"] }}" alt=""></p>

            <h3 class="font-bold text-center">
                {{$settings->name}}
                </h3>

            <p class="text-center">
                سامانه مدیریت سفارشات
            </p>
            @yield('content')
            </div>
</div>

<!-- Mainly scripts -->
<script src="/js/jquery-2.1.1.js"></script>
<script src="/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/js/icheck.min.js"></script>
<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

    });
</script>
</body>
</html>
