{{--Main Sidebar Container--}}
{{-- color-sidebar: sidebar-dark-blue; sidebar-light-primary; --}}
<aside class="main-sidebar {{ env('COLOR_SIDEBAR', 'sidebar-light-primary') }} elevation-4">
    {{--Brand Logo--}}
    <a href="{{ link_dashboard() }}" class="brand-link">
        <img src="{{ get_logo() }}" class="brand-image">
    </a>

    {{--Sidebar--}}
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        {{--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->getAvatar() }}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}">
            </div>
            <div class="info">
                <a href="{{ route('simple_cms.acl.backend.user.profile') }}" class="d-block" title="My Profile">{{ auth()->user()->name }}</a>
            </div>
        </div>--}}

        {{--Sidebar Menu--}}
        <nav class="mt-2">
            {!! \Menu::render(MENU_ADMINLTE3, MENU_BACKEND_PRESENTER) !!}
            {{--
            <ul id="backend-sidebar" class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview" role="menu" data-accordion="false">

                @if(hasRoutePermission([
                    'simple_cms.acl.backend.user.index',
                    'simple_cms.acl.backend.user.profile',
                    'simple_cms.acl.backend.role.index'
                ]))
                    <li class="nav-item has-treeview {{ ActiveRoute(['simple_cms.acl.backend.user.index','simple_cms.acl.backend.user.add','simple_cms.acl.backend.user.edit', 'simple_cms.acl.backend.user.profile', 'simple_cms.acl.backend.user.password', 'simple_cms.acl.backend.role.index','simple_cms.acl.backend.role.add','simple_cms.acl.backend.role.edit'], 'menu-open') }}">
                        <a href="#" class="nav-link {{ ActiveRoute(['simple_cms.acl.backend.user.index','simple_cms.acl.backend.user.add','simple_cms.acl.backend.user.edit', 'simple_cms.acl.backend.user.profile', 'simple_cms.acl.backend.user.password', 'simple_cms.acl.backend.role.index','simple_cms.acl.backend.role.add','simple_cms.acl.backend.role.edit']) }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Settings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ( hasRoute('simple_cms.acl.backend.user.profile') && hasRoutePermission('simple_cms.acl.backend.user.profile'))
                                <li class="nav-item">
                                    <a href="{{ route('simple_cms.acl.backend.user.profile') }}" class="nav-link {{ ActiveRoute(['simple_cms.acl.backend.user.profile', 'simple_cms.acl.backend.user.password']) }}">
                                        <i class="fas fa-user nav-icon"></i>
                                        <p>My Profile</p>
                                    </a>
                                </li>
                            @endif

                            @if ( hasRoute('simple_cms.acl.backend.user.index') && hasRoutePermission('simple_cms.acl.backend.user.index'))
                                <li class="nav-item">
                                    <a href="{{ route('simple_cms.acl.backend.user.index') }}" class="nav-link {{ ActiveRoute(['simple_cms.acl.backend.user.index','simple_cms.acl.backend.user.add','simple_cms.acl.backend.user.edit']) }}">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                            @endif
                            @if ( hasRoute('simple_cms.acl.backend.group.index') && hasRoutePermission('simple_cms.acl.backend.group.index'))
                                <li class="nav-item">
                                    <a href="{{ route('simple_cms.acl.backend.group.index') }}" class="nav-link {{ ActiveRoute(['simple_cms.acl.backend.group.index','simple_cms.acl.backend.group.add','simple_cms.acl.backend.group.edit']) }}">
                                        <i class="fas fa-universal nav-icon"></i>
                                        <p>Groups</p>
                                    </a>
                                </li>
                            @endif
                            @if ( hasRoute('simple_cms.acl.backend.role.index') && hasRoutePermission('simple_cms.acl.backend.role.index'))
                                <li class="nav-item">
                                    <a href="{{ route('simple_cms.acl.backend.role.index') }}" class="nav-link {{ ActiveRoute(['simple_cms.acl.backend.role.index','simple_cms.acl.backend.role.add','simple_cms.acl.backend.role.edit']) }}">
                                        <i class="fas fa-universal-access nav-icon"></i>
                                        <p>Roles & Permissions</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

            </ul>
            --}}
        </nav>
        {{--/.sidebar-menu--}}
    </div>
    {{--/.sidebar--}}
</aside>
