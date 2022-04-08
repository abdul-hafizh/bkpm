<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container-fluid">
        <a href="{{ link_dashboard() }}" class="navbar-brand">
            <img src="{{ get_logo() }}" class="brand-image">
        </a>
        
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            {!! \Menu::render(MENU_ADMINLTE3, MENU_BACKEND_PRESENTER) !!}
            

            {{--  SEARCH FORM 
            <form class="form-inline ml-0 ml-md-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                </div>
            </div>
            </form>
            --}}
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="javascript:void(0);">
                    <i class="fas fa-globe"></i>
                    {{ $currentLanguage->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right pt-0 pb-0">
                    @foreach ($altLocalizedUrls as $alt)
                        <a href="{{ $alt['url'] }}" hreflang="{{ $alt['locale'] }}" class="dropdown-item">{{ $alt['name'] }}</a>
                    @endforeach
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="javascript:void(0);">
                    <img src="{{ auth()->user()->getAvatar() }}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}" style="width: 35px; margin-top: -8px;">
                </a>
                <div class="dropdown-menu dropdown-menu-right pt-0 pb-0">
                    <span class="dropdown-item dropdown-header">{{ auth()->user()->name }}</span>
                    <div class="dropdown-divider mb-0 mt-0"></div>
                    <a href="{{ url('/') }}" class="dropdown-item">
                        <i class="fas fa-globe mr-2"></i> Website
                    </a>
                    @if(Route::has('simple_cms.acl.backend.user.profile'))
                        <a href="{{ route('simple_cms.acl.backend.user.profile') }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                    @endif
                    <div class="dropdown-divider mb-0 mt-0"></div>
                    <a href="{{ route('simple_cms.acl.auth.logout') }}" class="linkLogOut dropdown-item dropdown-footer"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>



