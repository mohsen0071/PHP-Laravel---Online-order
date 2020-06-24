@extends('Admin.master')
@section('title', ' محصولات')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">محصولات</h2>

        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('add-product')
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        افزودن محصول</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>لیست محصولات</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-md">
                            <div class="col-sm-3">
                                <form action="" method="get">
                                    <div class="input-group">
                                        <input type="text" placeholder="جستجو" name="search" value="{{ old('search') }}" class="input-sm form-control">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-sm btn-primary"> برو!</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>دسته بندی</th>
                                <th>وضعیت</th>
                                <th>قیمت</th>
                                <th>قیمت همکار</th>
                                <th> واحد</th>
                                <th>طول</th>
                                {{--<th> حداکثر طول</th>--}}
                                <th>عرض</th>
                                {{--<th> حداکثر عرض</th>--}}
                                <th> زمان تحویل</th>
                                <th> وضعیت فوری</th>
                                <th> قیمت فوری</th>
                                <th> قیمت فوری همکار</th>
                                <th>  تحویل فوری</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $pos=0 ?>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <?php
                                        $pos++;

                                        if(isset($_GET['page']))
                                            $pageNumber = $_GET['page'];
                                        else
                                            $pageNumber = 1;

                                        echo (($pageNumber * 10) + $pos) - 10;
                                        ?>
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>

                                    <td>{!! $product->status == 1 ? '<small class="label label-primary">فعال</small>' : '<small class="label label-danger">غیر فعال</small>' !!}</td>

                                    <td>{{ number_format($product->price) }}</td>
                                    <td>{{ $product->partner_price != '' ? number_format($product->partner_price) : '' }}</td>

                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->length }}</td>
                                    {{--<td>{{ $product->max_length }}</td>--}}
                                    <td>{{ $product->width }}</td>
                                    {{--<td>{{ $product->max_width }}</td>--}}
                                    <td>{{ $product->delivery_time }}</td>
                                    <td>{!! $product->urgent_status == 1 ? '<small class="label label-primary">فعال</small>' : '<small class="label label-danger">غیر فعال</small>' !!}</td>
                                    <td>{{ $product->urgent_price != '' ? number_format($product->urgent_price) : '' }}</td>
                                    <td>{{ $product->partner_urgent_price != '' ? number_format($product->partner_urgent_price) : '' }}</td>
                                    <td>{{ $product->delivery_urgent_time }}</td>
                                    <td>
                                        <form action="{{ route('products.destroy'  , ['id' => $product->id]) }}" data-title="{{$product->id}}" method="post" class="tooltip-demo frm{{$product->id}}">
                                            {{ method_field('delete') }}
                                            {{ csrf_field() }}
                                            @can('edit-product')
                                                <a href="{{ route('products.edit' , ['id' => $product->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش ">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete-product')
                                                <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$product->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $products->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
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