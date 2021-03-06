<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">


        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse">
        </a>

        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">

                <li class="dropdown dropdown-user">

                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
                        <img alt="" class="img-circle" src="{{Auth::user()->avatar}}"/>
                        <span class="username username-hide-on-mobile">{{Auth::user()->name}} </span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="/admin/users/edit/{{Auth::user()->id}}">
                                <i class="icon-user"></i> {{trans('messages.my_profile')}} </a>
                        </li>
                        <li>
                            <a href="/logout">
                                <i class="icon-key"></i> {{trans('messages.logout')}} </a>
                        </li>
                    </ul>

                </li>

                <li class="dropdown dropdown-quick-sidebar-toggler">
                    <a href="/logout" class="dropdown-toggle">
                        <i class="icon-logout"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>