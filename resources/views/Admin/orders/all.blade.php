@extends('Admin.master')
@section('title', ' سفارشات مشتری')
@section('content')
@section('style')
    <link href="/css/persian-datepicker.min.css" rel="stylesheet">
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> سفارشات </h2>

        </div>
        <div class="col-sm-8">

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
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3 text-left">
                                            <div class="btn-group">
                                                <a href="?status=" class="btn  {{ request('status') == '' ? 'btn-primary' : 'btn-white' }}">همه</a>
                                                <a href="?status=1" class="btn  {{ request('status') == '1' ? 'btn-primary' : 'btn-white' }}">تایید شده</a>
                                                <a href="?status=2" class="btn  {{ request('status') == '2' ? 'btn-primary' : 'btn-white' }}">تایید نشده</a>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th></th>
                                            <th>شماره سفارش</th>

                                            <th> نام مشتری</th>
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
                                                        <input type="hidden" id="sumAllInput" value="{{$order->sumAll}}">

                                                </td>
                                                <td>{!! $dpiStatus == true ? '<small class="label label-danger">  dpi ≠ 300 </small>' : '' !!}</td>
                                                <td>{{ $order->order_number }}</td>

                                                <td>{{ $order->client_name }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->category->name }} - {{ $order->product->name }}</td>
                                                <td>{!! $order->status == 1 ? '<small class="label label-primary">تایید شده</small>' : '<small class="label label-danger">تایید نشده </small>' !!}</td>
                                                <td>{!! $order->urgent == 1 ? '<small class="label label-primary">دارد</small>' : '' !!}</td>

                                                <td>
                                                    @if($order->user->id == $order->client->id)
                                                        <small class="label label-success">سفارش آنلاین</small>
                                                    @else
                                                        <small class="label label-info">سفارش حضوری</small>
                                                    @endif
                                                </td>


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
                                                    <form action="{{ route('orders.destroy'  , ['id' => $order->id]) }}" data-title="{{$order->id}}" method="post" class="text-left tooltip-demo frm{{$order->id}}">
                                                        {{ method_field('delete') }}
                                                        {{ csrf_field() }}

                                                        <a href="/admin/print/{{$order->id }}"  target="_blank" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="چاپ فاکتور">
                                                            <i class="fa fa-print"></i>
                                                        </a>

                                                        @can('refresh-file')
                                                        <a href="{{ route('orders.editFiles' , ['id' => $order->id]) }}"  target="_blank" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش فایل ها">
                                                            <i class="fa fa-refresh"></i>
                                                        </a>
                                                        @endcan
                                                        @if($order->status == 0)
                                                            @if($order->user->id != $order->client->id)
                                                                @can('add-pay-order')
                                                                <a class="btn btn-primary btn-xs" data-toggle="modal" onclick="viewAddTransaction('{{$order->client_name}}','{{ $order->category->name }} - {{ $order->product->name }}','{{ $order->order_number }}','{{$order->sumAll}}','{{ auth()->user()->id }}','{{ $order->id }}','{{$order->sumAll}}','{{$order->client_id}}')" data-target="#transaction" title="پرداخت سفارش">
                                                                    <i class="fa fa-money"></i>
                                                                </a>
                                                                @endcan
                                                            @endif
                                                        @endif
                                                        <a href="{{ route('orders.show' , ['id' => $order->id]) }}"  target="_blank" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="نمایش سفارش">
                                                            <i class="fa fa-eye"></i>
                                                        </a>



                                                        {{--<a href="{{ route('orders.edit' , ['id' => $order->id]) }}"  target="_blank" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش سفارش">--}}
                                                        {{--<i class="fa fa-edit"></i>--}}
                                                        {{--</a>--}}

                                                        @if($order->status_sheets <= 1)
                                                            @can('delete-order')
                                                            <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$order->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button>
                                                            @endcan
                                                        @endif
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
    <div class="modal inmodal fade" id="transaction" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="padding-top: 10px; padding-bottom: 10px">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">بستن</span></button>
                    <span class="font-bold">افزودن وجه  سفارش</span>
                </div>
                <div class="modal-body">
                    <form action="{{ route('transactions.store')}}" method="post" id="frmTransaction">
                        {{ csrf_field() }}

                        <input type="hidden" id="user_id" name="user_id">
                        <input type="hidden" id="order_id" name="order_id">
                        <input type="hidden" id="client_id" name="client_id">
                        <input type="hidden" id="price" name="price">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td width="30%"><strong>شماره سفارش</strong></td>
                            <td><span id="orderNumber"></span></td>
                        </tr>
                        <tr>
                            <td><strong>نام مشتری</strong></td>
                            <td><span id="clientName"></span></td>
                        </tr>

                        <tr>
                            <td><strong>عنوان سفارش</strong></td>
                            <td><span id="orderTitle"></span></td>
                        </tr>
                    </table>
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td width="30%"><h3><strong>جمع کل سفارش</strong></h3></td>
                            <td><h3 id="sumAll" class="text-green"></h3></td>
                        </tr>
                    </table>
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td width="30%"><strong>روش تسویه</strong></td>
                            <td>
                                <select name="payment_type" id="payment_type" onchange="changePaymentType(this.value)" class="form-control">
                                    <option value="">انتخاب روش تسویه</option>
                                    <option value="1">نقد</option>
                                    <option value="2">واریز به حساب</option>
                                    <option value="3">اعتباری</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-striped table-bordered table-hover d-none box-bank-type">
                        <tr>
                            <td width="30%"><strong>بانک</strong></td>
                            <td>
                                <select name="bank_type" id="bank_type" class="form-control">
                                    <option value="">انتخاب بانک</option>
                                    <option value="1">ملت</option>
                                    <option value="2">پاسارگاد</option>
                                    <option value="3">ملی</option>
                                    <option value="4">صادارت</option>
                                    <option value="5">سپه</option>
                                </select>
                            </td>
                        </tr>




                        <tr>
                            <td width="30%"><strong>روش واریز</strong></td>
                            <td>
                                <select name="payment_way" id="payment_way" class="form-control">
                                    <option value=""> انتخاب روش واریز</option>
                                    <option value="1">حواله</option>
                                    <option value="2">کارت به کارت</option>
                                    <option value="3">کارت خوان</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>تاریخ پرداخت</strong></td>
                            <td>
                                <div class="input-group date">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar">
                                                </i>
                                            </span>
                                    <input id="date_added" name="pay_date" autocomplete="off" type="text" class="form-control" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>شماره سند</strong></td>
                            <td>
                                <input type="text" id="proof_number" name="proof_number" class="form-control" placeholder="شماره سند">
                            </td>
                        </tr>
                    </table>

                    <table class="table table-striped table-bordered table-hover d-none box-deposit">
                        <tr>
                            <td width="30%"><strong>بیعانه</strong></td>
                            <td>
                                <input type="text" id="deposit" name="deposit"  onkeyup="threeDigitNumber(this)" class="form-control" placeholder=" بیعانه">
                            </td>
                        </tr>
                    </table>

                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td width="30%"><strong>تخفیف</strong></td>
                            <td>
                                <input type="text" id="discount" name="discount"  onkeyup="threeDigitNumber(this)" class="form-control" placeholder=" تخفیف">
                            </td>
                        </tr>
                    </table>
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td width="30%"><strong>توضیحات</strong></td>
                            <td>
                                <textarea id="body" name="body"  class="form-control" rows="4"></textarea>
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">بستن</button>
                    <button type="button" class="btn btn-primary" onclick="formSubmit()">افزودن وجه</button>
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

    <script>
        function threeDigitNumber(input)
        {
            var num=input.value.replace(/[^\d-]/g,'');
            if(num.length>3)
                num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
            input.value=num;

        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function changePaymentType(pType){
            $('#date_added').val('');
            if(pType == 2)
            {
                $('.box-bank-type').show();
            }else{
                $('.box-bank-type').hide();
            }

            if(pType == 3)
            {
                $('.box-deposit').show();
            }else{
                $('.box-deposit').hide();
            }

        }

        function viewAddTransaction(clientName,OrderTitle,orderNumber,sumAll,userId,orderId,price,clientId)
        {
            $('#price').val(price);
            $('#client_id').val(clientId);
            $('#user_id').val(userId);
            $('#order_id').val(orderId);
            $('#clientName').html(clientName);
            $('#orderTitle').html(OrderTitle);
            $('#orderNumber').html(orderNumber);
            $('#sumAll').html(numberWithCommas(sumAll) + ' ریال ');
        }


        function  formSubmit() {
            var deposit = $('#deposit').val();
            var numDeposit = deposit.replace(/,/g, "");
            if(numDeposit.length == 0){
                numDeposit = 0;
            }
            var discount = $('#discount').val();
            var numDiscount = discount.replace(/,/g, "");
            if(numDiscount.length == 0){
                numDiscount = 0;
            }
            var sumAllInput = $('#sumAllInput').val();

            var paymentType = $('#payment_type').val();

            if(paymentType.length == 0){
                alert('لطفا روش تسویه را انتخاب کنید');
                return false;
            }



            var paymentType = $('#payment_type').val();
            if(paymentType == 2){
                var bankType = $('#bank_type').val();
                if(bankType.length == 0){
                    alert('لطفا بانک را انتخاب کنید');
                    return false;
                }
                var paymentWay = $('#payment_way').val();
                if(paymentWay.length == 0){
                    alert('لطفا روش واریز را انتخاب کنید');
                    return false;
                }
                var dateAdded = $('#date_added').val();
                if(dateAdded.length == 0){
                    alert('لطفا تاریخ پرداخت را انتخاب کنید');
                    return false;
                }
                var proofNumber = $('#proof_number').val();
                if(proofNumber.length == 0){
                    alert('لطفا شماره سند را وارد کنید');
                    return false;
                }
            }



            if((parseInt(numDiscount)) > sumAllInput ) {
                alert('مبلغ تخفیف از جمع کل سفارش بیشتر است !');
                return false;
            }

            if((parseInt(numDeposit)) > sumAllInput ) {
                alert('مبلغ بیعانه از جمع کل سفارش بیشتر است !');
                return false;
            }

            if((parseInt(numDeposit) + parseInt(numDiscount)) > sumAllInput ) {
                alert('جمع بیعانه و تخفیف از جمع کل سفارش بیشتر است !');
                return false;
            }

            $('#frmTransaction').submit();

        }
    </script>
@endsection
@endsection