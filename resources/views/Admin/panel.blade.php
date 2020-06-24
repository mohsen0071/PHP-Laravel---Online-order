@extends('Admin.master')
@section('title', 'پیشخوان')
@section('content')

{{--<div class="row wrapper border-bottom white-bg page-heading">--}}
    {{--<div class="col-sm-4">--}}
        {{--<h2 class="pagetitle">پیشخوان</h2>--}}

    {{--</div>--}}
    {{--<div class="col-sm-8">--}}
        {{--<div class="title-action">--}}
            {{--<a href="#" class="btn btn-primary">--}}
                {{--لورم ایپسوم</a>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

<div class="wrapper wrapper-content">
    <div class="row">
        @can('list-client')
        <div class="col-lg-3">
            <a href="/admin/clients" style="color:#676a6c">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                                    <span class="label label-success pull-left">
                                    کل</span>
                    <h5>
                        تعداد کاربران</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins text-center">
                    <b>{{$count_client}}</b>  </h1>

                </div>
            </div>
            </a>
        </div>
        @endcan
            @can('list-user')
        <div class="col-lg-3">
            <a href="/admin/users" style="color:#676a6c">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                                    <span class="label label-info pull-left">
                                    کل</span>
                    <h5>
                        تعداد کارمندان</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins text-center">
                    <b>{{$count_employee}}</b>  </h1>

                </div>
            </div>
            </a>
        </div>
            @endcan
            @can('list-order')
        <div class="col-lg-3">
            <a href="/admin/orders" style="color:#676a6c">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                                    <span class="label label-primary pull-left">
                                    امروز</span>
                    <h5>
                       سفارشات</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins text-center">
                       <b> {{$count_order}}</b></h1>

                </div>
            </div>
            </a>
        </div>
            @endcan
            @can('list-transaction')
        <div class="col-lg-3">
            <a href="/admin/transactions" style="color:#676a6c">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                                    <span class="label label-danger pull-left">
                                   امروز</span>
                    <h5>
                      فروش (ریال)  </h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins text-center">
                                  <b> {{ number_format($final_day_price)  }}</b></h1>

                </div>
            </div>
            </a>
        </div>
            @endcan
    </div>
    @can('list-order')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>آخرین سفارشات</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>شماره سفارش</th>
                            <th>نام سفارش</th>
                            <th>نوع سفارش</th>
                            <th>وضعیت پرداخت</th>
                            <th>وضعیت سفارش</th>
                            <th>تاریخ ثبت</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
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
                                <td>{!! $dpiStatus == true ? '<small class="label label-danger">  dpi ≠ 300 </small>' : '' !!}</td>

                                <td>{{ $order->order_number }}</td>

                                <td>{{ $order->name }}</td>
                                <td>{{ $order->category->name }}</td>
                                <td>{!! $order->status == 1 ? '<small class="label label-primary">پرداخت شده</small>' : '<small class="label label-danger">پرداخت نشده </small>' !!}</td>
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
                                <td><?php $v = new Verta($order->created_at); echo $v->format('H:i - Y/n/j')  ?></td>
                                <td>
                                    <a href="{{ route('orders.show' , ['id' => $order->id]) }}"   target="_blank" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="نمایش سفارش">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endcan
    {{--<div class="row">--}}
        {{--<div class="col-lg-12">--}}
            {{--<div class="ibox float-e-margins">--}}
                {{--<div class="ibox-title">--}}
                    {{--<h5>گزارش فروش ماه--}}
                        {{--<small>به صورت روزانه</small>--}}
                    {{--</h5>--}}
                    {{--<div ibox-tools=""></div>--}}
                {{--</div>--}}
                {{--<div class="ibox-content">--}}
                    {{--<div>--}}
                        {{--<canvas id="lineChart" height="332" width="712" style="width: 570px; height: 266px;"></canvas>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
@section('script')
    {{--<script src="/js/Chart.min.js"></script>--}}
    {{--<script src="/js/chartjs-demo.js"></script>--}}
@endsection
@endsection