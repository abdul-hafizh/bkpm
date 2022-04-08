@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.umkm.survey_massive.index") }}" title="{{ trans('label.umkm_observasi_massive') }}"> {{ trans('label.umkm_observasi_massive') }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')

@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.survey_massive.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
            </div>
        </div>

        {!! $template !!}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-footer text-right">
                        <a class="btn btn-default btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.survey_massive.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                        @if (hasRoutePermission("{$bkpmumkm_identifier}.backend.umkm.survey_massive.edit"))
                            <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.survey_massive.edit", ['id' => encrypt_decrypt($umkm->id)]) }}" title="{{ trans('label.edit_survey_umkm_observasi_massive') }}"><i class="fas fa-edit"></i> {{ trans('label.edit_survey_umkm_observasi_massive') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_stack')

@endpush
