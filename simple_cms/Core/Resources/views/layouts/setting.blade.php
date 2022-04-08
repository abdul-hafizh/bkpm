@extends('core::layouts.backend')
@section('title')
    @yield('title')
@endsection
@section('breadcrumb')
    @yield('breadcrumb')
@endsection
@push('css_stack')
    {!! module_style('core', 'plugins/colorbox/colorbox.css') !!}
    {!! library_codemirror('css') !!}
@endpush
@section('layout')
    @yield('layout')
@endsection
@push('js_stack')
    {!! module_script('core', 'plugins/colorbox/jquery.colorbox-min.js') !!}
    {!! filemanager_standalonepopup() !!}
    {!! library_codemirror('js') !!}
    {!! module_script('core','setting/js/event.js') !!}
    {!! module_script('core','setting/js/index.js') !!}
@endpush
