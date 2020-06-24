@extends('Admin.master')
@section('title', 'ویرایش سطوح دسترسی کارمندان')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> ویرایش سطوح دسترسی کارمندان
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
                        <form action="{{ route('roles.update', ['id' => $role->id]) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>نام  سطح دسترسی </label>
                                        <input type="text" name="label" placeholder="نام سطح دسترسی  را وارد کنید" class="form-control" value="{{ $role->label }}">
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
                                        <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['logs']))   {{ $permissions['logs'] == 1 ? 'checked' : '' }} @endif  value="53"> <i></i> لاگ ادمین ها</label></div>
                                        <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-user']))   {{ $permissions['list-user'] == 1 ? 'checked' : '' }} @endif value="1"> <i></i> لیست </label></div>
                                        <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-user']))    {{ $permissions['add-user'] == 1 ? 'checked' : '' }} @endif value="2"> <i></i> افزودن </label></div>
                                        <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['edit-user']))   {{ $permissions['edit-user'] == 1 ? 'checked' : '' }} @endif value="3"> <i></i> ویرایش </label></div>
                                        <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-user'])) {{ $permissions['delete-user'] == 1 ? 'checked' : '' }} @endif value="4"> <i></i> حذف </label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox-group">
                                        <h4> سطوح دسترسی کارمندان </h4>
                                        <div class="hr-line-dashed"></div>
                                        <div class="i-checks all" data-title="user"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                        <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-employee-permission']))   {{ $permissions['list-employee-permission'] == 1 ? 'checked' : '' }} @endif value="9"> <i></i> لیست </label></div>
                                        <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-employee-permission']))    {{ $permissions['add-employee-permission'] == 1 ? 'checked' : '' }} @endif value="10"> <i></i> افزودن </label></div>
                                        <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['edit-employee-permission']))   {{ $permissions['edit-employee-permission'] == 1 ? 'checked' : '' }} @endif value="11"> <i></i> ویرایش </label></div>
                                        <div class="i-checks user"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-employee-permission'])) {{ $permissions['delete-employee-permission'] == 1 ? 'checked' : '' }} @endif value="12"> <i></i> حذف </label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox-group">
                                        <h4> مشتریان </h4>
                                        <div class="hr-line-dashed"></div>
                                        <div class="i-checks all" data-title="client"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                        <div class="i-checks client"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-client']))   {{ $permissions['list-client'] == 1 ? 'checked' : '' }} @endif value="13"> <i></i> لیست </label></div>
                                        <div class="i-checks client"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-client']))    {{ $permissions['add-client'] == 1 ? 'checked' : '' }} @endif value="14"> <i></i> افزودن </label></div>
                                        <div class="i-checks client"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['edit-client']))   {{ $permissions['edit-client'] == 1 ? 'checked' : '' }} @endif value="15"> <i></i> ویرایش </label></div>
                                        <div class="i-checks client"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-client'])) {{ $permissions['delete-client'] == 1 ? 'checked' : '' }} @endif value="16"> <i></i> حذف </label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox-group">
                                        <h4> اطلاعیه ها</h4>
                                        <div class="hr-line-dashed"></div>
                                        <div class="i-checks all" data-title="notif"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                        <div class="i-checks notif"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-notif'])) {{ $permissions['list-notif'] == 1 ? 'checked' : '' }} @endif  value="5"> <i></i> لیست </label></div>
                                        <div class="i-checks notif"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-notif'])) {{ $permissions['add-notif'] == 1 ? 'checked' : '' }} @endif  value="6"> <i></i> افزودن </label></div>
                                        <div class="i-checks notif"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['edit-notif'])) {{ $permissions['edit-notif'] == 1 ? 'checked' : '' }} @endif  value="7"> <i></i> ویرایش </label></div>
                                        <div class="i-checks notif"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-notif'])) {{ $permissions['delete-notif'] == 1 ? 'checked' : '' }} @endif  value="8"> <i></i> حذف </label></div>
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
                                        <div class="i-checks category"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-category'])) {{ $permissions['list-category'] == 1 ? 'checked' : '' }} @endif value="18"> <i></i> لیست </label></div>
                                        <div class="i-checks category"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-category'])) {{ $permissions['add-category'] == 1 ? 'checked' : '' }} @endif  value="19"> <i></i> افزودن </label></div>
                                        <div class="i-checks category"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['edit-category'])) {{ $permissions['edit-category'] == 1 ? 'checked' : '' }} @endif  value="20"> <i></i> ویرایش </label></div>
                                        <div class="i-checks category"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-category'])) {{ $permissions['delete-category'] == 1 ? 'checked' : '' }} @endif  value="21"> <i></i> حذف </label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox-group">
                                        <h4>محصولات</h4>
                                        <div class="hr-line-dashed"></div>
                                        <div class="i-checks all" data-title="product"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                        <div class="i-checks product"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-product'])) {{ $permissions['list-product'] == 1 ? 'checked' : '' }} @endif value="22"> <i></i> لیست </label></div>
                                        <div class="i-checks product"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-product'])) {{ $permissions['add-product'] == 1 ? 'checked' : '' }} @endif value="23"> <i></i> افزودن </label></div>
                                        <div class="i-checks product"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['edit-product'])) {{ $permissions['edit-product'] == 1 ? 'checked' : '' }} @endif value="24"> <i></i> ویرایش </label></div>
                                        <div class="i-checks product"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-product'])) {{ $permissions['delete-product'] == 1 ? 'checked' : '' }} @endif value="25"> <i></i> حذف </label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox-group">
                                        <h4>خدمات محصولات</h4>
                                        <div class="hr-line-dashed"></div>
                                        <div class="i-checks all" data-title="pservice"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                        <div class="i-checks pservice"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-pservice'])) {{ $permissions['list-pservice'] == 1 ? 'checked' : '' }} @endif value="26"> <i></i> لیست </label></div>
                                        <div class="i-checks pservice"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-pservice'])) {{ $permissions['add-pservice'] == 1 ? 'checked' : '' }} @endif value="27"> <i></i> افزودن </label></div>
                                        <div class="i-checks pservice"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['edit-pservice'])) {{ $permissions['edit-pservice'] == 1 ? 'checked' : '' }} @endif value="28"> <i></i> ویرایش </label></div>
                                        <div class="i-checks pservice"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-pservice'])) {{ $permissions['delete-pservice'] == 1 ? 'checked' : '' }} @endif value="29"> <i></i> حذف </label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox-group">
                                        <h4> سفارشات</h4>
                                        <div class="hr-line-dashed"></div>
                                        <div class="i-checks all" data-title="order"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                        <div class="i-checks order"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-order-client'])) {{ $permissions['add-order-client'] == 1 ? 'checked' : '' }} @endif value="17"> <i></i> ثبت سفارش </label></div>
                                        <div class="i-checks order"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-order'])) {{ $permissions['list-order'] == 1 ? 'checked' : '' }} @endif value="30"> <i></i> لیست  </label></div>
                                        <div class="i-checks order"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-pay-order'])) {{ $permissions['add-pay-order'] == 1 ? 'checked' : '' }} @endif value="31"> <i></i> افزودن پرداخت  </label></div>
                                        <div class="i-checks order"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['refresh-file'])) {{ $permissions['refresh-file'] == 1 ? 'checked' : '' }} @endif value="52"> <i></i> ویرایش فایل های سفارش  </label></div>
                                        <div class="i-checks order"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-order'])) {{ $permissions['delete-order'] == 1 ? 'checked' : '' }} @endif value="32"> <i></i> حذف  </label></div>
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
                                        <div class="i-checks pinq"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-pinq'])) {{ $permissions['list-pinq'] == 1 ? 'checked' : '' }} @endif value="33"> <i></i> لیست </label></div>
                                        <div class="i-checks pinq"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['answer-pinq'])) {{ $permissions['answer-pinq'] == 1 ? 'checked' : '' }} @endif value="34"> <i></i> ارسال پاسخ  </label></div>
                                        <div class="i-checks pinq"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['recommend-pinq'])) {{ $permissions['recommend-pinq'] == 1 ? 'checked' : '' }} @endif value="35"> <i></i> ارسال پیشنهاد  </label></div>
                                        <div class="i-checks pinq"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-pinq'])) {{ $permissions['delete-pinq'] == 1 ? 'checked' : '' }} @endif value="36"> <i></i> حذف  </label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox-group">
                                        <h4> شیت ها</h4>
                                        <div class="hr-line-dashed"></div>
                                        <div class="i-checks all" data-title="sheet"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                        <div class="i-checks sheet"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-sheet'])) {{ $permissions['list-sheet'] == 1 ? 'checked' : '' }} @endif value="37"> <i></i> لیست </label></div>
                                        <div class="i-checks sheet"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-sheet'])) {{ $permissions['add-sheet'] == 1 ? 'checked' : '' }} @endif value="38"> <i></i> افزودن  </label></div>
                                        <div class="i-checks sheet"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['edit-sheet'])) {{ $permissions['edit-sheet'] == 1 ? 'checked' : '' }} @endif value="39"> <i></i> ویرایش  </label></div>
                                        <div class="i-checks sheet"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-sheet'])) {{ $permissions['delete-sheet'] == 1 ? 'checked' : '' }} @endif value="40"> <i></i> حذف  </label></div>
                                        <div class="i-checks sheet"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['move-sheets'])) {{ $permissions['move-sheets'] == 1 ? 'checked' : '' }} @endif value="41"> <i></i> جایجایی بین شیت ها  </label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox-group">
                                        <h4>امور مالی</h4>
                                        <div class="hr-line-dashed"></div>
                                        <div class="i-checks all" data-title="trans"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                        <div class="i-checks trans"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-transaction'])) {{ $permissions['list-transaction'] == 1 ? 'checked' : '' }} @endif value="42"> <i></i> تراکنش های مالی </label></div>
                                        <div class="i-checks trans"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-cheque'])) {{ $permissions['list-cheque'] == 1 ? 'checked' : '' }} @endif value="43"> <i></i> چک ها / فیش ها  </label></div>
                                        <div class="i-checks trans"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['recieve-pay'])) {{ $permissions['recieve-pay'] == 1 ? 'checked' : '' }} @endif value="44"> <i></i>افزودن دریافتی پرداختی جدید  </label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox-group">
                                        <h4>تخفیف ها </h4>
                                        <div class="hr-line-dashed"></div>
                                        <div class="i-checks all" data-title="discount"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                        <div class="i-checks discount"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-discount'])) {{ $permissions['list-discount'] == 1 ? 'checked' : '' }} @endif value="45"> <i></i> لیست </label></div>
                                        <div class="i-checks discount"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-discount'])) {{ $permissions['add-discount'] == 1 ? 'checked' : '' }} @endif value="46"> <i></i> افزودن  </label></div>
                                        <div class="i-checks discount"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['edit-discount'])) {{ $permissions['edit-discount'] == 1 ? 'checked' : '' }} @endif value="47"> <i></i>ویرایش  </label></div>
                                        <div class="i-checks discount"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['delete-discount'])) {{ $permissions['delete-discount'] == 1 ? 'checked' : '' }} @endif value="48"> <i></i>حذف  </label></div>
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
                                        <div class="i-checks ship"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['list-shipping'])) {{ $permissions['list-shipping'] == 1 ? 'checked' : '' }} @endif value="49"> <i></i> لیست درخواست های ارسال  </label></div>
                                        <div class="i-checks ship"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['add-shipping'])) {{ $permissions['add-shipping'] == 1 ? 'checked' : '' }} @endif  value="50"> <i></i> ثبت درخواست ارسال  </label></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="checkbox-group">
                                        <h4>تنظیمات سایت </h4>
                                        <div class="hr-line-dashed"></div>
                                        <div class="i-checks all" data-title="setting"><label> <input type="checkbox" value=""> <i></i> انتخاب همه </label></div>
                                        <div class="i-checks setting"><label> <input type="checkbox" name="permission_id[]" @if(isset($permissions['setting-site'])) {{ $permissions['setting-site'] == 1 ? 'checked' : '' }} @endif  value="51"> <i></i> ثبت تنظیمات سایت  </label></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-success">ویرایش   سطح دسترسی </button>
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