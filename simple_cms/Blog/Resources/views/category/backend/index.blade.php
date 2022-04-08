@extends('core::layouts.backend')
@section('title','Categories')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Categories"> Categories</a></li>
@endsection
@push('css_stack')
    {!! library_datatables('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body pad">
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('js_stack')
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    {!! module_script('core','js/events.js') !!}
    {!! module_script('blog','category/backend/js/index.js') !!}
@endpush
