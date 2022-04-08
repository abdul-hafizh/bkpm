@if (Route::has('simple_cms.acl.auth.login'))
    <div class="top-right links">
        @auth
            <a href="{{ link_dashboard() }}">Dashboard</a>
            <a id="linkLogOut" href="{{ route('simple_cms.acl.auth.logout') }}">Logout</a>
        @else
            <a href="{{ route('simple_cms.acl.auth.login') }}">Login</a>

            @if (Route::has('simple_cms.acl.auth.register'))
                <a href="{{ route('simple_cms.acl.auth.register') }}">Register</a>
            @endif
        @endauth
    </div>
@endif
