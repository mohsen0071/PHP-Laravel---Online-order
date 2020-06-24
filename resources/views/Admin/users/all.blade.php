@extends('Admin.master')
@section('title', ' کارمند')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">کارمند</h2>

        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('add-user')
                <a href="{{ route('users.create') }}" class="btn  btn-primary">ثبت کارمند</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>لیست کارمندان</h5>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>موبایل </th>
                                <th>ایمیل</th>

                                <th>وضعیت</th>
                                <th>سطح دسترسی</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $pos=0 ?>
                            @foreach($users as $user)
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
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>{{ $user->email }}</td>

                                    <td>{!! $user->status == 1 ? '<small class="label label-primary">فعال</small>' : '<small class="label label-danger">غیر فعال</small>' !!}</td>
                                    <td><b>
                                            @foreach ( $user->roles as $r)
                                                {{ $r['label'] }}
                                            @endforeach
                                        </b>
                                    </td>
                                    <td>
                                        <form action="{{ route('users.destroy'  , ['id' => $user->id]) }}" data-title="{{$user->id}}" method="post" class="tooltip-demo frm{{$user->id}}">
                                            {{ method_field('delete') }}
                                            {{ csrf_field() }}
                                            @can('edit-user')
                                            <a href="{{ route('users.edit' , ['id' => $user->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش ">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete-user')
                                            <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$user->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $users->render() !!}
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
















