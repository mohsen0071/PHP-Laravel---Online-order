@extends('Admin.master')
@section('title', '  ثبت کارمند')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> ثبت کارمند</h2>

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
                        <form action="{{ route('users.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>نام</label>
                                        <input type="text" name="name" placeholder="نام را وارد کنید" class="form-control" value="{{ old('name') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>ایمیل</label>
                                        <input type="email" name="email" placeholder="ایمیل را وارد کنید" class="form-control" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>رمز عبور</label>
                                        <input type="text" name="password" placeholder="رمز عبور را وارد کنید" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>سطح دسترسی</label>
                                        <select name="role" id="" class="form-control">
                                            @foreach($all_roles as $r)
                                                <option value="{{$r->id}}">{{$r->label}}</option>
                                            @endforeach
                                        </select>
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
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>شماره تلفن همراه</label>
                                        <input type="text" name="mobile" placeholder="شماره تلفن همراه را وارد کنید" class="form-control" value="{{ old('mobile') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-w-m btn-success">ثبت کارمند</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection