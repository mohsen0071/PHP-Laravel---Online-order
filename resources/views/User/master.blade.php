<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.rtl.css" rel="stylesheet">
    <link href="/css/sweetalert.css" rel="stylesheet">
    <link href="/css/icheck.css" rel="stylesheet">
    @yield('style')
</head>
<body class="">
<div id="wrapper">
    @include('User.sidebar')
    <div id="page-wrapper" class="gray-bg">
        @include('Admin.section.header')
        @yield('content')
    </div>
</div>
<!-- Mainly scripts -->
<script src="/js/jquery-2.1.1.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.metisMenu.js"></script>
<script src="/js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<script src="/js/rada.js"></script>
<script src="/js/pace.min.js"></script>
@yield('script')
<div class="mloading">
    <div class="ibox-content">
        <div class="spiner-example">
            <div class="sk-spinner sk-spinner-double-bounce">
                <div class="sk-double-bounce1"></div>
                <div class="sk-double-bounce2"></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>