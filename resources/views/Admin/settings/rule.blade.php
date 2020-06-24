<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>قوانین سایت</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.rtl.css" rel="stylesheet">
    <link href="/css/icheck.css" rel="stylesheet">

</head>

<body>


    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <h2 class="text-center">
                                    <b>
                                    قوانین سایت
                                    </b>  </h2>
                                {!! $settings->rules !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>

        </div>
    </div>
    </div>


</body>
</html>
