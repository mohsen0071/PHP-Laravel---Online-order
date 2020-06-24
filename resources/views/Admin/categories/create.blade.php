@extends('Admin.master')

@section('title', 'ثبت دسته بندی')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> ثبت دسته بندی</h2>

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
                        <form action="{{ route('categories.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                                        {!! Form::label('parent_id', 'دسته‌بندی اصلی', []) !!}

                                            {!! Form::select('parent_id', $categories, null, ['placeholder' => 'انتخاب کنید', 'class' => 'form-control', 'id'=>'category_id','data-live-search'=>'true']) !!}

                                            @if ($errors->has('parent_id'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('parent_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>نام دسته بندی</label>
                                        <input type="text" name="name" placeholder="نام دسته بندی را وارد کنید" class="form-control" value="{{ old('name') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>توضیحات</label>
                                        <textarea name="description" id="body"  class="form-control" rows="3">{{ old('image') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>وضعیت</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="1">فعال</option>
                                            <option value="0">غیر فعال</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>ضریب کار تکمیلی</label>
                                        <input type="text" name="pservice_unit" placeholder=" ضریب کار تکمیلی را وارد کنید" class="form-control" value="{{ old('pservice_unit') }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>ظرفیت شیت</label>
                                        <input type="text" name="sheet_count" placeholder="ظرفیت شیت را وارد کنید" class="form-control" value="{{ old('sheet_count') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>تصویر</label>
                                        <input type="file" name="images" class="form-control" value="{{ old('images') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-success">ثبت دسته بندی</button>
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