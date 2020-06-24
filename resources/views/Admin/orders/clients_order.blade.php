@extends('Admin.master')
@section('title', ' سفارشات مشتری')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">  مشتری : {{$client->name}}</h2>

        </div>
        <div class="col-sm-8">

        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class=""><a  href="/admin/clients/{{$client->id}}/edit"> <h3 class="m-b-none">پروفایل</h3></a></li>
                        @can('add-order-client')
                        <li class=""><a  href="/admin/clients/{{$client->id}}/order"> <h3 class="m-b-none">ثبت سفارش</h3></a></li>
                        @endcan
                        <li class="active"><a  href="/admin/clients/{{$client->id}}/client-order"> <h3 class="m-b-none"> سفارشات </h3></a></li>
                        <li class=""><a  href="/admin/clients/{{$client->id}}/client-cheques"> <h3 class="m-b-none">  چک ها و فیش ها </h3></a></li>
                        <li class=""><a  href="/admin/clients/{{$client->id}}/client-transactions"> <h3 class="m-b-none"> تراکنش ها </h3></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="ibox float-e-margins">
                                    <div class="row m-b-md">
                                        <div class="col-sm-3">
                                            <form action="" method="get">
                                                <div class="input-group">
                                                    <input type="text" placeholder="جستجو" name="search" value="{{ old('search') }}" class="input-sm form-control">
                                                    <span class="input-group-btn">
                                            <button type="submit" class="btn btn-sm btn-primary"> برو!</button>
                                        </span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th></th>
                                            <th>شماره سفارش</th>
                                            <th>عنوان سفارش</th>
                                            <th>نوع سفارش</th>
                                            <th> وضعیت</th>
                                            <th> فوری</th>
                                            <th> توسط</th>
                                            <th> تاریخ</th>
                                            <th> وضعیت سفارش</th>

                                            <th> </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $pos=0;   ?>

                                        @foreach($orders as $order)
                                            <?php $dpiStatus = false; ?>
                                            @foreach ($order->images as $key => $image)
                                                @if(isset($image['dpi']))
                                                    @if($image['dpi']['x'] != '300' || $image['dpi']['y'] != '300')
                                                      <?php  $dpiStatus = true; ?>
                                                    @endif
                                                @endif

                                            @endforeach


                                            <tr class="{{ $dpiStatus == true ? 'alert alert-danger' : '' }}">
                                               <td>
                                                    <?php
                                                    $pos++;

                                                    if(isset($_GET['page']))
                                                        $pageNumber = $_GET['page'];
                                                    else
                                                        $pageNumber = 1;

                                                    echo (($pageNumber * 50) + $pos) - 50;
                                                    ?>
                                                </td>
                                                <td>{!! $dpiStatus == true ? '<small class="label label-danger">  dpi ≠ 300 </small>' : '' !!}</td>
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->category->name }} - {{ $order->product->name }}</td>
                                                <td>{!! $order->status == 1 ? '<small class="label label-primary">پرداخت شده</small>' : '<small class="label label-danger">پرداخت نشده </small>' !!}</td>
                                                <td>{!! $order->urgent == 1 ? '<small class="label label-primary">دارد</small>' : '' !!}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td><?php $v = new Verta($order->created_at); echo $v->format('H:i - Y/n/j')  ?></td>
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
                                                <td>
                                                    <form action="{{ route('orders.destroy'  , ['id' => $order->id]) }}" data-title="{{$order->id}}" method="post" class="tooltip-demo frm{{$order->id}}">
                                                        {{ method_field('delete') }}
                                                        {{ csrf_field() }}
                                                    <a href="{{ route('orders.show' , ['id' => $order->id]) }}"  target="_blank" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="نمایش سفارش">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    {{--<a href="{{ route('orders.edit' , ['id' => $order->id]) }}"  target="_blank" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش سفارش">--}}
                                                        {{--<i class="fa fa-edit"></i>--}}
                                                    {{--</a>--}}

                                                        <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$order->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button>

                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {!! $orders->render() !!}

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