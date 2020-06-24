@extends('Admin.master')
@section('title', ' افزودن محصول')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> افزودن محصول</h2>

        </div>
        <div class="col-sm-8">

        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                @include('Admin.section.errors')
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a  data-toggle="tab" href="#tab-1"> <h3 class="m-b-none">مشخصات</h3></a></li>
                        <li class=""><a  data-toggle="tab" href="#tab-2"> <h3 class="m-b-none">خدمات</h3></a></li>
                    </ul>

                    <form action="{{ route('products.store') }}" method="post" id="productForm" enctype="multipart/form-data">

                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group"><label>نام</label>
                                                    <input type="text" name="name" placeholder="نام را وارد کنید" class="form-control" value="{{ old('name') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                                                    {!! Form::label('category_id', 'دسته‌بندی ', []) !!}

                                                    {!! Form::select('category_id', $categories, null, ['placeholder' => 'انتخاب کنید', 'class' => 'form-control', 'id'=>'category_id','data-live-search'=>'true']) !!}

                                                    @if ($errors->has('category_id'))
                                                        <span class="help-block">
                                                    <strong>{{ $errors->first('category_id') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group"><label>توضیحات</label>
                                                    <textarea name="body" id="body"  class="form-control" rows="3">{{ old('body') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group"><label>طول</label>
                                                    <input type="text" name="length"  placeholder="طول را وارد کنید" class="form-control" value="{{ old('length') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group"><label>حداکثر طول</label>
                                                    <input type="text" name="max_length" placeholder="حداکثر طول  را وارد کنید" class="form-control" value="{{ old('max_length') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group"><label>عرض</label>
                                                    <input type="text" name="width"  placeholder="طول را وارد کنید" class="form-control" value="{{ old('width') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group"><label> حداکثر عرض</label>
                                                    <input type="text" name="max_width" placeholder=" حداکثر عرض  را وارد کنید" class="form-control" value="{{ old('max_width') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="form-group"><label>قیمت</label>
                                                    <input type="text" name="price" onkeyup="threeDigitNumber(this)" placeholder="قیمت را وارد کنید" class="form-control" value="{{ old('price') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group"><label>قیمت همکار</label>
                                                    <input type="text" name="partner_price" onkeyup="threeDigitNumber(this)" placeholder="قیمت همکار را وارد کنید" class="form-control" value="{{ old('partner_price') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group"><label>تعداد واحد</label>
                                                    <input type="text" name="unit" placeholder="تعداد واحد را وارد کنید" class="form-control" value="{{ old('unit') }}">
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
                                            <div class="col-lg-4">
                                                <div class="form-group"><label>زمان تحویل</label>
                                                    <input type="text" name="delivery_time" placeholder="زمان تحویل را وارد کنید" class="form-control" value="{{ old('delivery_time') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group"><label>وضعیت فوری</label>
                                                    <select name="urgent_status" id="urgent_status" class="form-control">
                                                        <option value="1">فعال</option>
                                                        <option value="0" selected>غیر فعال</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group"><label>مبلغ فوری</label>
                                                    <input type="text" name="urgent_price" id="urgent_price" onkeyup="threeDigitNumber(this)" placeholder="مبلغ فوری را وارد کنید" class="form-control" value="{{ old('urgent_price') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group"><label>مبلغ فوری همکار</label>
                                                    <input type="text" name="partner_urgent_price" id="partner_urgent_price" onkeyup="threeDigitNumber(this)" placeholder="مبلغ فوری همکار را وارد کنید" class="form-control" value="{{ old('urgent_price') }}">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group"><label>زمان تحویل فوری</label>
                                                    <input type="text" name="delivery_urgent_time" placeholder="زمان تحویل فوری را وارد کنید" class="form-control" value="{{ old('delivery_urgent_time') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group"><label>تصویر</label>
                                                    <input type="file" name="images" class="form-control" value="{{ old('images') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group"><label>فایل ها</label>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <div class="i-checks"><label> <input type="checkbox" name="allfiles[]" value="front"> <i></i> طرح رو </label></div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="i-checks"><label> <input type="checkbox" name="allfiles[]" value="back"> <i></i> طرح پشت </label></div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="i-checks"><label> <input type="checkbox" name="allfiles[]" value="uvfront"> <i></i> یووی روی طرح  </label></div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="i-checks"><label> <input type="checkbox" name="allfiles[]" value="uvback"> <i></i> یووی پشت طرح  </label></div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="i-checks"><label> <input type="checkbox" name="allfiles[]" value="goldfront"> <i></i> طلاکوب روی طرح  </label></div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="i-checks"><label> <input type="checkbox" name="allfiles[]" value="goldback"> <i></i> طلاکوب پشت طرح  </label></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                @foreach($product_services as $product_service)
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="i-checks"><label> <input type="checkbox" name="pservice_id[]" value="{{$product_service->id}}"> <i></i> {{$product_service->name}}  </label></div>
                                        </div>
                                        <div class="col-lg-2">
                                            <span><b> قیمت = </b>{{number_format($product_service->pservice_price) }}</span>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <br>
                        <button type="button" onclick="submitForm()" class="btn btn-w-m btn-info">افزودن محصول</button>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div>
@section('script')
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


        function submitForm(){
            var urgent_status = $('#urgent_status').val();
            var urgent_price = $('#urgent_price').val();

            if(urgent_status == 1){
                if(urgent_price.length == 0){
                    alert('لطفا مبلغ فوری را وارد کنید !');
                    return false;
                }
            }

            $('#productForm').submit();

        }
    </script>
@endsection
@endsection