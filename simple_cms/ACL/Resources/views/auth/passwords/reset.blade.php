@extends('core::layouts.auth')
@section('title', trans('core::label.reset_password'))
@section('layouts')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ trans('core::label.reset_password') }}</p>

            <form id="passwordResetForm" data-action="{{ route('simple_cms.acl.auth.password.update') }}" data-method="POST">

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ $email }}" readonly>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text pointer-cursor showHidePassword" title="Click show/hide password">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-unlock"></span>
                        </div>
                    </div>
                </div>

                {!! simple_cms_acl_form_reset_password_hook_action() !!}

                <div class="row">
                    <div class="col-4">

                    </div>
                    <div class="col-8">
                        <button type="submit" class="btn btn-primary btn-block"> {{ trans('core::label.reset_password') }}</button>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center mb-3">
                <hr/>
            </div>

            @if(Route::has('simple_cms.acl.auth.login'))
                <p class="mb-0">
                    <a href="{{ route('simple_cms.acl.auth.login') }}" class="text-center"> {{ trans('core::label.already_have_a_account') }}</a>
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
    {!! module_script('acl','auth/js/password-reset.js') !!}
@endsection
