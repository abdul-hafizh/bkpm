@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_datatables('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_stack')
    <script>
        @php
            $periodes = [];
            foreach (list_years() as $y) {
                $periodes[] = $y;
            }
        @endphp
        const periodes = @json($periodes);
    </script>
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    {!! module_script('core','js/events.js') !!}
    {!! plugins_script('bkpmumkm', 'cross-matching/backend/js/index.js') !!}
@endpush
