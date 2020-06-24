@extends('User.master')
@section('title', 'افزایش موجودی ')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> افزایش موجودی  </h2>

        </div>
        <div class="col-sm-8">

        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">

                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="ibox float-e-margins">

                                    @include('Admin.section.errors')
                                    <form action="{{ route('user.increasePayment') }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group"><label>مبلغ را به ریال وارد کنید</label>
                                                    <input type="text" name="price" onkeyup="threeDigitNumber(this)" placeholder="مبلغ را به ریال وارد کنید" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <br>
                                            <button type="submit" class="btn btn-w-m btn-info">افزایش موجودی</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@section('script')

    <script src="/js/sweetalert.min.js"></script>
    <script>
        function threeDigitNumber(input){
            var num=input.value.replace(/[^\d-]/g,'');
            if(num.length>3)
                num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
            input.value=num;

        }

        function sweet(frm){
            swal({
                    title: "حذف",
                    text: "برای حذف مطمئن هستید؟",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "بله",
                    cancelButtonText: "خیر",
                    closeOnConfirm: false,
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $('.'+frm).submit();
                        //  swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    } else {
                        // swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
        }


    </script>
    @if (Session::has('sweet_alert.alert'))
        <script>
            swal({
                title : "{!! Session::get('sweet_alert.title') !!}",
                type: "{!! Session::get('sweet_alert.icon') !!}",
                confirmButtonColor: "#A5DC86",
                confirmButtonText: "متوجه شدم",
            });
        </script>
    @endif
@endsection
@endsection