<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>

    {{-- jQuery and jQuery UI (REQUIRED) --}}
{{--    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />--}}
    {!! module_style('core','plugins/jquery-ui/jquery-ui.min.css') !!}
{{--    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>--}}
{{--    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>--}}
    {!! module_script('core','plugins/jquery/jquery.min.js') !!}
    {!! module_script('core','plugins/jquery-ui/jquery-ui.min.js') !!}

    {{-- elFinder CSS (REQUIRED) --}}
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/theme.css') }}">

    {{-- elFinder JS (REQUIRED) --}}
    <script src="{{ asset($dir.'/js/elfinder.min.js') }}"></script>

    @if($locale)
        {{-- elFinder translation (OPTIONAL) --}}
        <script src="{{ asset($dir."/js/i18n/elfinder.$locale.js") }}"></script>
    @endif

    @yield('elfinder_script')

</head>
<body>

{{-- Element where elFinder will be created (REQUIRED) --}}
<div id="elfinder"></div>

</body>
</html>