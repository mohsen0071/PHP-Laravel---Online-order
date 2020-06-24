@extends('User.master')
@section('title', ' سفارشات ')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">سفارشات</h2>

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
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="row">
                                        <div class="col-lg-3">

                                            <button class="btn btn-primary btn-lg"  onclick="payment()">

                                                پرداخت سفارشات
                                                <i class="fa fa-arrow-left"></i>
                                            </button>
                                            <input type="hidden" id="allSum" value="0">
                                            <input type="hidden" id="allDiscoount" value="0">
                                            <input type="hidden" id="userBalance" value="{{intval(auth()->user()->balance)}}">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <form action="{{ route('user.payment')}}" id="frmPayment"   method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>ردیف</th>
                                            <th>قیمت کل</th>
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
                                                    @if($order->status == 0)
                                                        <div class="i-checks order" data-price="{{$order->rowPrice}}" data-discount="{{$order->discount !='' ? $order->discount : 0}}"><label> <input type="checkbox" name="order_id[]" value="{{$order->id}}"> <i></i>  </label></div>
                                                    @endif
                                                </td>

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
                                                <td>{{ number_format($order->rowPrice) }}</td>
                                                <td>{!! $dpiStatus == true ? '<small class="label label-danger">  dpi ≠ 300 </small>' : '' !!}</td>
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->category->name }} - {{ $order->product->name }}</td>
                                                <td>{!! $order->status == 1 ? '<small class="label label-primary">پرداخت شده</small>' : '<small class="label label-danger">پرداخت نشده </small>' !!}</td>
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

                                                        <a href="{{ route('user.showorder' , ['id' => $order->id]) }}"  target="_blank" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="نمایش سفارش">
                                                            <i class="fa fa-eye"></i>
                                                        </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    </form>
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
    <div class="modal inmodal fade" id="pay" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="padding-top: 10px; padding-bottom: 10px">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">بستن</span></button>
                    <h2 class="font-bold">پرداخت سفارش</h2>
                </div>
                <div class="modal-body">
                    <h4 style="line-height:30px">
                        مجموع سفارش های انتخاب شده برابر  با
                        <span id="sumAllText" class="text-green" style="font-size: 20px"></span>
                        ریال است. اگر مورد تأیید است بر روی پرداخت کلیک کنید.
                    </h4>
                    <h4 id="boxUserDiscount">
مجموع تخفیف های شما
                        <span class="text-danger" style="font-size: 20px"></span>
                        ریال          می باشد.

                    </h4>
                    <h4 id="boxUserBalance">
                        موجودی حساب شما
                        <span class="text-success" style="font-size: 20px"></span>
              ریال          می باشد.

                    </h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" style="float: right;" data-dismiss="modal">انصراف</button>
                    <button class="btn btn-success" id="btnPaymentAcount" onclick="$('#frmPayment').attr('action','/user/payment-account'); $('#frmPayment').submit()">پرداخت از طریق موجودی حساب</button>
                    <button type="button" class="btn btn-primary" onclick="$('#frmPayment').submit()"> پرداخت آنلاین </button>
                </div>
            </div>
        </div>
    </div>
@section('script')

    <script src="/js/icheck.min.js"></script>
    <script>

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }


        function payment()
        {
            var allSum = $('#allSum').val();
            var allDiscoount = $('#allDiscoount').val();
            var userBalance = $('#userBalance').val();

            if(allSum == 0){
                alert('شما باید حداقل یک سفارش را برای پرداخت انتخاب کنید!');
            }else{

                if(parseInt(userBalance) >= parseInt(allSum)){
                    $('#btnPaymentAcount').show();
                    $('#boxUserBalance').show();
                }else{
                    $('#btnPaymentAcount').hide();
                    $('#boxUserBalance').hide();
                }

                if(parseInt(allDiscoount) > 0){
                    $('#boxUserDiscount').show();
                    $('#boxUserDiscount span').text(numberWithCommas(allDiscoount));
                }else{
                    $('#boxUserDiscount').hide();
                }


                $('#sumAllText').text(numberWithCommas(allSum));
                $('#boxUserBalance span').text(numberWithCommas(userBalance));


                $('#pay').modal('show')
            }


        }
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('.i-checks').on('ifChecked', function(event){
                var price = $(this).data('price');
                var discount = $(this).data('discount');
                var allSum = $('#allSum').val();
                var allDiscoount = $('#allDiscoount').val();
                $('#allSum').val(parseInt(allSum) + parseInt(price));
                $('#allDiscoount').val(parseInt(allDiscoount) + parseInt(discount));
            });

            $('.i-checks').on('ifUnchecked', function(event){
                var price = $(this).data('price');
                var discount = $(this).data('discount');
                var allSum = $('#allSum').val();
                var allDiscoount = $('#allDiscoount').val();
                $('#allSum').val(parseInt(allSum) - parseInt(price));
                $('#allDiscoount').val(parseInt(allDiscoount) - parseInt(discount));
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