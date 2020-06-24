@extends('Admin.master')
@section('title', 'شیت ها')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">شیت ها</h2>

        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('add-sheet')
                <a href="{{ route('sheets.create') }}" class="btn btn-primary">
                    افزودن شیت</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>لیست شیت ها</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <form action="" method="get">
                            <div class="col-sm-3">
                                <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">


                                    {!! Form::select('category_id', $categories, null, ['placeholder' => 'دسته بندی', 'class' => 'form-control', 'id'=>'category_id','data-live-search'=>'true']) !!}

                                    @if ($errors->has('category_id'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('category_id') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">وضعیت</option>
                                        <option value="1" {{request('status') == 1 ? 'selected' : ''}}>در انتظار فرم بندی</option>
                                        <option value="2" {{request('status') == 2 ? 'selected' : ''}}>فرم بندی و لیتوگرافی</option>
                                        <option value="3" {{request('status') == 3 ? 'selected' : ''}}>چاپ</option>
                                        <option value="4" {{request('status') == 4 ? 'selected' : ''}}>برش و بسته بندی</option>
                                        <option value="5" {{request('status') == 5 ? 'selected' : ''}}>آماده تحویل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">

                                <button type="submit" class="btn btn-primary">جستجو</button>
                                <a href="{{route('sheets.index')}}" class="btn btn-primary">نمایش همه</a>
                                </div>
                            </div>
                            </form>
                        </div>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>شناسه شیت</th>
                                <th>دسته بندی</th>
                                <th>توسط</th>
                                <th>استفاده شده</th>
                                <th>ظرفیت باقیمانده</th>
                                <th>وضعیت</th>
                                <th>توضیحات</th>
                                <th> تاریخ ایجاد شیت</th>
                                <th> تاریخ اولین سفارش در شیت</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($sheets as $sheet)
                                <tr>
                                    <td>
                                        {{ $sheet->id }}
                                    </td>

                                    <td>{{ $sheet->category->name }}</td>
                                    <td>{{ $sheet->user->name }}</td>
                                    <td><small class="label label-danger">{{ $sheet->used_unit }}</small></td>
                                    <td><small class="label label-primary">{{ $sheet->remining_unit }}</small></td>
                                    <td>
                                            @if($sheet->status == 1)
                                                <small class="label label-default">در انتظار فرم بندی</small>
                                            @elseif($sheet->status == 2)
                                                <small class="label label-warning">فرم بندی و لیتوگرافی</small>
                                            @elseif($sheet->status == 3)
                                                <small class="label label-info">چاپ</small>
                                            @elseif($sheet->status == 4)
                                                <small class="label label-success">برش و بسته بندی</small>
                                            @else
                                                <small class="label label-primary">آماده تحویل</small>
                                            @endif

                                    </td>
                                    <td>{{ $sheet->body }}</td>
                                    <td><?php $v = new Verta($sheet->created_at); echo $v->format('H:i - Y/n/j')  ?></td>
                                    <td><?php $v = new Verta($sheet->firstOrderDate); echo $v->format('H:i - Y/n/j')  ?></td>
                                    <td>
                                        <form action="{{ route('sheets.destroy'  , ['id' => $sheet->id]) }}" data-title="{{$sheet->id}}" method="post" class="text-left tooltip-demo frm{{$sheet->id}}">
                                            {{ method_field('delete') }}
                                            {{ csrf_field() }}
                                            @if($sheet->used_unit > 0)
                                            <a href="{{ route('sheets.show' , ['id' => $sheet->id]) }}"  target="_blank" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="نمایش سفارش های فرم ">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @endif
                                            @can('edit-sheet')
                                            <a href="{{ route('sheets.edit' , ['id' => $sheet->id]) }}"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش ">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete-sheet')
                                            <button type="button" class="btn btn-danger btn-xs" onclick="sweet('frm{{$sheet->id}}')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $sheets->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script src="/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#category_id').selectpicker();

            //Get the text using the value of select
            var text = $("select[name=category_id] option[value='{{request('category_id')}}']").text();
            //We need to show the text inside the span that the plugin show
            $('.bootstrap-select .filter-option').text(text);
            //Check the selected attribute for the real select
            $('select[name=category_id]').val({{request('category_id')}});

        })
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