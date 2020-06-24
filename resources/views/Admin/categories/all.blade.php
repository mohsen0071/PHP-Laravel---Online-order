@extends('Admin.master')
@section('title', 'دسته بندی ها')
@section('content')
    <?php
    $traverse = function ($categories, $level = 0) use (&$traverse) {
        $out = '';

        foreach ($categories as $category) {
            $name = str_repeat('-- ', $level) . $category->name;

            $route = route('categories.destroy'  , ['id' => $category->id]);
            $editRoute = route('categories.edit' , ['id' => $category->id]);

            if($category->status == 1)
            {
                $cat_status = '<small class="label label-primary">فعال</small>';
            }
            else
            {
                $cat_status = '<small class="label label-danger">غیر فعال</small>';
            }

            if($category->sheet == 1)
            {
                $sheet_status = '<small class="label label-primary">دارد</small>';
            }
            else
            {
                $sheet_status = '<small class="label label-danger">ندارد</small>';
            }

//            $resfile = '';
//            foreach ($category->allfiles as $allfile)
//            {
//                if(($allfile) === 'front')
//                {
//                    $resfile .= 'طرح رو/';
//                }
//                if(($allfile) === 'back')
//                {
//                    $resfile .= 'طرح پشت/';
//                }
//                if(($allfile) === 'uvfront')
//                {
//                    $resfile .= 'یووی روی طرح/';
//                }
//                if(($allfile) === 'uvback')
//                {
//                    $resfile .= 'یووی پشت طرح/';
//                }
//                if(($allfile) === 'goldfront')
//                {
//                    $resfile .= 'طلاکوب روی طرح/';
//                }
//                if(($allfile) === 'goldback')
//                {
//                    $resfile .= 'طلاکوب پشت طرح/';
//                }
//            }


            $out .= '<tr>';
            $out .= '<td>' . ($category->id) . '</td>';
            $out .= '<td>' . $name. '</td>';
            $out .= '<td>' . $category->pservice_unit. '</td>';
            $out .= '<td>' . $cat_status . '</td>';

            $out .= '<td>' . $category->sheet_count . '</td>';
          //  $out .= '<td>' . $resfile . '</td>';

            $out .= '<td>';
            if (Gate::allows('edit-category')) {
            $out .= '<form action="'. $route .'"  data-title="'. $category->id .'" method="post" class="tooltip-demo '.($category->id).'">'. method_field('delete') .' '. csrf_field() .' <a href="'. $editRoute .'"  class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="ویرایش "><i class="fa fa-edit"></i></a> ';
            }
            if (Gate::allows('delete-category')) {
            $out .= ' <button type="button" class="btn btn-danger btn-xs" onclick="sweet('.($category->id).')" data-toggle="tooltip" data-placement="top" title="" data-original-title="حذف "><i class="fa fa-times"></i></button> </form>';
            }
            $out .= '</td>';
            $out .= '</tr>';

            if (!$category->children->isEmpty()) {
                $out .= $traverse($category->children, $level + 1);
            }
        }

        return $out;
    };
    ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="pagetitle">دسته بندی</h2>

        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('list-category')
                    <a href="{{ route('categories.create') }}" class="btn  btn-primary">ثبت دسته بندی</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>لیست دسته بندی ها</h5>
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
                                <th>شناسه</th>
                                <th >نام دسته‌بندی</th>
                                <th >ضریب کار تکمیلی</th>
                                <th >وضعیت</th>

                                <th >ظرفیت شیت</th>
                                {{--<th >فایل ها</th>--}}

                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?= $traverse($categories) ?>
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
















