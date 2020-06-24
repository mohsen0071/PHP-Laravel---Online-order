@extends('User.master')
@section('title', ' استعلام قیمت ')
@section('content')
@section('style')
    <link href="/css/persian-datepicker.min.css" rel="stylesheet">
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2 class="pagetitle"> استعلام قیمت </h2>

    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="{{ route('user.addPinquiries') }}" class="btn  btn-primary">ثبت استعلام قیمت</a>
        </div>
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
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> نام مشتری</th>
                                        <th>عنوان</th>


                                        <th>توضیحات</th>
                                        <th>  وضعیت </th>
                                        <th> تاریخ</th>

                                        <th> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $pos=0;   ?>

                                    @foreach($pinquiries as $pinquiry)


                                        <tr>
                                            <td>
                                                <?php
                                                $pos++;

                                                if(isset($_GET['page']))
                                                    $pageNumber = $_GET['page'];
                                                else
                                                    $pageNumber = 1;

                                                echo (($pageNumber * 50) + $pos) - 50;
                                                ?>

                                            </td>

                                            <td>{{ $pinquiry->client->name }}</td>

                                            <td>{{ $pinquiry->title }}</td>
                                            <td>{{ mb_substr($pinquiry->body,0,50,'utf-8').'...'  }}</td>

                                            <td>
                                                @if($pinquiry->status == 1)
                                                    {!! $pinquiry->status == 1 ? '<small class="label label-primary">تایید کاربر </small>' : ''!!}
                                                @else
                                                    {!! $pinquiry->statusLastMess !!}
                                                @endif
                                                {{--@if( == 0)--}}
                                                {{--<small class="label label-danger">جدید</small>--}}
                                                {{--@elseif($pinquiry->status == 1)--}}
                                                {{--<small class="label label-warning">در انتظار پاسخ</small>--}}
                                                {{--@elseif($pinquiry->status == 2)--}}
                                                {{--<small class="label label-info">پاسخ داده شده</small>--}}
                                                {{--@elseif($pinquiry->status == 3)--}}
                                                {{--<small class="label label-primary">تایید کاربر</small>--}}
                                                {{--@elseif($pinquiry->status == 4)--}}
                                                {{--<small class="label label-success">بسته شده</small>--}}
                                                {{--@else--}}

                                                {{--@endif--}}

                                            </td>
                                            <td><?php $v = new Verta($pinquiry->created_at); echo $v->format('H:i - Y/n/j')  ?></td>
                                            <td class="text-left">
                                                @if($pinquiry->status == 0)
                                                <form action="{{ route('user.removePinquiries'  , ['id' => $pinquiry->id]) }}" data-title="{{$pinquiry->id}}" method="post" class="text-left tooltip-demo frm{{$pinquiry->id}}">
                                                    {{ method_field('delete') }}
                                                    {{ csrf_field() }}

                                                    <a href="{{ route('user.showMessinqus' , ['id' => $pinquiry->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ارسال پاسخ ">
                                                        <i class="fa fa-mail-reply"></i>
                                                    </a>

                                                    <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$pinquiry->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-trash"></i></button>

                                                </form>
                                                @else
                                                    <a href="{{ route('user.showMessinqus' , ['id' => $pinquiry->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ارسال پاسخ ">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {!! $pinquiries->render() !!}

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
    <script src="/js/persian-date.js">
    </script>
    <script src="/js/persian-datepicker.min.js">
    </script>
    <script>
        $('#date_added').persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD'
        });
    </script>
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