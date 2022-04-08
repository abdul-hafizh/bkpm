@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {{-- elFinder CSS (REQUIRED) --}}
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/theme.css') }}">

    {{-- elFinder JS (REQUIRED) --}}
    <script src="{{ asset($dir.'/js/elfinder.min.js') }}"></script>

    @if($locale)
        {{-- elFinder translation (OPTIONAL) --}}
        <script src="{{ asset($dir."/js/i18n/elfinder.$locale.js") }}"></script>
    @endif
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div id="elfinder" class="col-md-12">

            </div>

        </div>
    </div>
@endsection
@push('js_stack')
    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $().ready(function() {
            $('#elfinder').elfinder({
                // set your elFinder options here
                @if($locale)
                lang: '{{ $locale }}', // locale
                @endif
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url : '{{ $url_connector }}',  // connector URL
                soundPath: '{{ asset($dir.'/sounds') }}',
                height: '100%'
            });
        });
    </script>
@endpush
