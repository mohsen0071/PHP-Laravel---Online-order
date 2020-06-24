@extends('Admin.master')
@section('title', ' جابجایی بین شیت ها')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> جابجایی بین شیت ها </h2>

        </div>
        <div class="col-sm-8">
            <div class="title-action">

            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#tab-10">
                                شیت مبدا
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-10" class="tab-pane active">
                            <div class="panel-body">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                        {!! Form::select('category_id', $categories, null, ['placeholder' => 'دسته بندی', 'class' => 'form-control', 'id'=>'category_id','data-live-search'=>'true', 'onChange'=>'getSheets(this.value, '."'start'".')']) !!}
                                        @if ($errors->has('category_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('category_id') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group" id="startSheet">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#tab-10">
                                شیت مقصد
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-10" class="tab-pane active">
                            <div class="panel-body">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('category_id_end') ? ' has-error' : '' }}">
                                        {!! Form::select('category_id_end', $categories, null, ['placeholder' => 'دسته بندی', 'class' => 'form-control', 'id'=>'category_id_end','data-live-search'=>'true', 'onChange'=>'getSheets(this.value, '."'end'".')']) !!}
                                        @if ($errors->has('category_id_end'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('category_id_end') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" id="endSheet">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="ibox float-e-margins m-t-lg">

            <div class="ibox-content">
                <div class="row movebtn d-none">
                    <div class="col-lg-4">
                        <button class="btn btn-lg btn-primary" onclick="$('#moveSelectedFiles').submit()">
                            <i class="fa fa-long-arrow-left"></i>
                            انتقال فایل ها
                        </button>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="row">
                    <div class="col-lg-6">
                        <form onsubmit="moveSelectedFiles(this); return false;" id="moveSelectedFiles">
                            {{ csrf_field() }}
                            <div id="startTable"></div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div id="endTable"></div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>


@section('script')
    <script src="/js/persian-date.js">
    </script>
    <script src="/js/persian-datepicker.min.js">
    </script>

    <script src="/js/script.js"></script>
    <script src="/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#category_id').selectpicker();
            $('#category_id_end').selectpicker();
        })
    </script>
    <script src="/js/sweetalert.min.js"></script>
    <script>
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