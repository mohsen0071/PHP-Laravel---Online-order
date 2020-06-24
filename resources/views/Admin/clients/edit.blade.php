@extends('Admin.master')
@section('title', ' ویرایش مشتری')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> مشتری : {{$user->name}}  </h2>

        </div>
        <div class="col-sm-8">

        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a  href="/admin/clients/{{$user->id}}/edit"> <h3 class="m-b-none">پروفایل</h3></a></li>
                        @can('add-order-client')
                        <li class=""><a  href="/admin/clients/{{$user->id}}/order"> <h3 class="m-b-none">ثبت سفارش</h3></a></li>
                        @endcan
                        <li class=""><a  href="/admin/clients/{{$user->id}}/client-order"> <h3 class="m-b-none"> سفارشات </h3></a></li>
                        <li class=""><a  href="/admin/clients/{{$user->id}}/client-cheques"> <h3 class="m-b-none">  چک ها و فیش ها </h3></a></li>
                        <li class=""><a  href="/admin/clients/{{$user->id}}/client-transactions"> <h3 class="m-b-none"> تراکنش ها </h3></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="ibox float-e-margins">

                                        @include('Admin.section.errors')
                                    <form action="{{ route('clients.update', ['id' => $user->id]) }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>نام</label>
                                                        <input type="text" name="name" placeholder="نام را وارد کنید" class="form-control" value="{{ $user->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>شرکت</label>
                                                        <input type="text" name="company" placeholder="شرکت را وارد کنید" class="form-control" value="{{ $user->company }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>ایمیل</label>
                                                        <input type="email" name="email" placeholder="ایمیل را وارد کنید" class="form-control" value="{{ $user->email }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>کد ملی</label>
                                                        <input type="text" name="national_code" placeholder="کد ملی را وارد کنید" class="form-control" value="{{ $user->national_code }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>تلفن همراه</label>
                                                        <input type="text" name="mobile" placeholder="تلفن همراه را وارد کنید" class="form-control" value="{{ $user->mobile }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>تلفن ثابت</label>
                                                        <input type="text" name="tel" placeholder="تلفن ثابت را وارد کنید" class="form-control" value="{{ $user->tel }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>آدرس</label>
                                                        <input type="text" name="address" placeholder="آدرس را وارد کنید" class="form-control" value="{{ $user->address }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>کد پستی</label>
                                                        <input type="text" name="postal_code" placeholder="کد پستی را وارد کنید" class="form-control" value="{{ $user->postal_code }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>وضعیت</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="1" {{$user->status == 1 ? 'selected' : ''}}>فعال</option>
                                                            <option value="2" {{$user->status == 2 ? 'selected' : ''}}>غیر فعال</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>نوع کاربری</label>
                                                        <select name="user_type" id="user_type" class="form-control">
                                                            <option value="1" {{$user->user_type == 1 ? 'selected' : ''}}>عادی</option>
                                                            <option value="2" {{$user->user_type == 2 ? 'selected' : ''}}>همکار</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>استان</label>
                                                        <select name="province_id" id="province" class="form-control" onchange="getCities(this.value, $('#data-city-id'))">
                                                            <option selected="selected" value="">انتخاب استان</option>
                                                            @foreach($provinces as $pro)
                                                                <option value="{{$pro->id}}" {{ $user->province_id == $pro->id ? 'selected' : '' }}>{{$pro->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="hidden" id="city_id" value="{{$user->city_id}}">
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
                                                        <input type="password" name="password" placeholder="رمز عبور را وارد کنید" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group"><label>تصویر پروفایل</label>
                                                        <input type="file" name="images" placeholder="تصویر پروفایل را وارد کنید" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <img src="{{ $user->images }}" width="200">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="submit" class="btn btn-w-m btn-info">ویرایش مشتری</button>
                                            </div>
                                        </form>

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
@section('script')
    <script src="/js/script.js"></script>
    <script>
        $(document).ready(function(){
            var e = document.getElementById("province");
            var provinceId = e.options[e.selectedIndex].value;
            if(provinceId){
                cityId = $('#city_id').val();
                getCities(provinceId, $('#data-city-id'), cityId);

            }
        });

    </script>
@endsection
@endsection