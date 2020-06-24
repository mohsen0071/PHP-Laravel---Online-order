@extends('User.master')
@section('title', ' گردش حساب')
@section('content')
@section('style')
    <link href="/css/persian-datepicker.min.css" rel="stylesheet">
@endsection
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2 class="pagetitle"> گردش حساب </h2>

    </div>
    <div class="col-sm-8">

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
                                <form action="" method="get">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">تاریخ ثبت از</label>
                                            <div class="input-group date">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </span>
                                                <input id="date_from" name="date_from" type="text" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">تاریخ ثبت تا</label>
                                            <div class="input-group date">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </span>
                                                <input id="date_to" name="date_to" type="text" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">نوع تراکنش</label>
                                            <select name="transaction_type" id="transaction_type" class="form-control">
                                                <option value="">نوع تراکنش را انتخاب کنید</option>
                                                <option value="1" {{request('transaction_type') == 1 ? 'selected' : ''}}>سفارش</option>
                                                <option value="2" {{request('transaction_type') == 2 ? 'selected' : ''}}>ثبت مدیر</option>
                                                <option value="3" {{request('transaction_type') == 3 ? 'selected' : ''}}>پرداخت آنلاین</option>
                                                <option value="4" {{request('transaction_type') == 4 ? 'selected' : ''}}>پرداخت حساب کاربری</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary m-t-md">جستجو</button>
                                            <a href="/user/transactions" class="btn btn-primary m-t-md">نمایش همه</a>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3 class="text-right">جمع کل:
                                            <span class="{{$sumall > 0 ? 'text-green' : 'text-danger'}}"> {{number_format($sumall)}} </span>ریال</h3>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>نام مشتری</th>
                                        <th>مبلغ</th>
                                        <th>بیعانه</th>
                                        <th>تخفیف</th>
                                        <th> مانده حساب</th>
                                        <th>نوع تراکنش</th>
                                        <th>زمان ثبت</th>

                                        <th>توسط</th>
                                        <th> توضیحات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $pos=0;   ?>

                                    @foreach($transactions as $transaction)

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
                                            <td>{{$transaction->client->name}}</td>
                                            <td>
                                                @if($transaction->price > 0)
                                                    <span class="text-green-n">{{number_format($transaction->price)}}</span>
                                                @else
                                                    <span class="text-danger">{{number_format($transaction->price)}}</span>
                                                @endif
                                            </td>
                                            <td>{{($transaction->deposit)}}</td>
                                            <td>{{($transaction->discount)}}</td>
                                            <td>{{number_format($transaction->rest_balance)}}</td>
                                            <td>
                                                @if($transaction->transaction_type == 1)
                                                    سفارش
                                                @elseif($transaction->transaction_type == 2)
                                                    ثبت مدیر
                                                @elseif($transaction->transaction_type == 3)
                                                    پرداخت آنلاین
                                                @elseif($transaction->transaction_type == 4)
                                                    پرداخت حساب کاربری
                                                @else

                                                @endif

                                            </td>
                                            <td><?php $v = new Verta($transaction->created_at); echo $v->format('H:i - Y/n/j')  ?></td>

                                            <td>{{$transaction->user->name}}</td>
                                            <td>{!!  $transaction->body !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {!! $transactions->render() !!}

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
        $('#date_from').persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD'
        })
        @if(request('date_from'))
        .pDatepicker('setDate', [{{ substr(request('date_from'), 0, 4)}}, {{substr(request('date_from'), 5, 2)}}, {{substr(request('date_from'), 8, 2)}}, 0, 0]);
        @endif
        $('#date_to').persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD'
        })
        @if(request('date_to'))
        .pDatepicker('setDate', [{{substr(request('date_to'), 0, 4)}}, {{substr(request('date_to'), 5, 2)}}, {{substr(request('date_to'), 8, 2)}}, 0, 0]);
        @endif
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