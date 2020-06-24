@extends('Admin.master')
@section('title', '  سفارشات شیت  ')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h3 class="m-t-md m-b-n">{{$orders[0]->category->name}} -
                استفاده شده:
               <span class="text-danger">{{$sheet->used_unit}}</span>
                ظرفیت باقیمانده:
                <span class="text-green"> {{$sheet->remining_unit}}</span>
                <br>
                <br>
                @if($sheet->status == 1)
                    <span class="label label-default">در انتظار فرم بندی</span>
                @elseif($sheet->status == 2)
                    <span class="label label-warning">فرم بندی و لیتوگرافی</span>
                @elseif($sheet->status == 3)
                    <span class="label label-info">چاپ</span>
                @elseif($sheet->status == 4)
                    <span class="label label-success">برش و بسته بندی</span>
                @else
                    <span class="label label-primary">آماده تحویل</span>
                @endif

            </h3>

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
                        <h5>لیست سفارش ها</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('sheets.sheets-zip') }}" method="get">
                            <input type="hidden" name="zipFileName" value="{{Request::segment(3)}}-{{$orders[0]->category->name}}">
                            <div class="row">
                            <div class="col-lg-12">
                                <button    class="btn btn-danger">
                                    <i class="fa fa-cloud-download">
                                    </i>
                                    &nbsp;&nbsp;<span class="bold">
									دانلود گروهی </span>
                                </button>

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th><div class="i-checks all" data-title="order"><label> <input type="checkbox" value=""> <i></i>   </label></div>
                                </th>
                                <th> #</th>
                                <th>تصویر </th>
                                <th>نام مشتری </th>
                                <th>نوع کاربری </th>
                                <th>شماره تماس </th>
                                <th>مانده حساب </th>
                                <th>اندازه سفارش  </th>
                                <th>تعداد  </th>
                                <th>تاریخ سفارش  </th>
                                <th>  </th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $pos=0 ?>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div class="i-checks order"><label> <input type="checkbox" name="order_id[]" value="{{$order->images['front']['original']}}"> <i></i>  </label></div>
                                    </td>
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

                                    <td>
                                        <img src="{{$order->images['front']['100']}}" alt="">
                                    </td>
                                    <td>{{$order->client->name}}</td>
                                    <td></td>
                                    <td>{{$order->client->mobile}}</td>
                                    <td>

                                        @if($order->client->balance > 0)
                                            {!!'<span class="label  label-primary lbl-price">'.number_format($order->client->balance).' </span>' !!}
                                        @elseif($order->client->balance < 0)
                                            {!!  '<span class="label label-danger lbl-price">'.number_format($order->client->balance).'</span>'  !!}
                                        @else
                                            {{number_format($order->client->balance)}}
                                        @endif

                                    </td>
                                    <td>طول: {{$order->length}}
                                        -
                                        عرض: {{$order->width}}
                                    </td>
                                    <td>{{$order->range}}</td>
                                    <td><?php $v = new Verta($order->created_at); echo $v->format('H:i - Y/n/j')  ?></td>
                                     <td>
                                         <a href="{{$order->images['front']['original']}}"   class="btn btn-success" download>
                                             <i class="fa fa-cloud-download">
                                             </i>
                                             &nbsp;&nbsp;<span class="bold">
									دریافت فایل</span>
                                         </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </form>
                        {!! $orders->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')

    <script src="/js/icheck.min.js"></script>
    <script>

        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });


            $('.i-checks').on('ifChecked', function(event){
                var data = $(this).data('title');
                if(data && data != 'undefined'){
                    if(data == 'all'){
                        $('.i-checks').iCheck('check');
                    }else {
                        $('.i-checks.' + data).iCheck('check');
                    }
                }

            });
            $('.i-checks').on('ifUnchecked', function(event){
                var data = $(this).data('title');
                if(data && data != 'undefined'){
                    if(data == 'all'){
                        $('.i-checks').iCheck('uncheck');
                    }else{
                        $('.i-checks.'+data).iCheck('uncheck');
                    }
                }
            });


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