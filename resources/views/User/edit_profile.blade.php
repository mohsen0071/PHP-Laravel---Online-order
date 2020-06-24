@extends('User.master')
@section('title', ' ویرایش پروفایل')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">  ویرایش پروفایل  </h2>

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

                                    @include('Admin.section.errors')
                                    <form action="{{ route('user.clientUpdate') }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
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
                                                <div class="form-group"><label>رمز عبور جدید</label>
                                                    <input type="password" name="password" placeholder="رمز عبور جدید را وارد کنید" class="form-control">
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
                                            <button type="submit" class="btn btn-w-m btn-info">ویرایش پروفایل</button>
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
    <script>

        function getCities(province_id, targetObj, cityId) {
            $.ajax({
                url: '/cities/' + province_id,
                type: 'GET',
                cache: false,
                dataType: 'json',
                beforeSend: function () {
                    targetObj
                        .attr('disabled', true)
                        .find('option:first').attr('selected', 'selected')
                        .html('دریافت لیست شهرها');
                },
                complete: function () {

                    if(cityId){
                        targetObj
                            .attr('disabled', false)
                        //  .find('option:first').attr('selected', 'selected');
                    }else{
                        targetObj
                            .attr('disabled', false)
                            .find('option:first').attr('selected', 'selected');
                    }

                },
                error: function (jqXHR) {
                    var errorText = getHttpStatus(jqXHR.status, jqXHR.responseText);
                    message(errorText, 'error');
                },
                success: function (data) {
                    var options = '<option value="">انتخاب کنید</option>';
                    $.each(data, function (k, v) {
                        console.log(cityId);
                        if(cityId === k)
                        {
                            options += '<option value="' + k + '" selected="selected">' + v + '</option>';
                        }
                        else
                        {
                            options += '<option value="' + k + '">' + v + '</option>';
                        }

                    });
                    targetObj.html(options);
                }
            });
        }


        $(document).ready(function(){
            var e = document.getElementById("province");
            var provinceId = e.options[e.selectedIndex].value;
            if(provinceId){
                cityId = $('#city_id').val();
                getCities(provinceId, $('#data-city-id'), cityId);

            }
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