<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ site_name() }}</title>
    {{-- Tell the browser to be responsive to screen width --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ get_favicon() }}">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="_level" content=""/>
    <meta name="_url" content="{{ url('') }}"/>

    {{-- Font Awesome --}}
    {!! library_icons('css', 0, 'font-awesome') !!}
    {{-- Ionicons --}}
    {!! library_icons('css', 0, 'ionicons', '4.6.4-1') !!}
    {{-- icheck bootstrap --}}
    {!! module_style('core','plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}
    {{-- Theme style --}}
    {!! module_style('core','css/adminlte.min.css') !!}
    {!! module_style('core','plugins/sweetalert2/css/sweetalert2.min.css') !!}
    {!! module_style('core','plugins/jquery-ui/jquery-ui.min.css') !!}

    {!! module_style('core','css/global.css') !!}
    {{-- Google Font: Source Sans Pro --}}
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    {!! module_script('core','plugins/jquery/jquery.min.js') !!}
    {!! module_script('core','plugins/jquery-ui/jquery-ui.min.js') !!}
    {{-- Bootstrap 4 --}}
    {!! library_bootstrap('js') !!}
    {!! module_script('core','plugins/sweetalert2/js/sweetalert2.all.min.js') !!}
    {!! module_script('core','js/simple-cms.js') !!}
    {!! module_script('core','js/global.js') !!}
    @hasSection('css')
        @yield('css')
    @endif
    @stack('css_stack')
    @coreStyles()
    @coreScriptsTop()
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"><img src="{{ get_logo() }}" style="width: 200px" alt="{{ get_app_name() }}"></a>
    </div>
    @yield('layouts')
</div>

{{-- AdminLTE App --}}
{!! module_script('core','js/adminlte.min.js') !!}

{!! module_script('core', 'plugins/jquery-validation/jquery.validate.min.js') !!}
{!! module_script('core', 'plugins/jquery-validation/additional-methods.min.js') !!}

@hasSection('js')
    @yield('js')
@endif
@stack('js_stack')
@coreScripts()
</body>
</html>
