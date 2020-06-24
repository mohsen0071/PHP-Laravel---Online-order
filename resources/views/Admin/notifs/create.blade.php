@extends('Admin.master')
@section('title', 'افزودن اطلاعیه')
@section('script')
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('body' ,{
            filebrowserUploadUrl : '/admin/panel/upload-image',
            filebrowserImageUploadUrl :  '/admin/panel/upload-image'
        });
    </script>
@endsection
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">افزودن اطلاعیه</h2>

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
                        <form action="{{ route('notifs.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group"><label>عنوان</label>
                                <input type="text" name="title" placeholder="عنوان را وارد کنید" class="form-control" value="{{ old('title') }}">
                            </div>
                            <div class="form-group"><label>متن</label>
                                <textarea name="body" id="body" cols="30" rows="10" class="form-control">{{ old('body') }}</textarea>
                            </div>
                            <div class="form-group"><label>تصویر</label>
                                <input type="file" name="images" placeholder="عنوان را وارد کنید" class="form-control" value="{{ old('images') }}>
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-primary">ثبت اطلاعیه</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection