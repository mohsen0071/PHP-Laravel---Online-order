@extends('Admin.master')
@section('title', ' ویرایش شیت')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">ویرایش شیت</h2>

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
                        <form action="{{ route('sheets.update', ['id' => $sheet->id]) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
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
                            <div class="row d-none">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>ظرفیت باقیمانده</label>
                                        <input type="text" name="remining_unit" placeholder="ظرفیت باقیمانده را وارد کنید" class="form-control" value="{{ $sheet->remining_unit }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>ظرفیت استفاده شده</label>
                                        <input type="text" name="used_unit" placeholder="ظرفیت استفاده شده را وارد کنید" class="form-control" value="{{ $sheet->used_unit }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>توضیحات</label>
                                        <textarea name="body" id="body"  class="form-control" rows="3">{{ $sheet->body }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>وضعیت</label>
                                        <select name="status" id="" class="form-control">
                                            <option value=""></option>
                                            <option value="1" {{$sheet->status == 1 ? 'selected' : ''}}>در انتظار فرم بندی</option>
                                            <option value="2" {{$sheet->status == 2 ? 'selected' : ''}}>فرم بندی و لیتوگرافی</option>
                                            <option value="3" {{$sheet->status == 3 ? 'selected' : ''}}>چاپ</option>
                                            <option value="4" {{$sheet->status == 4 ? 'selected' : ''}}>برش و بسته بندی</option>
                                            <option value="5" {{$sheet->status == 5 ? 'selected' : ''}}>آماده تحویل</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-primary">ویرایش شیت</button>
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
            var text = $("select[name=category_id] option[value='{{$sheet->category_id}}']").text();
            //We need to show the text inside the span that the plugin show
            $('.bootstrap-select .filter-option').text(text);
            //Check the selected attribute for the real select
            $('select[name=category_id]').val({{$sheet->category_id}});

        })
    </script>
@endsection
@endsection