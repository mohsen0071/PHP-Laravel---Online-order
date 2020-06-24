@extends('Admin.master')
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
                            @foreach($messInquries as $messInqury)
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
                                    <table class="table table-striped table-bordered table-hover" style="width: 50%">
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
                                    </table>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <br>
                        {!! $messInquries->render() !!}
                        @if($pinqStatus == 0)
                        <div class="hr-line-dashed"></div>

                        <div class="radio i-checks">
                            <label onclick="$('.recommend').hide()"> <input type="radio" checked="checked" value="1" id="optionsRadios1" name="user_type">

                                ارسال پاسخ                            </label>

                            @can('recommend-pinq')
                            <label onclick="$('.recommend').show(); "> <input type="radio" value="2" id="optionsRadios2" name="user_type">
                                ارسال پیشنهاد </label>

                            @endcan
                        </div>

                        <div class="hr-line-dashed"></div>
                        @include('Admin.section.errors')
                        <form action="{{ route('messinqus.store') }}" method="post" id="frm-mess" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="pinquiry_id" value="{{ Request::segment(3) }}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group"><label>توضیحات</label>
                                        <textarea name="body" id="body" cols="30" rows="4" class="form-control">{{ old('body') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="recommend d-none">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group"><label>قیمت<span class="text-danger">*</span></label>
                                            <input type="text" id="price" onkeyup="threeDigitNumber(this)" name="price" placeholder="قیمت را وارد کنید" value="{{old('price')}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group"><label>قیمت بیعانه</label>
                                            <input type="text" id="deposit" onkeyup="threeDigitNumber(this)" name="deposit" placeholder="قیمت بیعانه را وارد کنید" value="{{old('deposit')}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group"><label>تیراژ<span class="text-danger">*</span></label>
                                            <input type="text" id="range" onkeyup="justNumber(this)" name="range" placeholder="تیراژ را وارد کنید" value="{{old('range')}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group"><label>طول<span class="text-danger">*</span></label>
                                            <input type="text" id="length" onkeyup="justNumber(this)" name="length" placeholder="طول را وارد کنید" value="{{old('length')}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group"><label>عرض<span class="text-danger">*</span></label>
                                            <input type="text" id="width" onkeyup="justNumber(this)" name="width" placeholder="عرض را وارد کنید" value="{{old('width')}}" class="form-control">
                                        </div>
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
@section('script')

    <script src="/js/script.js"></script>
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
            var body = $('#body').val();

            if ($('input[id=optionsRadios2]:checked').length > 0) {

                if(body.length == 0){
                    alert('توضیحات را وارد کنید !');
                    return false;
                }
                if(price.length == 0){
                    alert('قیمت را وارد کنید !');
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


                var strDeposit = deposit;
                var resDeposit = strDeposit.replace(",", "");

                var strPrice = price;
                var resPrice = strPrice.replace(",", "");


                if(parseInt(resDeposit) > parseInt(resPrice)){
                    alert('مبلغ بیعانه از قیمت بیشتر است !');
                    return false;
                }

            }else{

            }

            if(body.length == 0){
                alert('توضیحات را وارد کنید !');
                return false;
            }


            $('#frm-mess').submit();


        }
    </script>
@endsection
@endsection