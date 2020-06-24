@extends('Admin.master')
@section('title', 'تخفیف ها')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">تخفیف ها</h2>

        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('add-discount')
                <a href="{{ route('discounts.create') }}" class="btn btn-primary">
                    افزودن تخفیف</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>لیست تخفیف ها</h5>
                    </div>
                    <div class="ibox-content">
                        {{--<div class="row">--}}
                            {{--<form action="" method="get">--}}
                                {{--<div class="col-sm-3">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<select name="status" id="status" class="form-control">--}}
                                            {{--<option value="">وضعیت</option>--}}
                                            {{--<option value="1">فعال</option>--}}
                                            {{--<option value="0">غیر فعال</option>--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-3">--}}
                                    {{--<div class="form-group">--}}

                                        {{--<button type="submit" class="btn btn-primary">جستجو</button>--}}
                                        {{--<a href="{{route('discounts.index')}}" class="btn btn-primary">نمایش همه</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                        <?php $pos=0 ?>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>

                                {{--<th>نوع مبلغ</th>--}}
                                <th>درصد</th>
                                {{--<th>حداقل مبلغ سفارش</th>--}}
                                {{--<th>حداکثر مبلغ سفارش</th>--}}
                                {{--<th> نوع کد تخفیف </th>--}}
                                {{--<th> استفاده </th>--}}
                                <th> تاریخ ایجاد </th>
                                <th> تاریخ انقضا</th>
                                <th> توضیحات</th>
                                <th> وضعیت </th>

                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($discounts as $discount)
                                <tr>
                                    <td>
                                        <?php
                                        $pos++;

                                        if(isset($_GET['page']))
                                            $pageNumber = $_GET['page'];
                                        else
                                            $pageNumber = 1;

                                        echo (($pageNumber * 25) + $pos) - 25;
                                        ?>
                                    </td>

                                    {{--<td>{{ $discount->amount_type == 1 ? 'درصدی' : 'مقداری'  }}</td>--}}
                                    <td>{{ $discount->amount_type == 1 ? '%'.$discount->amount : number_format($discount->amount) }}</td>
                                    {{--<td>{{ number_format($discount->minAmount)  }}</td>--}}
                                    {{--<td>{{ number_format($discount->maxAmount)  }}</td>--}}
                                    {{--<td>--}}
                                        {{--@if($discount->type == 1)--}}
                                            {{--یکبار مصرف--}}
                                        {{--@elseif($discount->type == 2)--}}
                                            {{--چندبار مصرف هر مشتری یکبار--}}
                                        {{--@elseif($discount->type == 3)--}}
                                            {{--چندبار مصرف بدون محدودیت روی مشتری--}}
                                        {{--@else--}}
                                            {{--اولین خرید--}}
                                        {{--@endif--}}

                                    {{--</td>--}}
                                    <td><?php $v = new Verta($discount->created_at); echo $v->format('H:i - Y/m/d')  ?></td>
                                    <td><?php
                                        if($discount->expireDate < $v->format('Y/m/d')){
                                            echo '<small class="label label-danger">'. $discount->expireDate .'</small>';
                                        }else{
                                            echo '<small class="label label-primary">'. $discount->expireDate .'</small>';
                                        }
                                        ?>
                                    </td>
                                    <td>{{$discount->body}}</td>
                                    <td>{!! $discount->status == 1 ? '<small class="label label-primary">فعال</small>' : '<small class="label label-danger">غیر فعال</small>' !!}</td>
                                    <td>
                                        <form action="{{ route('discounts.destroy'  , ['id' => $discount->id]) }}" data-title="{{$discount->id}}" method="post" class="tooltip-demo frm{{$discount->id}}">
                                            {{ method_field('delete') }}
                                            {{ csrf_field() }}
                                            @can('edit-discount')
                                            <a href="{{ route('discounts.edit' , ['id' => $discount->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش ">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete-discount')
                                            <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$discount->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $discounts->render() !!}
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