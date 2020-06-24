@extends('User.master')
@section('title', '  افزودن استعلام قیمت')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">   افزودن استعلام قیمت  </h2>

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
                                    <form action="{{ route('user.addPinquiries') }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="inquiry_id" value="0">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group"><label>عنوان</label>
                                                    <input type="text" name="title" placeholder="عنوان را وارد کنید" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group"><label>توضیحات</label>
                                                    <textarea name="body" id="body" class="form-control" cols="30" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>





                                        <div class="form-group">
                                            <br>
                                            <button type="submit" class="btn btn-w-m btn-info"> افزودن استعلام </button>
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
    <script>

        function getCities(province_id, targetObj, cityId) {
            $.ajax({
                url: '/cities/' + province_id,
                type: 'GET',
                cache: false,
                dataType: 'json',
                beforeSend: function () {
                    targetObj
                        .attr('disabled', true)
                        .find('option:first').attr('selected', 'selected')
                        .html('دریافت لیست شهرها');
                },
                complete: function () {

                    if(cityId){
                        targetObj
                            .attr('disabled', false)
                        //  .find('option:first').attr('selected', 'selected');
                    }else{
                        targetObj
                            .attr('disabled', false)
                            .find('option:first').attr('selected', 'selected');
                    }

                },
                error: function (jqXHR) {
                    var errorText = getHttpStatus(jqXHR.status, jqXHR.responseText);
                    message(errorText, 'error');
                },
                success: function (data) {
                    var options = '<option value="">انتخاب کنید</option>';
                    $.each(data, function (k, v) {
                        console.log(cityId);
                        if(cityId === k)
                        {
                            options += '<option value="' + k + '" selected="selected">' + v + '</option>';
                        }
                        else
                        {
                            options += '<option value="' + k + '">' + v + '</option>';
                        }

                    });
                    targetObj.html(options);
                }
            });
        }


        $(document).ready(function(){
            var e = document.getElementById("province");
            var provinceId = e.options[e.selectedIndex].value;
            if(provinceId){
                cityId = $('#city_id').val();
                getCities(provinceId, $('#data-city-id'), cityId);

            }
        });

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