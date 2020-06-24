@extends('User.master')
@section('title', ' درخواست ارسال کار ')
@section('content')
@section('style')
    <link href="/css/persian-datepicker.min.css" rel="stylesheet">
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2 class="pagetitle"> درخواست ارسال کار </h2>

    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="{{ route('user.addShip') }}" class="btn  btn-primary">
                <i class="fa fa-truck"></i>
                درخواست ارسال کار جدید

            </a>

        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="ibox float-e-margins">
                                <div class="row m-b-md">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-3 text-left">
                                        <div class="btn-group">
                                            <a href="/user/all-ship" class="btn  {{ request('status') == '' ? 'btn-primary' : 'btn-white' }}">همه</a>
                                            <a href="?status=1" class="btn  {{ request('status') == '1' ? 'btn-primary' : 'btn-white' }}">ارسال نشده</a>
                                            <a href="?status=2" class="btn  {{ request('status') == '2' ? 'btn-primary' : 'btn-white' }}">ارسال شده</a>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>

                                        <th>ردیف</th>
                                        <th> نام کار</th>
                                        <th> تصویر</th>
                                        <th>شماره فاکتور</th>
                                        <th>  روش ارسال </th>
                                        <th>  نام باربری یا ترمینال </th>
                                        <th>  شماره بارنامه </th>
                                        <th>  تاریخ درخواست </th>
                                        <th>  وضعیت </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $pos=0;   ?>
                                    @foreach($shippings as $ship)
                                    <tr>

                                        <td><?php
                                            $pos++;

                                            if(isset($_GET['page']))
                                                $pageNumber = $_GET['page'];
                                            else
                                                $pageNumber = 1;

                                            echo (($pageNumber * 50) + $pos) - 50;
                                            ?></td>
                                        <td>{{$ship->order->name}}</td>
                                        <td><img src="{{$ship->order->images['front']['100']}}" alt=""></td>
                                        <td>{{$ship->order->order_number}}</td>
                                        <td>{{$ship->shipping_way == 1 ? 'باربری' : 'ترمینال'}}</td>
                                        <td>{{$ship->shipping_name}}</td>
                                        <td>{{$ship->shipping_number}}</td>
                                        <td><?php $v = new Verta($ship->created_at); echo $v->format('H:i - Y/m/d')  ?></td>

                                        <td>{!! $ship->shipping_number != '' ? '<small class="label label-primary">ارسال شده</small>' : '<small class="label label-danger">ارسال نشده  </small>' !!}</td>


                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {!! $shippings->render() !!}

                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

@section('script')
    <script src="/js/persian-date.js">
    </script>
    <script src="/js/persian-datepicker.min.js">
    </script>
    <script>
        $('#date_added').persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD'
        });
    </script>
    <script src="/js/sweetalert.min.js"></script>
    <script>
        function sweet(frm){
            swal({
                    title: "حذف",
                    text: "برای حذف مطمئن هستید؟",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "بله",
                    cancelButtonText: "خیر",
                    closeOnConfirm: false,
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $('.'+frm).submit();
                        //  swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    } else {
                        // swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
        }


    </script>
    @if (Session::has('sweet_alert.alert'))
        <script>
            swal({
                title : "{!! Session::get('sweet_alert.title') !!}",
                type: "{!! Session::get('sweet_alert.icon') !!}",
                confirmButtonColor: "#A5DC86",
                confirmButtonText: "متوجه شدم",
            });
        </script>
    @endif

@endsection
@endsection