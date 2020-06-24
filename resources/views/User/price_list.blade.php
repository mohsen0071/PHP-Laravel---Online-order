@extends('User.master')
@section('title', ' لیست قیمت')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> لیست قیمت</h2>

        </div>
        <div class="col-sm-8">
            <div class="title-action">

            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>لیست قیمت</h5>
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
                                <th>دسته بندی</th>
                                <th>نام محصول</th>

                                <th>قیمت</th>
                                <th> زمان تحویل</th>
                                <th> قیمت فوری</th>
                                <th> زمان تحویل فوری</th>

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
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->name }}</td>


                                    <td><b>{{ number_format($product->price) }}</b></td>
                                    <td>{{ $product->delivery_time }}</td>
                                    <td>{{ $product->urgent_price != '' ? number_format($product->urgent_price) : '' }}</td>
                                    <td>{{ $product->delivery_urgent_time }}</td>
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