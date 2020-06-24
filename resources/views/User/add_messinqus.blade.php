@extends('User.master')
@section('title', 'پاسخ به درخواست')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">پاسخ به درخواست</h2>

        </div>
        <div class="col-sm-8">

        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>پاسخ به درخواست:
                            {{ $title  }}
                        </h5>
                    </div>
                    <div class="ibox-content">
                        <div class="chat-discussion" style="height: auto">
                            @foreach($messInquries as $key => $messInqury)
                                <div class="chat-message {{  $messInqury->user->level == 'user' ? 'left' : 'right'}}">
                                    <img class="message-avatar" src="{{ ($messInqury->user->images) }}" alt="">
                                    <div class="message">
                                        <a class="message-author" href="#">
                                            {{$messInqury->user->name }} </a>
                                        <span class="message-date">
                                    <?php $v = new Verta($messInqury->created_at); echo $v->format('H:i - Y/n/j')  ?>

														</span>
                                        <span class="message-content">
                                        {!! $messInqury->body !!}
														</span>

                                        @if($messInqury->images != '')
                                            <a href="{{  $messInqury->images }}" download><i class="fa fa-paperclip"></i> فایل پیوست </a>
                                        @endif


                                        @if($messInqury->price != 0)
                                            <table class="table table-striped table-bordered table-hover" style="width: 40%">
                                                <tr>
                                                    <td width="50%">قیمت پیشنهادی:</td>
                                                    <td> {{ number_format($messInqury->price)}} ریال</td>
                                                </tr>
                                                <tr>
                                                    <td>تیراژ: </td>
                                                    <td> {{ number_format($messInqury->range)}} عدد</td>
                                                </tr>
                                                <tr>
                                                    <td>طول: </td>
                                                    <td> {{ ($messInqury->length)}} </td>
                                                </tr>
                                                <tr>
                                                    <td>عرض: </td>
                                                    <td> {{ ($messInqury->width)}} </td>
                                                </tr>
                                                <tr>
                                                    <td>بیعانه: </td>
                                                    <td>  {{ number_format($messInqury->deposit)}} ریال</td>
                                                </tr>
                                                @if($pinqStatus == 0)
                                                @if($key == 0)
                                                    <tr>
                                                        <td colspan="2">
                                                            <input type="hidden" id="paymessid" value="{{$messInqury->id}}">
                                                            <input type="hidden" id="allprice" value="{{$messInqury->price}}">
                                                            <input type="hidden" id="alldeposit" value="{{$messInqury->deposit}}">
                                                            <input type="hidden" id="userBalance" value="{{intval(auth()->user()->balance)}}">
                                                            <button class="btn btn-primary " type="button" onclick="payment()">
                                                                <i class="fa fa-check">
                                                                </i>
                                                                &nbsp;پذیرفتن پیشنهاد </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @endif
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        {!! $messInquries->render() !!}
                        <div class="hr-line-dashed"></div>

                        @include('Admin.section.errors')
                        @if($pinqStatus == 0)
                        <form action="{{ route('user.addMessinqus') }}" method="post" id="frm-mess" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="pinquiry_id" value="{{ Request::segment(3) }}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group"><label>توضیحات</label>
                                        <textarea name="body" id="body" cols="30" rows="10" class="form-control">{{ old('body') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>فایل</label>
                                        <input type="file" name="images" placeholder="فایل را وارد کنید" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <br>
                                <button type="button" onclick="submitform()" class="btn btn-w-m btn-primary">ارسال پاسخ</button>
                            </div>
                        </form>
                        @endif
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
                        قیمت پیشنهادی:
                        <span id="sumAllText" class="text-green" style="font-size: 20px"></span>
                        ریال
                    </h4>
                    <h4 id="boxUserDiscount">
                        بیعانه:
                        <span class="text-danger" style="font-size: 20px"></span>
                        ریال

                    </h4>
                    <h4 id="boxUserBalance">
                        موجودی حساب شما
                        <span class="text-success" style="font-size: 20px"></span>
                        ریال          می باشد.

                    </h4>
                </div>

                <div class="modal-footer">

                    <form action="/user/payment-pinq-online" id="frmPayment"   method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="messId" id="messId" value="">
                        <button type="button" class="btn btn-white" style="float: right;" data-dismiss="modal">انصراف</button>
                        <button class="btn btn-success" id="btnPaymentAcount" onclick="$('#frmPayment').attr('action','/user/payment-pinq-account'); $('#frmPayment').submit()">پرداخت از طریق موجودی حساب</button>
                        <button type="button" class="btn btn-primary" id="btnPaymentOnline" onclick="$('#frmPayment').submit()"> پرداخت آنلاین </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@section('script')


    <script src="/js/sweetalert.min.js"></script>

    <script>

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }


        function payment()
        {

            var userBalance = $('#userBalance').val();
            var allprice = $('#allprice').val();
            var alldeposit = $('#alldeposit').val();
            var paymessid = $('#paymessid').val();

            if(alldeposit){
                alldeposit = alldeposit;
                $('#boxUserDiscount span').text(numberWithCommas(alldeposit));
            }else{
                alldeposit = allprice;
                $('#boxUserDiscount span').text(0);
            }

            if(parseInt(userBalance) >= parseInt(alldeposit)){
                $('#btnPaymentAcount').show();
                $('#boxUserBalance').show();
                $('#btnPaymentOnline').hide();

            }else{
                $('#btnPaymentAcount').hide();
                $('#boxUserBalance').hide();
                $('#btnPaymentOnline').show();

            }


            $('#messId').val(paymessid);
            $('#sumAllText').text(numberWithCommas(allprice));

            $('#boxUserBalance span').text(numberWithCommas(userBalance));
            $('#pay').modal('show')



        }

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

    <script src="/js/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

        });

        function submitform(){

            var price = $('#price').val();
            var deposit = $('#deposit').val();
            var range = $('#range').val();
            var length = $('#length').val();
            var width = $('#width').val();

            if ($('input[id=optionsRadios2]:checked').length > 0) {
                if(price.length == 0){
                    alert('قیمت را وارد کنید !');
                    return false;
                }
                if(deposit.length == 0){
                    alert('بیعانه را وارد کنید !');
                    return false;
                }
                if(range.length == 0){
                    alert('تیراژ را وارد کنید !');
                    return false;
                }
                if(length.length == 0){
                    alert('طول را وارد کنید !');
                    return false;
                }
                if(width.length == 0){
                    alert('عرض را وارد کنید !');
                    return false;
                }
            }else{

            }



            $('#frm-mess').submit();


        }
    </script>
@endsection
@endsection