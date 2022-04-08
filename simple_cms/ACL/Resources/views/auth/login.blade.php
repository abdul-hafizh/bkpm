@extends('core::layouts.auth')
@section('title', trans('core::label.title_login_form'))
@section('layouts')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ trans('core::label.title_login_form') }}</p>

            <form id="loginForm" data-action="{{ route('simple_cms.acl.auth.loginPost') }}" data-method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username or Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text pointer-cursor showHidePassword" title="Click show/hide password">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                {!! simple_cms_acl_form_login_hook_action() !!}

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in"></i> {{ trans('core::label.login') }}</button>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center mb-3">
                <hr/>
                {!! simple_cms_acl_form_login_after_hook_action() !!}
            </div>

            @if(Route::has('simple_cms.acl.auth.password.request'))
                <p class="mb-1">
                    <a href="{{ route('simple_cms.acl.auth.password.request') }}">{{ trans('core::label.forgot_your_password') }}</a>
                </p>
            @endif
            @if(Route::has('simple_cms.acl.auth.register') && can_register())
                <p class="mb-0">
                    <a href="{{ route('simple_cms.acl.auth.register') }}" class="text-center">{{ trans('core::label.register_a_new_account') }}</a>
                </p>
            @endif

            <div class="row">
                <div class="col-12 text-center">
                    <hr/>
                    <a href="javascript:void(0);"><strong>{{ $currentLanguage->name }}</strong></a>&nbsp;|&nbsp;
                    @foreach ($altLocalizedUrls as $key => $alt)
                        <a href="{{ $alt['url'] }}" hreflang="{{ $alt['locale'] }}">{{ $alt['name'] }}</a>{{ ( ($key+1) < count($altLocalizedUrls) ? ' |':'') }}
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    {!! module_script('acl','auth/js/event.js') !!}
    {!! module_script('acl','auth/js/login.js') !!}
@endsection
