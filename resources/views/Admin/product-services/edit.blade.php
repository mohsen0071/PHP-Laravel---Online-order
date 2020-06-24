@extends('Admin.master')
@section('title', 'ویرایش خدمات محصولات')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">ویرایش خدمات محصولات</h2>

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
                        <form action="{{ route('product-service.update', ['id' => $Pservice->id]) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>نام</label>
                                        <input type="text" name="name" placeholder="نام را وارد کنید" class="form-control" value="{{ $Pservice->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>قیمت</label>
                                        <input type="text" name="pservice_price" onkeyup="threeDigitNumber(this)" placeholder="قیمت را وارد کنید" class="form-control" value="{{ $Pservice->pservice_price }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>وضعیت</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="1" {{ $Pservice->status == 1 ? 'selected' : '' }}>فعال</option>
                                            <option value="0" {{ $Pservice->status == 0 ? 'selected' : '' }}>غیر فعال</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-success">ویرایش خدمات محصولات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script src="/js/script.js"></script>
@endsection
@endsection