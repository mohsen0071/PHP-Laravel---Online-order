@extends('Admin.master')
@section('title', 'تنظیمات سایت ')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">تنظیمات سایت</h2>

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
                        <form action="{{ route('settings.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group"><label>نام سایت</label>
                                <input type="text" name="name" placeholder="عنوان را وارد کنید" class="form-control" value="{{ $settings->name }}">
                            </div>
                            <div class="form-group"><label>تلفن</label>
                                <input type="text" name="tel" placeholder="تلفن را وارد کنید" class="form-control" value="{{ $settings->tel }}">
                            </div>
                            <div class="form-group"><label>آدرس</label>
                                <input type="text" name="address" placeholder="آدرس را وارد کنید" class="form-control" value="{{ $settings->address }}">
                            </div>
                            <div class="form-group"><label>تصویر لوگو</label>
                                <input type="file" name="images" placeholder="تصویر لوگو را وارد کنید" class="form-control">
                            </div>
                            <div class="form-group"><label>تصویر لوگو</label>
                                <img src="{{ $settings->images["images"]["200"] }}" width="100" alt="">
                            </div>
                            <div class="form-group"><label> متن قوانین سایت</label>
                                <textarea name="rules" id="rules" cols="30" rows="5" class="form-control">{{ $settings->rules }}</textarea>
                            </div>
                            <div class="form-group"><label> متن راهنمای سایت</label>
                                <textarea name="guide" id="guide" cols="30" rows="5" class="form-control">{{ $settings->guide }}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-w-m btn-primary">ثبت اطلاعات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('rules' ,{
            filebrowserUploadUrl : '/admin/panel/upload-image',
            filebrowserImageUploadUrl :  '/admin/panel/upload-image'
        });

        CKEDITOR.replace('guide' ,{
            filebrowserUploadUrl : '/admin/panel/upload-image',
            filebrowserImageUploadUrl :  '/admin/panel/upload-image'
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