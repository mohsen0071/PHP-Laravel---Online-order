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
                                    </span>
                                    <span class="text-muted text-xs block">
                                                     <b class="caret">
                                                        </b>
                                        {{ auth()->user()->user_type == 1 ? 'کاربر عادی' : 'کاربر همکار' }}

                                    </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft m-t-xs">
                        <li>
                            <a href="/user/edit">
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
            <li class="{{ Route::currentRouteName() == 'user.panel' ? 'active' : '' }}">
                <a href="/user/panel">
                    <i class="fa fa-th-large">
                    </i>
                    <span class="nav-label">پیشخوان</span>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'user.newOrder' ? 'active' : '' }}">
                <a href="/user/new-order">
                    <i class="fa fa-external-link">
                    </i>
                    <span class="nav-label">سفارش جدید</span>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'user.allOrder' ? 'active' : '' }}">
                <a href="/user/all-order">
                    <i class="fa fa-files-o">
                    </i>
                    <span class="nav-label">همه سفارش ها</span>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'user.transactions' ? 'active' : '' }}{{ Route::currentRouteName() == 'user.increaseBalance' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-dollar">
                    </i>
                    <span class="nav-label">امور مالی</span>
                    <span class="fa arrow">
                                </span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Route::currentRouteName() == 'user.transactions' ? 'active' : '' }}">
                        <a href="/user/transactions">

                           گردش حساب</a>
                    </li>
                    <li {{ Route::currentRouteName() == 'user.increaseBalance' ? 'active' : '' }}>
                        <a href="/user/increase-balance">
                            افزایش موجودی</a>
                    </li>

                </ul>
            </li>

            <li class="{{ Route::currentRouteName() == 'user.pinquiries' ? 'active' : '' }}">
                <a href="/user/pinquiries">
                    <i class="fa fa-life-ring">
                    </i>
                    <span class="nav-label">استعلام قیمت</span>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'user.price-list' ? 'active' : '' }}">
                <a href="/user/price-list">
                    <i class="fa fa-list">
                    </i>
                    <span class="nav-label">  لیست قیمت</span>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'user.allShip' ? 'active' : '' }}">
                <a href="/user/all-ship">
                    <i class="fa fa-truck">
                    </i>
                    <span class="nav-label">درخواست ارسال کار

                    </span>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'user.the-rules' ? 'active' : '' }}">
                <a href="/user/the-rules">
                    <i class="fa fa-gavel">
                    </i>
                    <span class="nav-label">  قوانین و مقررات</span>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'user.edit' ? 'active' : '' }}">
                <a href="/user/edit">
                    <i class="fa fa-user">
                    </i>
                    <span class="nav-label">ویرایش پروفایل
                        @if(!$checkProfile)
                            <i class="fa fa-warning text-danger animate-flicker"></i>
                        @endif
                    </span>
                </a>
            </li>

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
