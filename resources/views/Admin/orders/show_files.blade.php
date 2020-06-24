@extends('Admin.master')
@section('title', ' جزئیات سفارش')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">
                جزئیات سفارش
            </h2>

        </div>
        <div class="col-sm-8">

        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            <dic class="col-lg-12">
                                <h3>
                                    <b>
                                        شماره  سفارش:
                                    </b>
                                    <span class="text-info"> {{$orders->order_number}} </span>
                                    -

                                    عنوان سفارش :
                                    <span class="text-info">  {{$orders->name}} </span>
                                </h3>
                            </dic>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?php $dpiStatus = false; $quality = false; ?>
                        @foreach ($orders->images as $key => $image)
                            @if(isset($image['dpi']))
                                @if($image['dpi']['x'] < 300 || $image['dpi']['y'] < 300)
                                    <?php  $dpiStatus = true; ?>
                                @endif
                                @if($image['dpi']['cmyk'] != 4)
                                    <?php  $quality = true; ?>
                                @endif
                            @endif

                        @endforeach
                        {!! $quality == true ? '<div class="alert alert-danger">  <b>                              فایل شما به صورت آر جی بی ارسال شد و این مجموعه مسئولیتی در قبال تغییر رنگ احتمالی نخواهد داشت .                </b>            </div>' : '' !!}
                        {!! $dpiStatus == true ? '<div class="alert alert-danger">
                         <b>
                                فایل ارسالی شما کیفیت لازم برای چاپ را ندارد ، فایل شما باید 300 دی پی آی باشد و این مجموعه بابت کیفیت چاپ این سفارش مسئولیتی نخواهد داشت .
 </b>
                            </div>' : '' !!}
                        <div class="row" id="upfiles">
                            <div class="col-lg-12">
                                <h4>فایل ها</h4>
                                <form action="{{ route('orders.update',['id' => $orders->id]) }}"  method="post" id="frmChangeFiles" enctype="multipart/form-data" class="text-left tooltip-demo">

                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr style="    display: flex;
    justify-content: space-around;
    align-items: initial;
    width: 100%;">
                                        @foreach ($orders->images as $key => $image)

                                            <td style="font-weight: bold; text-align: center; display: flex;
    align-items: center;
    justify-content: space-between;
    flex-direction: column;">
                                                @if(($key) === 'front')
                                                    <p> طرح رو</p>
                                                @endif
                                                @if(($key) === 'back')
                                                    <p> طرح پشت</p>
                                                @endif
                                                @if(($key) === 'uvfront')
                                                    <p>یووی روی طرح</p>
                                                @endif
                                                @if(($key) === 'uvback')
                                                    <p>یووی پشت طرح</p>
                                                @endif
                                                @if(($key) === 'goldfront')
                                                    <p>طلاکوب روی طرح</p>
                                                @endif
                                                @if(($key) === 'goldback')
                                                    <p> طلاکوب پشت طرح</p>
                                                @endif
                                                <img src="{{ $image['100'] }}" alt="">
                                                    <br>
                                                    @if(isset($image['dpi']))
                                                        @if($image['dpi']['x'] < 300 || $image['dpi']['y'] < 300)
                                                            <small class="label label-danger">  dpi ≠ 300 </small>
                                                        @else
                                                            <small class="label label-primary">  dpi = 300 </small>
                                                        @endif
                                                        @if($image['dpi']['cmyk'] != 4)
                                                            <small class="label label-danger"> type ≠ cmyk </small>
                                                        @else
                                                            <small class="label label-primary"> type = cmyk </small>
                                                        @endif
                                                    @endif
                                                    <div class="hr-line-dashed"></div>
                                                    <div class="input-group">
                                                        <label class="input-group">
                                                            <span class="btn btn-success">
                                                                <input type="file" id="{{$key}}" accept=".jpg, .jpeg" onchange="setimage(this)" name="allfiles[{{$key}}]" style="display: none;">
                                                                  انتخاب فایل جدید
                                                            </span>
                                                        </label>
                                                        <img id="img{{$key}}" src="#"  style="width: 70px; float: right; display:none">
                                                    </div>

                                            </td>



                                        @endforeach
                                    </tr>

                                    </tbody>
                                </table>
                                    <input type="hidden" name="client_id" value="{{$orders->client_id}}">
                                    <input type="hidden" name="category_id" value="{{$orders->category_id}}">
                                    <input type="hidden" name="order_number" value="{{$orders->order_number}}">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <button class="btn btn-primary btn-block btn-lg"
                                                    onclick="submitForm()" type="button">
                                                <i class="fa fa-upload">
                                                </i>
                                                &nbsp;&nbsp;<span class="bold">
									بارگذاری فایل های جدید</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script>

        function submitForm()
        {
//            $("#upfiles").find("input[type=file]").each(function(index, field){
//
//                const file = field.files[0];
//
//
//                if(file.type != "image/jpeg"){
//                    checkfileup = false;
//                    alert('فایل های انتخابی شما jpg نیست !');
//                    return false;
//                }else{
//                    checkfileup = true;
//                }
//
//
//            });

            $('#frmChangeFiles').submit();

        }


        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(id).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function setimage(val){
            imageId = '#img'+val.id;
            $(imageId).show();
            readURL(val, imageId);
        }

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