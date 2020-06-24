@extends('User.master')
@section('title', 'پیشخوان')
@section('content')

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <a href="/user/transactions" style="color:#676a6c">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                                    <span class="label label-success pull-left">
                                    ریال</span>
                        <h5>
                           موجودی حساب شما</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins text-center {{ auth()->user()->balance > 0 ? 'text-green-n' : 'text-danger' }}" style="direction: ltr">
                          <b> {{ number_format(auth()->user()->balance) }}</b>
                        </h1>

                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="/user/all-order" style="color:#676a6c">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                                    <span class="label label-primary pull-left">
                                    کل</span>
                        <h5>
                          سفارش های پرداخت شده</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins text-center">
                          <b> {{$order_paid}}</b>
                        </h1>

                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="/user/all-order" style="color:#676a6c">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                                    <span class="label label-danger pull-left">
                                    کل</span>
                        <h5>
                            سفارش های پرداخت نشده</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins text-center">
                          <b>  {{$order_unpaid}}</b>
                          </h1>

                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="/user/pinquiries" style="color:#676a6c">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                                    <span class="label label-primary pull-left">
                                   کل</span>
                        <h5>
                            سفارش های استعلامی  </h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins text-center">
                          <b> {{$pinquiries}}</b>
                        </h1>

                    </div>
                </div>
                </a>
            </div>
        </div>
        @if(count($notifs) > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info">
                    <h2>اطلاعیه ها</h2>
                    @foreach($notifs as $notif)
                       <p>
                           <span><?php $v = new Verta($notif->created_at); echo $v->format('Y/m/j')  ?></span>
                           -
                        <a href="{{ route('user.singleNotif', ['id' => $notif->id]) }}" class="alert-link">{{$notif->title}}</a>
                       </p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
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
                                <tr>
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
                                        <a href="{{ route('user.showorder' , ['id' => $order->id]) }}"  target="_blank" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="نمایش سفارش">
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

    </div>
@endsection