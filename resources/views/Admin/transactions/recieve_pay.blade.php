@extends('Admin.master')
@section('title', ' دریافتی پرداختی جدید')
@section('content')
@section('style')
    <link href="/css/persian-datepicker.min.css" rel="stylesheet">
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> دریافتی پرداختی جدید   </h2>

        </div>
        <div class="col-sm-8">

        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        @include('Admin.section.errors')
                        <form action="{{ route('transactionsrecieve.storeRecievePay')}}" method="post" id="frmTransaction">
                            {{ csrf_field() }}

                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">مشتری</label>

                                        <select name="client_id" id="client_id" class="form-control" data-live-search="true">
                                            <option value="">انتخاب مشتری</option>
                                            @foreach($users as $key => $user)
                                                <option value="{{$user->id}}">{{$user->name}} - {{$user->mobile}} - @if($user->city) {{$user->city->name}} @endif</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>نوع دریافتی پرداختی</label>
                                        <select name="recieve_pay_type" id="recieve_pay_type"  class="form-control">
                                            <option value="">انتخاب کنید</option>
                                            <option value="1">دریافتی</option>
                                            <option value="2">پرداختی</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>مبلغ</label>
                                        <input type="text" id="price" onkeyup="threeDigitNumber(this)" name="price" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>روش دریافتی پرداختی</label>
                                        <select name="payment_type" id="payment_type" onchange="changePaymentType(this.value)" class="form-control">
                                            <option value="">انتخاب کنید</option>
                                            <option value="1">نقد</option>
                                            <option value="2">واریز به حساب</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="box-bank-type d-none">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>بانک</label>
                                        <select name="bank_type" id="bank_type" class="form-control">
                                            <option value="">انتخاب کنید</option>
                                            <option value="1">ملت</option>
                                            <option value="2">پاسارگاد</option>
                                            <option value="3">ملی</option>
                                            <option value="4">صادارت</option>
                                            <option value="5">سپه</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>روش واریز</label>
                                        <select name="payment_way" id="payment_way" class="form-control">
                                            <option value=""> انتخاب کنید</option>
                                            <option value="1">حواله</option>
                                            <option value="2">کارت به کارت</option>
                                            <option value="3">کارت خوان</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>تاریخ پرداخت</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar">
                                                </i>
                                            </span>
                                            <input id="date_added" name="pay_date" autocomplete="off" type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>شماره سند</label>
                                        <input type="text" id="proof_number" name="proof_number" class="form-control" placeholder="شماره سند">
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>توضیحات</label>
                                        <textarea id="body" name="body"  class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" onclick="formSubmit()">ثبت</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script src="/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#client_id').selectpicker();


        })
    </script>
    <script src="/js/persian-date.js">
    </script>
    <script src="/js/persian-datepicker.min.js">
    </script>
    <script>
        $('#date_added').persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD'
        });

        $('#date_added').val('');

        function threeDigitNumber(input)
        {
            var num=input.value.replace(/[^\d-]/g,'');
            if(num.length>3)
                num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
            input.value=num;

        }


        function changePaymentType(pType){
            $('#date_added').val('');
            if(pType == 2)
            {
                $('.box-bank-type').show();
            }else{
                $('.box-bank-type').hide();
            }


        }

        function  formSubmit() {

            var recieve_pay_type = $('#recieve_pay_type').val();

            if(recieve_pay_type.length == 0){
                alert('لطفا نوع دریافتی پرداختی را انتخاب کنید');
                return false;
            }


            var paymentType = $('#payment_type').val();

            if(paymentType.length == 0){
                alert('لطفا روش دریافتی پرداختی را انتخاب کنید');
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




            $('#frmTransaction').submit();

        }
    </script>
@endsection
@endsection