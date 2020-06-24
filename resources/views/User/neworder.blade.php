@extends('User.master')
@section('title', '  ثبت سفارش')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">  ثبت سفارش </h2>

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
                                    <form action="{{ route('user.storeNewOrder')}}" id="orderform"   method="post" enctype="multipart/form-data">                                    <div class="row">
                                            {{ csrf_field() }}
                                            <div class="col-lg-7">
                                                <input type="hidden" id="price">
                                                <input type="hidden" name="maxSheetUnit" id="maxSheetUnit">
                                                <input type="hidden" name="unit" id="productUnit">
                                                <input type="hidden" id="pservicesPrice" value="0">
                                                <input type="hidden" id="pserviceUnit">
                                                <input type="hidden" id="priceUrgent">
                                                <input type="hidden" name="length" id="minLengthProduct">
                                                <input type="hidden" name="maxLength" id="maxLengthProduct">
                                                <input type="hidden" name="width" id="minWidthProduct">
                                                <input type="hidden" name="maxWidth" id="maxWidthProduct">
                                                <input type="hidden" name="discountAmount" id="discountAmount">
                                                <input type="hidden" name="setDiscount" id="setDiscount" value="1">
                                                <input type="hidden" name="client_id" id="client_id" value="{{ auth()->user()->id }}">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div class="form-group"><label>عنوان سفارش</label>
                                                            <input type="text" id="orderTitle" name="name" placeholder="عنوان پروژه خود را جهت درج در فاکتور بیان کنید" class="form-control" value="{{ old('name') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div class="form-group"><label>نوع سفارش</label>
                                                            <label for=""></label>
                                                            <select name="" id="" class="form-control" onchange="getChildCategory(this.value)">
                                                                <option value=""></option>
                                                                @foreach($categories as $category)
                                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8" >
                                                        <div class="form-group"  id="childCategory">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8" >
                                                        <div class="form-group"  id="selectProduct">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="customLength">

                                                </div>
                                                <div class="row d-none" id="range-box">
                                                    <div class="col-lg-8" >
                                                        <div class="form-group">
                                                            <div class="col-lg-4">
                                                                <label>تیراژ</label>
                                                                <input type="text" maxlength="2"
                                                                       onkeyup="justNumber(this); $('#myRange').val( $('#newmyRange').val() * 1000); finalCalculate()"
                                                                       onchange="$('#myRange').val( $('#newmyRange').val() * 1000); finalCalculate()"
                                                                       onclick="$('#myRange').val( $('#newmyRange').val() * 1000); finalCalculate()"
                                                                       class="form-control"  id="newmyRange">
                                                                <input type="hidden"  onchange="finalCalculate()"  onclick="finalCalculate()"  class="form-control" name="range" id="myRange">

                                                            </div>
                                                            <div class="col-lg-2">
                                                                <br> <br><span style="    font-weight: bold;
    font-size: 17px;
    position: relative;
    top: -5px;
    left: 15px;">* 1000</span>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="hr-line-dashed"></div>
                                                {{--<div class="row d-none" id="range-box">--}}
                                                    {{--<div class="col-lg-8" >--}}
                                                        {{--<div class="form-group"><label>تیراژ</label>--}}

                                                            {{--<input type="range" name="range" min="1000" onchange="finalCalculate()" onclick="finalCalculate()" max="100000" value="1000" step="1000" class="slider" id="myRange">--}}
                                                            {{--<div id="res-range"></div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                <div id="pservices">

                                                </div>

                                                <div class="hr-line-dashed"></div>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div id="upfiles"></div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                                <div class="row" id="urgent">

                                                </div>
                                                <div class="hr-line-dashed"></div>
                                                <div class="row d-none">
                                                    <div class="col-lg-8 d-none" id="design-box">
                                                        <div class="form-group"><label>هزینه طراحی</label>
                                                            <input type="text" id="price_design"  name="price_design" onkeyup="threeDigitNumber(this); finalCalculate();" placeholder="هزینه طراحی را وارد کنید" class="form-control" value="{{ old('price_design') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8 d-none" id="body-box">
                                                        <div class="form-group"><label>توضیحات</label>
                                                            <textarea name="body" id="body" class="form-control" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="order-box p-sm fixedElement">
                                                            <h2 id="titleProduct"></h2>
                                                            <div class="hr-line-dashed"></div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <h3>
                                                                        <i class="fa fa-angle-left"></i>
                                                                        طول
                                                                    </h3>
                                                                </div>
                                                                <div class="col-lg-6 text-left">
                                                                    <h3>
                                                                        <b id="lengthText"></b>
                                                                        سانتیمتر
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <h3>
                                                                        <i class="fa fa-angle-left"></i>
                                                                        عرض
                                                                    </h3>
                                                                </div>
                                                                <div class="col-lg-6 text-left">
                                                                    <h3>
                                                                        <b id="widthText"></b>
                                                                        سانتیمتر
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <h3>
                                                                        <i class="fa fa-angle-left"></i>
                                                                        تیراژ
                                                                    </h3>
                                                                </div>
                                                                <div class="col-lg-6 text-left">
                                                                    <h3>
                                                                        <b id="rangeText"></b>
                                                                        عدد
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <h3>
                                                                        <i class="fa fa-angle-left"></i>
                                                                        تعداد واحد
                                                                    </h3>
                                                                </div>
                                                                <div class="col-lg-6 text-left">
                                                                    <h3>
                                                                        <b id="unitText"></b>
                                                                        واحد
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div class="hr-line-dashed m-b-sm"></div>
                                                            <div class="row text-warning d-none">
                                                                <div class="col-lg-6">
                                                                    <h3>
                                                                        <i class="fa fa-angle-left"></i>
                                                                        هزینه طراحی
                                                                    </h3>
                                                                </div>
                                                                <div class="col-lg-6 text-left">
                                                                    <h3>
                                                                        <b id="priceDesign">0</b>
                                                                        ریال
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                                                            <div class="row text-warning">
                                                                <div class="col-lg-6">
                                                                    <h3>
                                                                        <i class="fa fa-angle-left"></i>
                                                                        خدمات چاپ
                                                                    </h3>
                                                                </div>
                                                                <div class="col-lg-6 text-left">
                                                                    <h3>
                                                                        <b id="pservicePriceText">0</b>
                                                                        ریال
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div class="hr-line-dashed m-b-sm m-t-sm"></div>
                                                            <div class="row text-info">
                                                                <div class="col-lg-6">
                                                                    <h3>
                                                                        <i class="fa fa-angle-left"></i>

                                                                        قیمت سفارش
                                                                        <span id="urgentTextPrice" class="text-danger" style="display:none;">(**فوری**)</span>
                                                                    </h3>
                                                                </div>
                                                                <div class="col-lg-6 text-left">
                                                                    <h3>
                                                                        <b id="orderPrice">0</b>
                                                                        ریال
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div class="hr-line-dashed m-t-sm"></div>
                                                            <div class="row text-danger d-none" id="discount">
                                                                <div class="col-lg-6">
                                                                    <h3>
                                                                        <i class="fa fa-angle-left"></i>
                                                                        تخفیف
                                                                    </h3>
                                                                </div>
                                                                <div class="col-lg-6 text-left">
                                                                    <h3>
                                                                        <b class="discountPrice">0</b>
                                                                        ریال
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            <div class="hr-line-dashed m-t-sm"></div>
                                                            <div class="row text-green">
                                                                <div class="col-lg-6">
                                                                    <h3>
                                                                        <i class="fa fa-angle-left"></i>
                                                                        قیمت نهایی
                                                                    </h3>
                                                                </div>
                                                                <div class="col-lg-6 text-left">
                                                                    <h3>
                                                                        <b id="finalPrice">0</b>
                                                                        ریال
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group" id="bodyProduct">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-none" id="insert-box">
                                            <div class="col-lg-12">
                                                <button class="btn btn-info btn-lg" onclick="submitFrom()" type="button">
                                                    <i class="fa fa-shopping-cart">
                                                    </i>
                                                    ثبت سفارش</button>
                                            </div>
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
        $(window).scroll(function(e){
            console.log($( window ).width() );
            if($( window ).width() > 700) {
                var $el = $('.fixedElement');
                var isPositionFixed = ($el.css('position') == 'fixed');
                if ($(this).scrollTop() > 200 && !isPositionFixed) {
                    $el.css({'position': 'fixed', 'top': '0px'});
                }
                if ($(this).scrollTop() < 200 && isPositionFixed) {
                    $el.css({'position': 'static', 'top': '0px'});
                }
            }
        });
    </script>

    <script src="/js/script.js"></script>
    <script src="/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#category_id').selectpicker();
        })
    </script>
    <script src="/js/icheck.min.js"></script>
    <script>

        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

        });
    </script>
    {{--<script>--}}

        {{--var slider = document.getElementById("myRange");--}}
        {{--var output = document.getElementById("res-range");--}}
        {{--output.innerHTML = slider.value; // Display the default slider value--}}

        {{--// Update the current slider value (each time you drag the slider handle)--}}
        {{--slider.oninput = function() {--}}
            {{--output.innerHTML = this.value;--}}
        {{--}--}}
    {{--</script>--}}
    <script>
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
@endsection
@endsection