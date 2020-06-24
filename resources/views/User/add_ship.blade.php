@extends('User.master')
@section('title', '  درخواست ارسال کار جدید ')
@section('content')
@section('style')
    <link href="/css/persian-datepicker.min.css" rel="stylesheet">
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2 class="pagetitle"> درخواست ارسال کار  جدید</h2>

    </div>
    <div class="col-sm-8">
        <div class="title-action">


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
                            @include('Admin.section.errors')
                            <form action="{{ route('user.addShipStore') }}" method="post" enctype="multipart/form-data">
                            <div class="ibox float-e-margins">
                                @if($checkProfile)
                                <div class="row">

                                        {{ csrf_field() }}
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <select name="shipping_way" id="shipping_way" class="form-control">
                                                    <option value="">روش ارسال</option>
                                                    <option value="1" {{old('shipping_way') == 1 ? 'selected' : ''}}>باربری</option>
                                                    <option value="2" {{old('shipping_way') == 2 ? 'selected' : ''}}>ترمینال</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <input type="text" value="{{old('shipping_name')}}" name="shipping_name" placeholder="نام باربری یا ترمینال پیشنهادی را وارد کنید" id="shipping_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">

                                                <button type="submit" class="btn btn-primary">
           <i class="fa fa-plus"></i>
                                                    ثبت درخواست</button>

                                            </div>
                                        </div>

                                </div>
                                @else
                                    <div class="alert alert-danger">
                                       برای ارسال درخواست باید اطلاعات پروفایل خود را تکمیل کنید.
                                        <a class="alert-link" href="/user/edit">ویرایش پروفایل</a>
                                    </div>
                                @endif
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th><div class="i-checks all" data-title="order"><label> <input type="checkbox" value=""> <i></i>   </label></div>
                                        </th>
                                        <th>ردیف</th>
                                        <th> نام کار</th>
                                        <th> تصویر</th>
                                        <th>شماره فاکتور</th>
                                        <th>دسته بندی </th>
                                        <th>  وضعیت </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $pos=0;   ?>
                                        @foreach($orders as $order)

                                        @if(!$order->statusRequest)
                                        <tr>
                                            <td>
                                                <div class="i-checks order"><label> <input type="checkbox" name="order_id[]" value="{{$order->id}}"> <i></i>  </label></div>
                                            </td>
                                            <td><?php
                                                $pos++;

                                                if(isset($_GET['page']))
                                                    $pageNumber = $_GET['page'];
                                                else
                                                    $pageNumber = 1;

                                                echo (($pageNumber * 50) + $pos) - 50;
                                                ?></td>
                                            <td>{{$order->name}}</td>
                                            <td><img src="{{$order->images['front']['100']}}" alt=""></td>
                                            <td>{{$order->order_number}}</td>
                                            <td>{{ $order->category->name }} - {{ $order->product->name }}</td>
                                            <td>
                                                @if($order->status_sheets == 1)
                                                    <small class="label label-default">در انتظار فرم بندی</small>
                                                @elseif($order->status_sheets == 2)
                                                    <small class="label label-warning">فرم بندی و لیتوگرافی</small>
                                                @elseif($order->status_sheets == 3)
                                                    <small class="label label-info">چاپ</small>
                                                @elseif($order->status_sheets == 4)
                                                    <small class="label label-success">برش و بسته بندی</small>
                                                @elseif($order->status_sheets == 5)
                                                    <small class="label label-primary">آماده تحویل</small>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>

                                {!! $orders->render() !!}
                            </div>
                            </form>
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
    <script src="/js/icheck.min.js"></script>
    <script>

        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });


            $('.i-checks').on('ifChecked', function(event){
                var data = $(this).data('title');
                if(data && data != 'undefined'){
                    if(data == 'all'){
                        $('.i-checks').iCheck('check');
                    }else {
                        $('.i-checks.' + data).iCheck('check');
                    }
                }

            });
            $('.i-checks').on('ifUnchecked', function(event){
                var data = $(this).data('title');
                if(data && data != 'undefined'){
                    if(data == 'all'){
                        $('.i-checks').iCheck('uncheck');
                    }else{
                        $('.i-checks.'+data).iCheck('uncheck');
                    }
                }
            });


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