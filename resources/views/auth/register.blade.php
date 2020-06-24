@extends('layouts.app')
@section('title', 'ایجاد حساب کاربری')
@section('content')

    <div class="row">

        <div class="col-md-12">
            @include('Admin.section.errors')
            <form method="POST" action="{{ route('register') }}">
                @csrf


                <div class="form-group"><h3>ایجاد حساب کاربری</h3>
                    <input type="text" name="mobile" required placeholder="شماره همراه خود را وارد نمائید. مثال:09121234567"
                           class="form-control" autofocus></div>
                <?php /*  <div class="hr-line-dashed"></div>
               <div class="radio i-checks" >
                    <label> <input type="radio" checked="" value="1" id="optionsRadios1" name="user_type">
                        کاربر عادی
                    </label>
                    <label> <input type="radio" value="2" id="optionsRadios2" name="user_type">
                        همکار </label>
                </div>*/ ?>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="checkbox i-checks"><label> <input type="checkbox" required><i></i>
                            <a href="/rules" target="_blank">  شرایط و قوانین</a>

                            استفاده از سامانه را می پذیرم
                        </label></div>
                </div>



                <button type="submit" class="btn btn-primary block full-width m-b">ثبت نام</button>

                <p class="text-muted text-center">
                    <a class="btn btn-white block full-width m-b" href="/login">آیا از قبل حساب کاربری دارید؟ وارد شوید</a>
                </p>
            </form>
        </div>
    </div>


@endsection
