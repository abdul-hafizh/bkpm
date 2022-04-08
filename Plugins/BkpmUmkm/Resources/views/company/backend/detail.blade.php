@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.company.index") }}" title="{{ trans('label.index_company') }}"> {{ trans('label.index_company') }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_leaflet('css') !!}
@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <a id="btnKembali" class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.company.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
            </div>
        </div>

        {!! $template !!}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-footer text-right">
                        <a id="btnKembali" class="btn btn-default btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.company.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                        @if (hasRoutePermission("{$bkpmumkm_identifier}.backend.company.edit"))
                            <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.company.edit", ['id' => encrypt_decrypt($company->id)]) }}" title="{{ trans('label.edit_company') }}"><i class="fas fa-edit"></i> {{ trans('label.edit_company') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_stack')
    {!! library_leaflet('js', true) !!}
@endpush
