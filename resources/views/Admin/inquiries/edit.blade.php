@extends('Admin.master')

@section('title', 'ویرایش استعلام قیمت')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">ویرایش استعلام قیمت</h2>

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
                        <form action="{{ route('inquiries.update', ['id' => $inquiry->id]) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>عنوان</label>
                                        <input type="text" name="title" placeholder=" عنوان را وارد کنید" class="form-control" value="{{ $inquiry->title }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>توضیحات</label>
                                        <textarea name="body" id="body"  class="form-control" rows="3">{{ $inquiry->body }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-lg-4">
                            <div class="form-group"><label>وضعیت</label>
                            <select name="status" id="" class="form-control">
                            <option value="1" {{ $inquiry->status == 1 ? 'selected' : '' }}>فعال</option>
                            <option value="0" {{ $inquiry->status == 0 ? 'selected' : '' }}>غیر فعال</option>
                            </select>
                            </div>
                            </div>
                            </div>



                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-success">ویرایش استعلام قیمت</button>
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
            $('#category_id').selectpicker();
        })
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
    {{--<script src="/ckeditor/ckeditor.js"></script>--}}
    {{--<script>--}}
    {{--CKEDITOR.replace('body' ,{--}}
    {{--filebrowserUploadUrl : '/admin/panel/upload-image',--}}
    {{--filebrowserImageUploadUrl :  '/admin/panel/upload-image'--}}
    {{--});--}}
    {{--</script>--}}
@endsection
@endsection