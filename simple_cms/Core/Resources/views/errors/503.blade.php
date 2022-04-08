@extends('core::layouts.error')
@section('title',__('core::message.error.'.$code))

@section('layouts')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ $code }}</p>
            <div class="alert alert-warning">
                <h5><i class="icon fas fa-exclamation-triangle"></i> {{ $code }}</h5>
                {!! (isset($message)&&!empty($message) ? $message : __('core::message.error.'.$code)) !!}
            </div>

            @if(env('APP_DEBUG'))
                <div class="text-left" style="height: 270px; overflow-y: auto;">
                    {{ dump($exceptions) }}
                </div>
            @endif

            <div class="social-auth-links text-center mb-3">
                <hr/>
                <a href="{{ URL::previous() }}" class="btn btn-success btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                @if ( auth()->check() )
                    <a href="{{ link_dashboard() }}" class="btn btn-primary btn-sm"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                @else
                    <a href="{{ (hasRoute('simple_cms.acl.auth.login') ? route('simple_cms.acl.auth.login') : url('/')) }}" class="btn btn-primary btn-sm"><i class="fas fa-sign-in-alt"></i> Login</a>
                @endif
            </div>
            <div class="text-center">
                <div class="m-b-20">
                    © {{ date('Y') }} {{ get_app_name() }}. All rights reserved.
                </div>
            </div>
        </div>
    </div>
@endsection
