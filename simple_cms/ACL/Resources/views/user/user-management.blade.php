@extends('core::layouts.backend')

@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header bg-primary">
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="{{ auth()->user()->getAvatar() }}" alt="{{ auth()->user()->name }}">
                        </div>
                        <h3 class="widget-user-username text-bold">{{ auth()->user()->name }}</h3>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            @if(hasRoute('simple_cms.acl.backend.user.profile'))
                                <li class="nav-item">
                                    <a href="{{ route('simple_cms.acl.backend.user.profile') }}" title="Profile" class="nav-link" {!! ActiveRoute('simple_cms.acl.backend.user.profile','style="background: #dee2e6;"') !!}>
                                        Profile {!! ActiveRoute(['simple_cms.acl.backend.user.profile'], '<span class="float-right badge bg-success"><i class="fas fa-thumbtack"></i></span>') !!}
                                    </a>
                                </li>
                            @endif
                            @if(hasRoute('simple_cms.acl.backend.user.password'))
                                <li class="nav-item">
                                    <a href="{{ route('simple_cms.acl.backend.user.password') }}" title="Password" class="nav-link" {!! ActiveRoute('simple_cms.acl.backend.user.password','style="background: #dee2e6;"') !!}>
                                        Password {!! ActiveRoute(['simple_cms.acl.backend.user.password'], '<span class="float-right badge bg-success"><i class="fas fa-thumbtack"></i></span>') !!}
                                    </a>
                                </li>
                            @endif
                            @if( hasRoute('simple_cms.activitylog.backend.index') )
                                <li class="nav-item">
                                    <a href="{{ route('simple_cms.activitylog.backend.index') }}" title="Activity Log" class="nav-link"  {!! ActiveRoute('simple_cms.activitylog.backend.index','style="background: #dee2e6;"') !!}>
                                        Activity {!! ActiveRoute(['simple_cms.activitylog.backend.index'], '<span class="float-right badge bg-success"><i class="fas fa-thumbtack"></i></span>') !!}
                                    </a>
                                </li>
                            @endif
                            {{--@if(Route::has('simple_cms.acl.backend.user.setting'))
                                <li class="nav-item">
                                    <a href="{{ route('simple_cms.acl.backend.user.setting') }}" class="nav-link">
                                        Setting {!! ActiveRoute(['simple_cms.acl.backend.user.setting'], '<span class="float-right badge bg-success"><i class="fas fa-thumbtack"></i></span>') !!}
                                    </a>
                                </li>
                            @endif--}}
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        @yield('partial')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection