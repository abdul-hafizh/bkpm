<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title') | {{ site_name() }}</title>

    <link rel="icon" href="{{ get_favicon() }}">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="_level" content=""/>
    <meta name="_url" content="{{ url('') }}"/>
    <meta name="description" content="@lang('core::app.name')">
    <meta name="author" content="@lang('core::app.name')">
    <meta name="keyword" content="@lang('core::app.name')">
    <style> th { text-align: center !important; vertical-align: middle !important; } </style>
    @include('core::partials.backend.asset_css')
    @hasSection('css')
        @yield('css')
    @endif
    @stack('css_stack')

    {!! simple_cms_setting('backend_style') !!}
    @coreStyles()
    @coreScriptsTop()

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed @stack('body_class')">
    <div class="wrapper">

        @include('core::partials.backend.header_backend')
        @include('core::partials.backend.sidebar_backend')

        {{--Content Wrapper. Contains page content--}}
        <div class="content-wrapper">

            {{--Content Header (Page header)--}}
            @hasSection('breadcrumb')
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">@yield('title')</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('simple_cms.dashboard.backend.index') }}" title="Dashboard"><i class="fas fa-home"></i> </a></li>
                                    @yield('breadcrumb')
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <h1 class="m-0 text-dark">@yield('title')</h1>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{--/.content-header--}}

            {{--Main content--}}
            <section class="content">
                @yield('layout')
            </section>
            {{--/.content--}}
        </div>
        {{--/.content-wrapper--}}

        {{--Control Sidebar--}}
        <aside class="control-sidebar control-sidebar-dark">
            {{--Control sidebar content goes here--}}
        </aside>
        {{--/.control-sidebar--}}

        @include('core::partials.backend.footer_backend')

    </div>

    @include('core::partials.backend.modal')
    @include('core::partials.backend.asset_js')
    @hasSection('js')
        @yield('js')
    @endif
    @stack('js_stack')
    {!! simple_cms_setting('backend_script') !!}
    @coreScripts()
    
</body>
</html>
