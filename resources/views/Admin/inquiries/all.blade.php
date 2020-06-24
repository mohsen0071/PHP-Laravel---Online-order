@extends('Admin.master')
@section('title', 'استعلام قیمت')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">استعلام قیمت</h2>

        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="{{ route('inquiries.create') }}" class="btn  btn-primary">ثبت استعلام قیمت</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>لیست استعلام قیمت ها</h5>
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
                        <table  class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>نام </th>
                                <th>توضیحات </th>

                                <th>وضعیت</th>
                                <th>تاریخ</th>

                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $pos = 0; ?>
                            @foreach($inquiries as $inquiry)
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

                                    <td>{{ $inquiry->title }}</td>
                                    <td>{{ $inquiry->body }}</td>
                                    <td>{!! $inquiry->status == 1 ? '<small class="label label-primary">فعال</small>' : '<small class="label label-danger">غیر فعال</small>' !!}</td>
                                    <td><?php $v = new Verta($inquiry->created_at); echo $v->format('H:i - Y/m/j')  ?></td>
                                    <td>
                                        <form action="{{ route('inquiries.destroy'  , ['id' => $inquiry->id]) }}" data-title="{{$inquiry->id}}" method="post" class="tooltip-demo frm{{$inquiry->id}}">
                                            {{ method_field('delete') }}
                                            {{ csrf_field() }}

                                            <a href="{{ route('inquiries.edit' , ['id' => $inquiry->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش ">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$inquiry->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
















