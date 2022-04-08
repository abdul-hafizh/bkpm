@extends('core::layouts.auth')
@section('title', trans('core::label.verify_your_email_address'))
@section('layouts')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ trans('core::label.verify_your_email_address') }}</p>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ trans('core::message.a_fresh_verification_link_has_been_sent_to_your_email_address') }}
                </div>
            @endif

            {{ trans('core::message.before_proceeding_please_check_your_email_for_a_verification_link_if_you_did_not_receive_the_email') }}
            <form action="{{ route('simple_cms.acl.auth.verification.resend') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in"></i> {{ trans('core::message.click_here_to_request_another_email_verification') }}</button>
                    </div>
                </div>
            </form>
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
    {!! module_script('acl','auth/js/login.js') !!}
@endsection
