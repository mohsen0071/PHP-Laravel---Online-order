@extends('layouts.app')
@section('title', 'بازیابی گذرواژه')
@section('content')

    <div class="row">

        <div class="col-md-12">
            @include('Admin.section.errors')
            <form method="POST" action="{{ route('password.mobile') }}">
                @csrf


                <div class="form-group"><h3>بازیابی گذرواژه</h3>
                    <input type="text" name="mobile" required placeholder="شماره همراه خود را وارد نمائید. مثال:09121234567" class="form-control" autofocus></div>


                <button type="submit" class="btn btn-primary block full-width m-b">بازیابی رمز عبور</button>

                <p class="text-muted text-center">
                    <a class="btn btn-white block full-width m-b" href="/login">آیا از قبل حساب کاربری دارید؟ وارد شوید</a>
                </p>
            </form>
        </div>

    </div>
@endsection
