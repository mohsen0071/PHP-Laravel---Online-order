@extends('Admin.master')
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
                            <form action="{{ route('shippings.store') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <div class="ibox float-e-margins">
                                <div class="row m-b-md">
                                    <div class="col-sm-2">
                                        @can('add-shipping')
                                        <div class="form-group">
                                            <select name="shipping_way" id="shipping_way" class="form-control">
                                                <option value="">روش ارسال</option>
                                                <option value="1" {{old('shipping_way') == 1 ? 'selected' : ''}}>باربری</option>
                                                <option value="2" {{old('shipping_way') == 2 ? 'selected' : ''}}>ترمینال</option>
                                            </select>
                                        </div>
                                        @endcan
                                    </div>
                                    <div class="col-sm-2">
                                        @can('add-shipping')
                                        <div class="form-group">
                                            <input type="text" value="{{old('shipping_name')}}" name="shipping_name" placeholder="نام باربری یا ترمینال" id="shipping_name" class="form-control">
                                        </div>
                                        @endcan
                                    </div>
                                    <div class="col-sm-2">
                                        @can('add-shipping')
                                        <div class="form-group">
                                            <input type="text" value="{{old('shipping_number')}}" name="shipping_number" placeholder="شماره بارنامه" id="shipping_number" class="form-control">
                                        </div>
                                        @endcan
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            @can('add-shipping')
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-truck"></i>
                                                ثبت ارسال کار</button>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="col-sm-3 text-left">
                                        <div class="btn-group">
                                            <a href="/admin/shippings" class="btn  {{ request('status') == '' ? 'btn-primary' : 'btn-white' }}">همه</a>
                                            <a href="?status=1" class="btn  {{ request('status') == '1' ? 'btn-primary' : 'btn-white' }}">ارسال نشده</a>
                                            <a href="?status=2" class="btn  {{ request('status') == '2' ? 'btn-primary' : 'btn-white' }}">ارسال شده</a>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th><div class="i-checks all" data-title="order"><label> <input type="checkbox" value=""> <i></i>   </label></div>
                                        </th>
                                        <th>ردیف</th>
                                        <th> نام مشتری</th>
                                        <th> موجودی حساب</th>
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
                                            <td>
                                                <div class="i-checks order"><label> <input type="checkbox" name="ship_id[]" value="{{$ship->id}}"> <i></i>  </label></div>
                                            </td>
                                            <td><?php
                                                $pos++;

                                                if(isset($_GET['page']))
                                                    $pageNumber = $_GET['page'];
                                                else
                                                    $pageNumber = 1;

                                                echo (($pageNumber * 50) + $pos) - 50;
                                                ?></td>

                                            <td>{{$ship->client->name}}</td>
                                            <td>
                                                @if($ship->client->balance > 0)
                                                    {!!'<span class="label  label-primary lbl-price">'.number_format($ship->client->balance).' </span>' !!}
                                                @elseif($ship->client->balance < 0)
                                                    {!!  '<span class="label label-danger lbl-price">'.number_format($ship->client->balance).'</span>'  !!}
                                                @else
                                                    {{number_format($ship->client->balance)}}
                                                @endif
                                            </td>
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