@extends('Admin.master')
@section('title', 'مشتری')
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">مشتری</h2>

        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('add-client')
                <a href="{{ route('clients.create') }}" class="btn  btn-primary">ثبت مشتری</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>لیست مشتریان</h5>
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
                                <th>نوع کاربری</th>
                                <th>شرکت</th>
                                <th>تلفن همراه</th>
                                <th>تلفن ثابت</th>
                                <th>استان</th>
                                <th>شهر</th>

                                <th>وضعیت</th>

                                <th>موجودی</th>
                                <th>تاریخ ثبت نام</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $pos=0 ?>
                            @foreach($clients as $client)
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
                                    <td>{{ $client->name }}</td>
                                    <td>{!! $client->user_type == 1 ? 'عادی' : 'همکار' !!}</td>
                                    <td>{{ $client->company }}</td>
                                    <td>{{ $client->mobile }}</td>
                                    <td>{{ $client->tel }}</td>
                                    <td>@if ($client->province) {{ $client->province->name }} @endif</td>
                                    <td>@if ($client->city['name']) {{ $client->city['name'] }}  @endif</td>

                                    <td>{!! $client->status == 1 ? '<small class="label label-primary">فعال</small>' : '<small class="label label-danger">غیر فعال</small>' !!}</td>

                                    <td>

                                     @if($client->balance > 0)
                                        {!!'<span class="label  label-primary lbl-price">'.number_format($client->balance).' </span>' !!}
                                     @elseif($client->balance < 0)
                                        {!!  '<span class="label label-danger lbl-price">'.number_format($client->balance).'</span>'  !!}
                                     @else
                                        {{number_format($client->balance)}}
                                    @endif

                                    </td>
                                    <td><?php $v = new Verta($client->created_at); echo $v->format('H:i - Y/n/j')  ?></td>
                                    <td>
                                        <form action="{{ route('users.destroy'  , ['id' => $client->id]) }}" data-title="{{$client->id}}" method="post" class="tooltip-demo frm{{$client->id}}">
                                            {{ method_field('delete') }}
                                            {{ csrf_field() }}
                                            {{--@can('edit-client')--}}
                                            {{--<a href="{{ route('clients.edit' , ['id' => $client->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش ">--}}
                                                {{--<i class="fa fa-edit"></i>--}}
                                            {{--</a>--}}
                                            {{--@endcan--}}
                                            @can('add-order-client')
                                            <a href="{{ route('clients.order' , ['id' => $client->id]) }}"  class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ثبت سفارش">
                                                <i class="fa fa-external-link"></i>
                                            </a>
                                            @endcan
                                            @can('edit-client')
                                            <a href="{{ route('clients.edit' , ['id' => $client->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="مشخصات مشتری">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @endcan
                                            @can('delete-client')
                                            <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$client->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $clients->render() !!}
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
















