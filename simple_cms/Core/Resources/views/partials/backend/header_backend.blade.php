<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    {{--Left navbar links--}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        {{--<li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>--}}
    </ul>

    {{--SEARCH FORM--}}
    {{--<form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>--}}

    <ul class="navbar-nav ml-auto">
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

</nav>
