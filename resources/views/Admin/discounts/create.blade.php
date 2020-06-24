@extends('Admin.master')
@section('title', ' افزودن تخفیف')

@section('content')
@section('style')
    <link href="/css/persian-datepicker.min.css" rel="stylesheet">
@endsection
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">افزودن تخفیف</h2>

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
                        <form action="{{ route('discounts.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row d-none">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>نوع مبلغ</label>
                                        <select name="amount_type" id="amount_type" class="form-control">
                                            <option value="1">درصدی</option>
                                            <option value="2">مقداری</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group"><label>درصد</label>
                                        <input type="text" name="amount" placeholder="درصد را وارد کنید" class="form-control" value="{{ old('amount') }}">

                                    </div>
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="col-lg-6">
                                    <div class="form-group"><label>حداقل مبلغ سفارش</label>
                                        <input type="text" onkeyup="threeDigitNumber(this)" name="minAmount" placeholder="حداقل مبلغ سفارش را وارد کنید" class="form-control" value="{{ old('minAmount') }}">
                                        <small>حداقل  مبلغی که شما در این فیلد وارد میکنید تخفیف به مشتری تعلق خواهد گرفت، در صورتی که میخواهید محدودیتی وجود نداشته باشد میتوانید 0 را وارد کنید.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="col-lg-6">
                                    <div class="form-group"><label>حداکثر مبلغ سفارش</label>
                                        <input type="text" onkeyup="threeDigitNumber(this)"  name="maxAmount" placeholder="حداکثر مبلغ سفارش را وارد کنید" class="form-control" value="{{ old('maxAmount') }}">
                                        <small>حداکثر مبلغی که شما در این فیلد وارد میکنید تخفیف به مشتری تعلق خواهد گرفت، در صورتی که میخواهید محدودیتی وجود نداشته باشد میتوانید 0 را وارد کنید.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="col-lg-8">

                                        <div class="form-group"><label>نوع کد تخفیف</label>
                                            <div class="i-checks"><label> <input type="radio"  value="1" name="type"> <i></i>  یکبار مصرف </label> / فقط یکبار قابل استفاده می باشد. </div>
                                            <div class="i-checks"><label> <input type="radio"  value="2" name="type"> <i></i> چندبار مصرف هر مشتری یکبار </label> / هر مشتری فقط یکبار می تواند استفاده کند. </div>
                                            <div class="i-checks"><label> <input type="radio"  value="3" checked name="type"> <i></i> چندبار مصرف بدون محدودیت روی مشتری </label> / هیچ محدودیتی در تعداد دفعات استفاده مشتریان وجود ندارد. </div>
                                            <div class="i-checks"><label> <input type="radio"  value="4" name="type"> <i></i>  اولین خرید </label> /  این کد تخفیف مخصوص مشتریانی می باشد که اولین خرید خود را انجام می دهند.</div>
                                        </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group"><label>تاریخ انقضاء</label>
                                        <input type="text" name="expireDate" autocomplete="off" id="expireDate" placeholder="تاریخ انقضاء را وارد کنید" class="form-control">
                                        <small>اگر خالی بماند تاریخ انقضا ندارد</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>وضعیت </label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">فعال</option>
                                            <option value="0">غیر فعال</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group"><label>مشتریان </label>
                                        <select name="client_group[]" id="client_group" class="form-control" multiple data-live-search="true">

                                            @foreach($users as $key => $user)
                                                <option value="{{$user->id}}">{{$user->name}} - {{$user->mobile}} - @if($user->city) {{$user->city->name}} @endif</option>
                                            @endforeach
                                        </select>
                                        <small>اگر هیچ مشتری انتخاب نشود کد تخفیف برای تمام مشتری ها فعال خواهد بود.</small>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group"><label>محصول </label>
                                        <select name="product_group[]" id="product_group" class="form-control" multiple data-live-search="true">
                                            @foreach($products as $key => $product)
                                                <option value="{{$product->id}}">{{$product->name}} - {{$product->category->name}}</option>
                                            @endforeach
                                        </select>
                                        <small>اگر هیچ محصولی انتخاب نشود کد تخفیف برای تمام محصولات فعال خواهد بود.</small>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>توضیحات </label>
                                        <textarea name="body" id="body"  rows="4" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-primary">افزودن تخفیف</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script src="/js/script.js"></script>
    <script src="/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#client_group').selectpicker();
            $('#product_group').selectpicker();
        })
    </script>

    <script src="/js/persian-date.js">
    </script>
    <script src="/js/persian-datepicker.min.js">
    </script>
    <script>

        $('#expireDate').persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD',
            autoClose: true
        });

      $('#expireDate').val('');
    </script>
    <script src="/js/icheck.min.js"></script>
    <script>

        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });


        });


    </script>

@endsection
@endsection