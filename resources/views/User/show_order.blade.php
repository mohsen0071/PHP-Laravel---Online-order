@extends('User.master')
@section('title', ' جزئیات سفارش')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">
                جزئیات سفارش
            </h2>

        </div>
        <div class="col-sm-8">

        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            <dic class="col-lg-12">
                                <h3>
                                    <b>
                                        شماره  سفارش:
                                    </b>
                                    <span class="text-info"> {{$orders->order_number}} </span>
                                    -

                                    عنوان سفارش :
                                    <span class="text-info">  {{$orders->name}} </span>
                                </h3>
                            </dic>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h4>مشخصات سفارش دهنده</h4>
                                <p>

                                    <b>
                                        نام مشتری :
                                    </b>
                                    {{ $client->name }}
                                </p>
                                <p>

                                    <b>
                                        شماره همراه :
                                    </b>
                                    {{ $client->mobile }}
                                </p>
                                <p>

                                    <b>
                                        تلفن ثابت :
                                    </b>
                                    {{ $client->tel }}
                                </p>
                                <p>

                                    <b>
                                        ایمیل :
                                    </b>
                                    {{ $client->email }}
                                </p>
                                <p>

                                    <b>
                                        آدرس :
                                    </b>
                                    {{ $client->address }}
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <p>

                                    <b>
                                        تاریخ ثبت :
                                    </b>
                                    <?php $v = new Verta($orders->created_at); echo $v->format('H:i - Y/n/j')  ?>
                                </p>
                                <p>

                                    <b>
                                        وضعیت پرداخت :
                                    </b>
                                <td>{!! $orders->status == 1 ? '<small class="label label-primary">تایید شده</small>' : '<small class="label label-danger">تایید نشده </small>' !!}</td>

                                </p>

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?php $dpiStatus = false; $quality = false; ?>
                        @foreach ($orders->images as $key => $image)
                            @if(isset($image['dpi']))
                                @if($image['dpi']['x'] < 300 || $image['dpi']['y'] < 300)
                                    <?php  $dpiStatus = true; ?>
                                @endif
                                @if($image['dpi']['cmyk'] != 4)
                                    <?php  $quality = true; ?>
                                @endif
                            @endif

                        @endforeach
                        {!! $quality == true ? '<div class="alert alert-danger">  <b>                              فایل شما به صورت آر جی بی ارسال شد و این مجموعه مسئولیتی در قبال تغییر رنگ احتمالی نخواهد داشت .                </b>            </div>' : '' !!}
                        {!! $dpiStatus == true ? '<div class="alert alert-danger">
                         <b>
                                فایل ارسالی شما کیفیت لازم برای چاپ را ندارد ، فایل شما باید 300 دی پی آی باشد و این مجموعه بابت کیفیت چاپ این سفارش مسئولیتی نخواهد داشت .
 </b>
                            </div>' : '' !!}
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th colspan="2"><h4>شرح سفارش</h4></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td width="30%">نوع سفارش</td>
                                        <td>{{ $orders->category->name }} - {{ $orders->product->name }}</td>
                                    </tr>
                                    <tr>
                                        <td> تیراژ</td>
                                        <td>{{ number_format($orders->range) }}</td>
                                    </tr>
                                    <tr>
                                        <td> فوری</td>
                                        <td>{!! $orders->urgent == 1 ? '<small class="label label-primary">دارد</small>' : '' !!}</td>
                                    </tr>
                                    <tr>
                                        <td> وضعیت سفارش</td>
                                        <td>
                                            @if($orders->status_sheets == 1)
                                                <small class="label label-default">در انتظار فرم بندی</small>
                                            @elseif($orders->status_sheets == 2)
                                                <small class="label label-warning">فرم بندی و لیتوگرافی</small>
                                            @elseif($orders->status_sheets == 3)
                                                <small class="label label-info">چاپ</small>
                                            @elseif($orders->status_sheets == 4)
                                                <small class="label label-success">برش و بسته بندی</small>
                                            @else
                                                <small class="label label-primary">آماده تحویل</small>
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <td> هزینه طراحی</td>
                                        <td>{{ number_format($orders->price_design) }}</td>
                                    </tr>
                                    <tr>
                                        <td>  توضیحات</td>
                                        <td>{{ ($orders->body) }}</td>
                                    </tr>
                                    <tr>
                                        <td>  طول</td>
                                        <td>{{ ($orders->length) }}</td>
                                    </tr>
                                    <tr>
                                        <td>  عرض</td>
                                        <td>{{ ($orders->width) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                @if($allPservice)
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th colspan="2"><h4>شرح خدمات چاپ</h4></th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td width="30%">خدمات</td>
                                            <td>{!! $allPservice !!}</td>
                                        </tr>
                                        <tr>
                                            <td>مبلغ</td>
                                            <td>{{ number_format($allPservicePrice) }}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                @endif
                                <h4>فایل ها</h4>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @foreach ($orders->images as $key => $image)

                                            <td style="font-weight: bold; text-align: center">
                                                @if(($key) === 'front')
                                                    <p> طرح رو</p>
                                                @endif
                                                @if(($key) === 'back')
                                                    <p> طرح پشت</p>
                                                @endif
                                                @if(($key) === 'uvfront')
                                                    <p>یووی روی طرح</p>
                                                @endif
                                                @if(($key) === 'uvback')
                                                    <p>یووی پشت طرح</p>
                                                @endif
                                                @if(($key) === 'goldfront')
                                                    <p>طلاکوب روی طرح</p>
                                                @endif
                                                @if(($key) === 'goldback')
                                                    <p> طلاکوب پشت طرح</p>
                                                @endif
                                                <img src="{{ $image['100'] }}" alt="">
                                            </td>



                                        @endforeach
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-info">
                                    <h3>  <b>هزینه طراحی : </b> {{ number_format($orders->price_design) }} </h3>
                                    <h3>  <b>  خدمات چاپ : </b> {{ number_format($pservicePrice) }} </h3>
                                    <h3>  <b> مبلغ سفارش : </b> {{ number_format($productPrice) }} </h3>
                                    <div class="hr-line-dashed"></div>
                                    <h3 class="text-green">  <b> مبلغ نهایی : </b> {{ number_format($pservicePrice + $productPrice + $orders->price_design) }} </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection