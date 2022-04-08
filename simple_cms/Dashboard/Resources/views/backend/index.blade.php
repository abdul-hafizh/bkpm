@extends('core::layouts.backend')
@section('title', 'Dashboard')
@push('css_stack')
    {!! library_highcharts('css') !!}
    {!! library_highcharts('js') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        @if (function_exists('simple_cms_dashboard_backend_hook'))
            {!! simple_cms_dashboard_backend_hook() !!}
        @endif
    </div>
@endsection
