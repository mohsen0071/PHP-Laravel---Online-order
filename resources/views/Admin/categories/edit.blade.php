@extends('Admin.master')
@section('title', 'ویرایش دسته بندی')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> ویرایش دسته بندی</h2>

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
                        <form action="{{ route('categories.update', ['id' => $category->id])}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>دسته‌بندی اصلی</label>
                                        {!! Form::select('parent_id', $categories, null, ['placeholder' => 'انتخاب کنید', 'class' => 'form-control','data-live-search'=>'true','id'=>'category_id']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>نام دسته بندی</label>
                                        <input type="text" name="name" placeholder="نام دسته بندی را وارد کنید" class="form-control" value="{{ $category->name }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>توضیحات</label>
                                        <textarea name="description" id="body"  class="form-control" rows="3">{{ $category->description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>وضعیت</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>فعال</option>
                                            <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>غیر فعال</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>ضریب کار تکمیلی</label>
                                        <input type="text" name="pservice_unit" placeholder=" ضریب کار تکمیلی را وارد کنید" class="form-control" value="{{ $category->pservice_unit }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group"><label>ظرفیت شیت</label>
                                        <input type="text" name="sheet_count" placeholder="ظرفیت شیت را وارد کنید" class="form-control" value="{{ $category->sheet_count }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">

                                    <div class="form-group"><label>تصویر</label>
                                        <input type="file" name="images" class="form-control" value="{{ old('images') }}">
                                    </div>
                                    <div class="form-group"><label>تصویر</label>
                                        <img src="{{ $category->images['thumb'] }}" width="200">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-success">ویرایش دسته بندی</button>
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

            //Get the text using the value of select
            var text = $("select[name=parent_id] option[value='{{$category->parent_id}}']").text();
            //We need to show the text inside the span that the plugin show
                        $('.bootstrap-select .filter-option').text(text);
            //Check the selected attribute for the real select
                        $('select[name=parent_id]').val({{$category->parent_id}});

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