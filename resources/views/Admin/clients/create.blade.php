@extends('Admin.master')
@section('title', ' ثبت مشتری')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> ثبت مشتری</h2>

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
                        <form action="{{ route('clients.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>نام</label>
                                        <input type="text" name="name" placeholder="نام را وارد کنید" class="form-control" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>شرکت</label>
                                        <input type="text" name="company" placeholder="شرکت را وارد کنید" class="form-control" value="{{ old('company') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>ایمیل</label>
                                        <input type="email" name="email" placeholder="ایمیل را وارد کنید" class="form-control" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>کد ملی</label>
                                        <input type="text" name="national_code" placeholder="کد ملی را وارد کنید" class="form-control" value="{{ old('national_code') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>تلفن همراه</label>
                                        <input type="text" name="mobile" placeholder="تلفن همراه را وارد کنید" class="form-control" value="{{ old('mobile') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>تلفن ثابت</label>
                                        <input type="text" name="tel" placeholder="تلفن ثابت را وارد کنید" class="form-control" value="{{ old('tel') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>آدرس</label>
                                        <input type="text" name="address" placeholder="آدرس را وارد کنید" class="form-control" value="{{ old('address') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>کد پستی</label>
                                        <input type="text" name="postal_code" placeholder="کد پستی را وارد کنید" class="form-control" value="{{ old('postal_code') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>وضعیت</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">فعال</option>
                                            <option value="2">غیر فعال</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>نوع کاربری</label>
                                        <select name="user_type" id="user_type" class="form-control">
                                            <option value="1">عادی</option>
                                            <option value="2">همکار</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>استان</label>
                                        <select name="province_id" id="" class="form-control" onchange="getCities(this.value, $('#data-city-id'))">
                                            <option selected="selected" value="">انتخاب استان</option>
                                            @foreach($provinces as $pro)
                                                <option value="{{$pro->id}}">{{$pro->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>شهر</label>
                                        <select id="data-city-id" class="form-control" name="city_id"
                                        ><option selected="selected" value="">انتخاب شهر</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>رمز عبور</label>
                                        <input type="password" name="password" placeholder="رمز عبور را وارد کنید" class="form-control" value="{{ old('password') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>تصویر پروفایل</label>
                                        <input type="file" name="images" placeholder="تصویر پروفایل را وارد کنید" class="form-control" value="{{ old('images') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-info">ثبت مشتری</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script src="/js/script.js"></script>
@endsection
@endsection