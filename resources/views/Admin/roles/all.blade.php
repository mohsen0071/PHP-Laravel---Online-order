@extends('Admin.master')
@section('title', ' سطوح دسترسی کارمندان')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle"> سطوح دسترسی کارمندان</h2>

        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('add-employee-permission')
                <a href="{{ route('roles.create') }}" class="btn btn-primary ">ایجاد سطح دسترسی کارمندان</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>لیست سطوح دسترسی کارمندان</h5>
                </div>
                    <div class="ibox-content">

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>نام سطح دسترسی</th>

                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>

                                    <td>{{ $role->label }}</td>
                                    <td>
                                        <form action="{{ route('roles.destroy'  , ['id' => $role->id]) }}" data-title="{{$role->id}}" method="post" class="tooltip-demo frm{{$role->id}}">
                                            {{ method_field('delete') }}
                                            {{ csrf_field() }}

                                            @can('edit-employee-permission')
                                            <a href="{{ route('roles.edit' , ['id' => $role->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش ">
                                            <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete-employee-permission')
                                            <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$role->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $roles->render() !!}
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
















