<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                                <span>
                                    <img alt="image" class="img-circle" width="50" height="50" src="{{ (auth()->user()->images)  }}" />
                                </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear">
                                        <span class="block m-t-xs">
                                            <strong class="font-bold">
                                            {{ auth()->user()->name }}</strong>
                                        </span>
                                        <span class="text-muted text-xs block">
                                         <b class="caret">
                                            </b>
                                            {{$role}}
                                        </span>
                                    </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft m-t-xs">
                        <li>
                            <a href="/admin/profile">
                                پروفایل</a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            <a href="/logout">
                                خروج</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                     چاپ
                </div>
            </li>
            <li <?= strpos(Request::url(),'panel') !== false ? ' class="active"' : '' ?>>
                <a href="/admin/panel">
                    <i class="fa fa-th-large">
                    </i>
                    <span class="nav-label">پیشخوان</span>
                </a>
            </li>
            <li <?= strpos(Request::url(),'users') !== false ? ' class="active"' : '' ?> <?= strpos(Request::url(),'clients') !== false ? ' class="active"' : '' ?> <?= strpos(Request::url(),'roles') !== false ? ' class="active"' : '' ?>>
                @can('list-user')
                <a href="#">
                    <i class="fa fa-user">
                    </i>
                    <span class="nav-label">کاربران</span>
                    <span class="fa arrow">
                                </span>
                </a>
                @endcan
                <ul class="nav nav-second-level collapse">
                    @can('list-user')
                    <li <?= strpos(Request::url(),'users') !== false ? ' class="active"' : '' ?>>
                    <a href="/admin/users">

                             مدیریت کارمندان</a>
                    </li>
                    @endcan
                    @can('list-employee-permission')
                    <li <?= strpos(Request::url(),'roles') !== false ? ' class="active"' : '' ?>>
                        <a href="/admin/roles">
                            سطوح دسترسی کارمندان</a>
                    </li>
                    @endcan
                    @can('list-client')
                    <li <?= strpos(Request::url(),'clients') !== false ? ' class="active"' : '' ?>>
                        <a href="/admin/clients">
                          مدیریت مشتریان</a>
                    </li>
                    @endcan
                </ul>
            </li>


            <li <?= strpos(Request::url(),'categories') !== false ? ' class="active"' : '' ?> <?= strpos(Request::url(),'products') !== false ? ' class="active"' : '' ?><?= strpos(Request::url(),'product-service') !== false ? ' class="active"' : '' ?>  <?= strpos(Request::url(),'/inquiries') !== false ? ' class="active"' : '' ?> >
                @can('list-product')
            <a href="#">
                        <i class="fa fa-folder-o">
                        </i>
                        <span class="nav-label">محصولات</span>
                        <span class="fa arrow">
                                </span>
                    </a>
                @endcan
                    <ul class="nav nav-second-level collapse">
                        @can('list-category')
                        <li <?= strpos(Request::url(),'categories') !== false ? ' class="active"' : '' ?>>
                            <a href="/admin/categories">
                                 دسته بندی ها</a>

                        </li>
                        @endcan
                            @can('list-product')
                            <li <?= strpos(Request::url(),'products') !== false ? ' class="active"' : '' ?>>
                                <a href="/admin/products">
                                    محصولات</a>
                            </li>
                            @endcan
                            @can('list-pservice')
                        <li <?= strpos(Request::url(),'product-service') !== false ? ' class="active"' : '' ?>>
                                <a href="/admin/product-service">
                                   خدمات محصولات</a>
                            </li>
                            @endcan

                    </ul>
                </li>

            <li <?= strpos(Request::url(),'orders') !== false ? ' class="active"' : '' ?> <?= strpos(Request::url(),'admin/pinquiries') !== false ? ' class="active"' : '' ?>>
                @can('list-order')
                <a href="#">
                    <i class="fa fa-external-link">
                    </i>
                    <span class="nav-label">

                        سفارشات

                    </span>
                    <span class="fa arrow">
                                </span>
                </a>
                @endcan
                <ul class="nav nav-second-level collapse">
                    @can('list-order')
                    <li <?= strpos(Request::url(),'orders') !== false ? ' class="active"' : '' ?>>
                        <a href="/admin/orders">

                            مدیریت سفارشات


                             <span class="label label-primary">{{ $orderStatusQueue  }}</span>

                        </a>
                    @endcan
                    </li>
                        @can('list-pinq')
                    <li <?= strpos(Request::url(),'admin/pinquiries') !== false ? ' class="active"' : '' ?>>
                        <a href="/admin/pinquiries">


                            استعلام قیمت
                            <span class="label label-success">{{ $pinquiryStatusQueue  }}</span>
                        </a>


                    </li>
                        @endcan
                </ul>
            </li>

            <li <?= strpos(Request::url(),'sheet') !== false ? ' class="active"' : '' ?> <?= strpos(Request::url(),'sheet-move') !== false ? ' class="active"' : '' ?>>
                @can('list-sheet')
                <a href="#">
                    <i class="fa fa-th">
                    </i>
                    <span class="nav-label">شیت ها</span>
                    <span class="fa arrow">
                                </span>
                </a>
                @endcan
                <ul class="nav nav-second-level collapse">
                    @can('list-sheet')
                    <li <?= strpos(Request::url(),'sheets') !== false ? ' class="active"' : '' ?>>
                        <a href="/admin/sheets">
                           مدیریت شیت ها</a>

                    </li>
                    @endcan
                        @can('move-sheets')
                    <li <?= strpos(Request::url(),'sheet-move') !== false ? ' class="active"' : '' ?>>
                        <a href="/admin/sheet-move">
                           جابجایی بین شیت ها</a>
                    </li>

                        @endcan

                </ul>
            </li>

            <li <?= strpos(Request::url(),'admin/transaction') !== false ? ' class="active"' : '' ?><?= strpos(Request::url(),'transactions-cheques') !== false ? ' class="active"' : '' ?><?= strpos(Request::url(),'transaction-recieve-pay') !== false ? ' class="active"' : '' ?>>
                @can('list-transaction')
                <a href="#">
                    <i class="fa fa-dollar">
                    </i>
                    <span class="nav-label">امور مالی</span>
                    <span class="fa arrow">
                                </span>
                </a>
                @endcan
                <ul class="nav nav-second-level collapse">

                    @can('list-transaction')
                    <li <?= strpos(Request::url(),'admin/transactions') !== false ? ' class="active"' : '' ?>>
                        <a href="/admin/transactions">تراکنش های مالی</a>

                    </li>
                    @endcan
                    @can('list-cheque')
                    <li <?= strpos(Request::url(),'transaction-cheques') !== false ? ' class="active"' : '' ?>>
                        <a href="/admin/transaction-cheques">چک ها / فیش ها</a>

                    </li>
                        @endcan
                        @can('recieve-pay')
                    <li <?= strpos(Request::url(),'transaction-recieve-pay') !== false ? ' class="active"' : '' ?>>
                        <a href="/admin/transaction-recieve-pay">افزودن دریافتی پرداختی</a>

                    </li>

                        @endcan
                </ul>
            </li>
            @can('list-shipping')
            <li <?= strpos(Request::url(),'shippings') !== false ? ' class="active"' : '' ?>>
                <a href="/admin/shippings">
                    <i class="fa fa-truck">
                    </i>
                    <span class="nav-label"> درخواست ارسال کار
                    <span class="label label-primary">{{ $shippingStatusQueue  }}</span>
                    </span>
                </a>
            </li>
            @endcan
            @can('list-notif')
                <li <?= strpos(Request::url(),'notifs') !== false ? ' class="active"' : '' ?>>
                    <a href="/admin/notifs">
                        <i class="fa fa-bullhorn">
                        </i>
                        <span class="nav-label">اطلاعیه ها</span>
                    </a>
                </li>
            @endcan
            @can('list-discount')
            <li <?= strpos(Request::url(),'admin/discounts') !== false ? ' class="active"' : '' ?>>
                <a href="/admin/discounts">
                    <i class="fa fa-tag">
                    </i>
                    <span class="nav-label">تخفیف ها</span>
                </a>
            </li>
            @endcan

            @can('setting-site')
                <li <?= strpos(Request::url(),'admin/setting') !== false ? ' class="active"' : '' ?>>
                    <a href="/admin/settings">
                        <i class="fa fa-cog">
                        </i>
                        <span class="nav-label"> تنظیمات</span>
                    </a>
                </li>
            @endcan
            @can('logs')
                <li <?= strpos(Request::url(),'admin/userlog') !== false ? ' class="active"' : '' ?>>
                    <a href="/admin/userlog">
                        <i class="fa fa-file-text-o">
                        </i>
                        <span class="nav-label"> لاگ ادمین ها</span>
                    </a>
                </li>
            @endcan
            <li>
                <a href="/logout">
                    <i class="fa fa-sign-out">
                    </i>
                    <span class="nav-label">خروج</span>
                </a>
            </li>

        </ul>
    </div>
</nav>
