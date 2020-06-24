<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                <i class="fa fa-bars">
                </i>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-left">
            <li>
            <span class="m-l-sm text-muted welcome-message" style="color:#a7b1c2; font-size: 12px; font-weight: bold">
           امروز:
             <?php
                 $v = new Verta();
                 echo $v->format('l, d F Y');
             ?>
                  -  <span style="font-family: tahoma;">
             <?php
                 echo $v->DateTime()->format('l,  F d , Y');
             ?>
                        </span>
            </span>
            </li>
            {{--<li class="dropdown">--}}
                {{--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">--}}
                    {{--<i class="fa fa-question-circle">--}}
                    {{--</i>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li>
                <a href="/logout">
                    <i class="fa fa-sign-out">
                    </i>
                    خروج
                </a>
            </li>
        </ul>
    </nav>
</div>
