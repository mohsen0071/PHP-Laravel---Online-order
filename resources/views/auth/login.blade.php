@extends('layouts.app')
@section('title', 'ورود به حساب کاربری')
@section('content')

    <div class="row">

        <div class="col-md-12">
            @include('Admin.section.errors')

            <form method="POST" action="{{ route('login') }}">
                @csrf


                <div class="form-group"><h3>ورود به حساب کاربری</h3>
                    <input type="text" name="mobile" required placeholder="شماره همراه " value="{{ old('mobile') }}" class="form-control" autofocus>
                    <br>
                    <input type="password" name="password" required placeholder=" رمز عبور " class="form-control">

                </div>





                <div class="form-group">
                    <div class="checkbox i-checks"><label>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <i></i>



                            مرا به خاطر بسپار                        </label></div>
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">ورود به حساب</button>

                <p class="text-muted text-center">
                    <a class="btn btn-white block full-width m-b" href="/register">ثبت نام</a>
                </p>

                <p class="text-center">
                    <a class="btn btn-sm  btn-block" href="/reset-password">رمز عبور خود را فراموش کردید؟</a>
                </p>

            </form>
        </div>

    </div>
@endsection
