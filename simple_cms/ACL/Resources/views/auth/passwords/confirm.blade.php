@extends('core::layouts.auth')
@section('title', trans('core::label.confirm_password'))
@section('layouts')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ trans('core::label.confirm_password') }}</p>

            <form action="{{ route('simple_cms.acl.auth.password.confirm') }}" method="POST">

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text pointer-cursor showHidePassword" title="Click show/hide password">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                {!! simple_cms_acl_form_confirm_password_hook_action() !!}

                <div class="row">
                    <div class="col-8">

                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block"> {{ trans('core::label.confirm_password') }}</button>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center mb-3">
                <hr/>
            </div>

            @if(Route::has('simple_cms.acl.auth.password.request'))
                <p class="mb-0">
                    <a href="{{ route('simple_cms.acl.auth.password.request') }}" class="text-center"> {{ trans('core::label.forgot_your_password') }}</a>
                </p>
            @endif
        </div>

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
@endsection
@section('js')
    {!! module_script('acl','auth/js/login.js') !!}
@endsection
