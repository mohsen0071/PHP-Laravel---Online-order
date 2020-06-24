@extends('Admin.master')
@section('title', 'ثبت سطوح دسترسی کارمندان')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2 class="pagetitle"> ثبت سطوح دسترسی کارمندان
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
                    @include('Admin.section.errors')
                    <form action="{{ route('roles.store')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group"><label>نام  سطح دسترسی </label>
                                    <input type="text" name="label" placeholder="نام سطح دسترسی  را وارد کنید" class="form-control" value="{{ old('label') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <br>
                                <div class="i-checks all" data-title="all"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4> کارمندان </h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="user"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" value="53"> <i></i> لاگ ادمین ها</label></div>
                                    <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" value="1"> <i></i> لیست </label></div>
                                    <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" value="2"> <i></i> افزودن </label></div>
                                    <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" value="3"> <i></i> ویرایش </label></div>
                                    <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" value="4"> <i></i> حذف </label></div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4> سطوح دسترسی کارمندان </h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="permission"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks permission"><label> <input type="checkbox" name="permission_id[]" value="9"> <i></i> لیست </label></div>
                                    <div class="i-checks permission"><label> <input type="checkbox" name="permission_id[]" value="10"> <i></i> افزودن </label></div>
                                    <div class="i-checks permission"><label> <input type="checkbox" name="permission_id[]" value="11"> <i></i> ویرایش </label></div>
                                    <div class="i-checks permission"><label> <input type="checkbox" name="permission_id[]" value="12"> <i></i> حذف </label></div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4> مشتریان</h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="client"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks client"><label> <input type="checkbox" name="permission_id[]" value="13"> <i></i> لیست </label></div>
                                    <div class="i-checks client"><label> <input type="checkbox" name="permission_id[]" value="14"> <i></i> افزودن </label></div>
                                    <div class="i-checks client"><label> <input type="checkbox" name="permission_id[]" value="15"> <i></i> ویرایش </label></div>
                                    <div class="i-checks client"><label> <input type="checkbox" name="permission_id[]" value="16"> <i></i> حذف </label></div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                <h4> اطلاعیه ها</h4>
                                <div class="hr-line-dashed"></div>
                                <div class="i-checks all" data-title="notif"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                <div class="i-checks notif"><label> <input type="checkbox" name="permission_id[]" value="5"> <i></i> لیست </label></div>
                                <div class="i-checks notif"><label> <input type="checkbox" name="permission_id[]" value="6"> <i></i> افزودن </label></div>
                                <div class="i-checks notif"><label> <input type="checkbox" name="permission_id[]" value="7"> <i></i> ویرایش </label></div>
                                <div class="i-checks notif"><label> <input type="checkbox" name="permission_id[]" value="8"> <i></i> حذف </label></div>
                                </div>
                            </div>



                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4> دسته بندی ها</h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="category"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks category"><label> <input type="checkbox" name="permission_id[]" value="18"> <i></i> لیست </label></div>
                                    <div class="i-checks category"><label> <input type="checkbox" name="permission_id[]" value="19"> <i></i> افزودن </label></div>
                                    <div class="i-checks category"><label> <input type="checkbox" name="permission_id[]" value="20"> <i></i> ویرایش </label></div>
                                    <div class="i-checks category"><label> <input type="checkbox" name="permission_id[]" value="21"> <i></i> حذف </label></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4>محصولات</h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="product"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks product"><label> <input type="checkbox" name="permission_id[]" value="22"> <i></i> لیست </label></div>
                                    <div class="i-checks product"><label> <input type="checkbox" name="permission_id[]" value="23"> <i></i> افزودن </label></div>
                                    <div class="i-checks product"><label> <input type="checkbox" name="permission_id[]" value="24"> <i></i> ویرایش </label></div>
                                    <div class="i-checks product"><label> <input type="checkbox" name="permission_id[]" value="25"> <i></i> حذف </label></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4>خدمات محصولات</h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="pservice"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks pservice"><label> <input type="checkbox" name="permission_id[]" value="26"> <i></i> لیست </label></div>
                                    <div class="i-checks pservice"><label> <input type="checkbox" name="permission_id[]" value="27"> <i></i> افزودن </label></div>
                                    <div class="i-checks pservice"><label> <input type="checkbox" name="permission_id[]" value="28"> <i></i> ویرایش </label></div>
                                    <div class="i-checks pservice"><label> <input type="checkbox" name="permission_id[]" value="29"> <i></i> حذف </label></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4> سفارشات</h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="order"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks order"><label> <input type="checkbox" name="permission_id[]" value="17"> <i></i> ثبت سفارش </label></div>
                                    <div class="i-checks order"><label> <input type="checkbox" name="permission_id[]" value="30"> <i></i> لیست  </label></div>
                                    <div class="i-checks order"><label> <input type="checkbox" name="permission_id[]" value="31"> <i></i> افزودن پرداخت  </label></div>
                                    <div class="i-checks order"><label> <input type="checkbox" name="permission_id[]" value="52"> <i></i> ویرایش فایل های سفارش  </label></div>
                                    <div class="i-checks order"><label> <input type="checkbox" name="permission_id[]" value="32"> <i></i> حذف  </label></div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4> استعلام</h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="pinq"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks pinq"><label> <input type="checkbox" name="permission_id[]" value="33"> <i></i> لیست </label></div>
                                    <div class="i-checks pinq"><label> <input type="checkbox" name="permission_id[]" value="34"> <i></i> ارسال پاسخ  </label></div>
                                    <div class="i-checks pinq"><label> <input type="checkbox" name="permission_id[]" value="35"> <i></i> ارسال پیشنهاد  </label></div>
                                    <div class="i-checks pinq"><label> <input type="checkbox" name="permission_id[]" value="36"> <i></i> حذف  </label></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4> شیت ها</h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="sheet"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks sheet"><label> <input type="checkbox" name="permission_id[]" value="37"> <i></i> لیست </label></div>
                                    <div class="i-checks sheet"><label> <input type="checkbox" name="permission_id[]" value="38"> <i></i> افزودن  </label></div>
                                    <div class="i-checks sheet"><label> <input type="checkbox" name="permission_id[]" value="39"> <i></i> ویرایش  </label></div>
                                    <div class="i-checks sheet"><label> <input type="checkbox" name="permission_id[]" value="40"> <i></i> حذف  </label></div>
                                    <div class="i-checks sheet"><label> <input type="checkbox" name="permission_id[]" value="41"> <i></i> جایجایی بین شیت ها  </label></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4>امور مالی</h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="trans"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks trans"><label> <input type="checkbox" name="permission_id[]" value="42"> <i></i> تراکنش های مالی </label></div>
                                    <div class="i-checks trans"><label> <input type="checkbox" name="permission_id[]" value="43"> <i></i> چک ها / فیش ها  </label></div>
                                    <div class="i-checks trans"><label> <input type="checkbox" name="permission_id[]" value="44"> <i></i>افزودن دریافتی پرداختی جدید  </label></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4>تخفیف ها </h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="discount"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks discount"><label> <input type="checkbox" name="permission_id[]" value="45"> <i></i> لیست </label></div>
                                    <div class="i-checks discount"><label> <input type="checkbox" name="permission_id[]" value="46"> <i></i> افزودن  </label></div>
                                    <div class="i-checks discount"><label> <input type="checkbox" name="permission_id[]" value="47"> <i></i>ویرایش  </label></div>
                                    <div class="i-checks discount"><label> <input type="checkbox" name="permission_id[]" value="48"> <i></i>حذف  </label></div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4>درخواست های ارسال کار </h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="ship"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks ship"><label> <input type="checkbox" name="permission_id[]" value="49"> <i></i> لیست درخواست های ارسال  </label></div>
                                    <div class="i-checks ship"><label> <input type="checkbox" name="permission_id[]" value="50"> <i></i> ثبت درخواست ارسال  </label></div>
                                   </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="checkbox-group">
                                    <h4>تنظیمات سایت </h4>
                                    <div class="hr-line-dashed"></div>
                                    <div class="i-checks all" data-title="setting"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                    <div class="i-checks setting"><label> <input type="checkbox" name="permission_id[]" value="51"> <i></i> ثبت تنظیمات سایت  </label></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <br>
                            <button type="submit" class="btn btn-w-m btn-primary">ثبت   سطح دسترسی </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@section('script')
    <script src="/js/icheck.min.js"></script>
    <script>

        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });


            $('.i-checks').on('ifChecked', function(event){
                var data = $(this).data('title');
                if(data && data != 'undefined'){
                    if(data == 'all'){
                        $('.i-checks').iCheck('check');
                    }else {
                        $('.i-checks.' + data).iCheck('check');
                    }
                }

            });
            $('.i-checks').on('ifUnchecked', function(event){
                var data = $(this).data('title');
                if(data && data != 'undefined'){
                    if(data == 'all'){
                        $('.i-checks').iCheck('uncheck');
                    }else{
                        $('.i-checks.'+data).iCheck('uncheck');
                    }
                }
            });


        });


    </script>
@endsection
@endsection