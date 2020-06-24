@extends('Admin.master')
@section('title', ' افزودن شیت')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">افزودن شیت</h2>

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
                        <form action="{{ route('sheets.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">

                                        {!! Form::label('category_id', 'دسته‌بندی ', []) !!}
                                        {!! Form::select('category_id', $categories, null, ['placeholder' => 'انتخاب کنید ', 'class' => 'form-control', 'id'=>'category_id','data-live-search'=>'true']) !!}

                                        @if ($errors->has('category_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('category_id') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>ظرفیت</label>
                                        <input type="text" name="remining_unit" placeholder="ظرفیت را وارد کنید" class="form-control" value="{{ old('remining_unit') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>توضیحات</label>
                                        <textarea name="body" id="body"  class="form-control" rows="3">{{ old('body') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>وضعیت</label>
                                        <select name="status" id="" class="form-control">
                                            <option value=""></option>
                                            <option value="1" selected>در انتظار فرم بندی</option>
                                            <option value="2">فرم بندی و لیتوگرافی</option>
                                            <option value="3">چاپ</option>
                                            <option value="4">برش و بسته بندی</option>
                                            <option value="5">آماده تحویل</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-primary">افزودن شیت</button>
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
@endsection
@endsection