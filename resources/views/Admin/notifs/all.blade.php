@extends('Admin.master')
@section('title', 'اطلاعیه ها')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
    <h2 class="pagetitle">اطلاعیه ها</h2>

    </div>
    <div class="col-sm-8">
    <div class="title-action">
        @can('add-notif')
            <a href="{{ route('notifs.create') }}" class="btn btn-primary">
   افزودن اطلاعیه</a>
        @endcan
    </div>
    </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>لیست اطلاعیه ها</h5>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>تصویر</th>
                                <th>توسط</th>
                                <th>عنوان</th>
                                <th>بازدید</th>
                                <th>تاریخ ثبت</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $pos=0 ?>
                            @foreach($notifs as $notif)
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
                                    <td><img src="{{ $notif->images['thumb'] }}" width="50" alt=""></td>
                                    <td>
                                        @foreach($notif->user()->pluck('name','id') as $id=>$name)
                                            {{ $name }}
                                        @endforeach
                                    </td>
                                    <td>{{ $notif->title }}</td>
                                    <td>{{ $notif->viewCount }}</td>
                                    <td><?php $v = new Verta($notif->created_at); echo $v->format('H:i Y/n/j')  ?></td>
                                    <td>
                                        <form action="{{ route('notifs.destroy'  , ['id' => $notif->id]) }}" data-title="{{$notif->id}}" method="post" class="tooltip-demo frm{{$notif->id}}">
                                            {{ method_field('delete') }}
                                            {{ csrf_field() }}
                                            @can('edit-notif')
                                                <a href="{{ route('notifs.edit' , ['id' => $notif->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش ">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete-notif')
                                                <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$notif->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $notifs->render() !!}
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