<ul id="menu" class="page-sidebar-menu">

    {{--<li class="menu_more">--}}
        {{--<a href="#">--}}
            {{--<i class="livicon" data-name="wrench" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"--}}
               {{--data-loop="true"></i>--}}
            {{--<span class="title">Manager</span>--}}
            {{--<span class="fa arrow"></span>--}}
        {{--</a>--}}
        {{--<ul class="sub-menu">--}}
            {{--@if ($USER_LOGGED->canAccess('adtech.core.role.manage'))--}}
            {{--<li {!! (Request::is('admin/adtech/core/role/*') ? 'class="active"' : '') !!}>--}}
                {{--<a href="{{ route('adtech.core.role.manage') }}">--}}
                    {{--<i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"--}}
                       {{--data-loop="true"></i>--}}
                    {{--<span class="title">Role</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
            {{--@if ($USER_LOGGED->canAccess('adtech.core.user.manage'))--}}
            {{--<li {!! (Request::is('admin/adtech/core/user/*') ? 'class="active"' : '') !!}>--}}
                {{--<a href="{{ route('adtech.core.user.manage') }}">--}}
                    {{--<i class="livicon" data-name="user" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"--}}
                       {{--data-loop="true"></i>--}}
                    {{--<span class="title">User</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
            {{--@if ($USER_LOGGED->canAccess('adtech.core.route.list'))--}}
            {{--<li {!! (Request::is('admin/adtech/core/route/list') ? 'class="active"' : '') !!}>--}}
                {{--<a href="{{ route('adtech.core.route.list') }}">--}}
                    {{--<i class="livicon" data-name="move" data-size="18" data-c="#ef6f6c" data-hc="#ef6f6c"--}}
                       {{--data-loop="true"></i>--}}
                    {{--<span class="title">Route</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
            {{--@if ($USER_LOGGED->canAccess('adtech.core.domain.manage'))--}}
            {{--<li {!! (Request::is('admin/adtech/core/domain/*') ? 'class="active"' : '') !!}>--}}
                {{--<a href="{{ route('adtech.core.domain.manage') }}">--}}
                    {{--<i class="livicon" data-name="globe" data-size="18" data-c="#418BCA" data-hc="#418BCA"--}}
                       {{--data-loop="true"></i>--}}
                    {{--<span class="title">Domain</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
            {{--@if ($USER_LOGGED->canAccess('adtech.core.package.manage'))--}}
            {{--<li {!! (Request::is('admin/adtech/core/package/*') ? 'class="active"' : '') !!}>--}}
                {{--<a href="{{ route('adtech.core.package.manage') }}">--}}
                    {{--<i class="livicon" data-name="piechart" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"--}}
                       {{--data-loop="true"></i>--}}
                    {{--<span class="title">Package</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
            {{--@if ($USER_LOGGED->canAccess('adtech.core.menu.manage'))--}}
            {{--<li {!! (Request::is('admin/adtech/core/menu/*') ? 'class="active"' : '') !!}>--}}
                {{--<a href="{{ route('adtech.core.menu.manage') }}">--}}
                    {{--<i class="livicon" data-name="responsive-menu" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"--}}
                       {{--data-loop="true"></i>--}}
                    {{--<span class="title">Menu</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
            {{--@if ($USER_LOGGED->canAccess('adtech.core.file.manage'))--}}
            {{--<li {!! (Request::is('admin/adtech/core/file/*') ? 'class="active"' : '') !!}>--}}
                {{--<a href="{{ route('adtech.core.file.manage') }}">--}}
                    {{--<i class="livicon" data-name="folder-flag" data-size="18" data-c="#f99928" data-hc="#f99928"--}}
                       {{--data-loop="true"></i>--}}
                    {{--<span class="title">File manager</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
        {{--</ul>--}}
    {{--</li>--}}
    <!-- Menus generated by CRUD generator -->

    @include('includes.frontend.menu')
</ul>
