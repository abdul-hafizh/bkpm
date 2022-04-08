@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans("label.survey_{$category_company}") }}"> {{ trans("label.survey_{$category_company}") }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')

@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3 justify-content-center">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
            </div>
        </div>

        <form id="formUploadBeritaAcara" class="row justify-content-center" data-action="{{ route("{$bkpmumkm_identifier}.backend.survey.berita_acara.save", ['company' => $category_company, 'survey' => encrypt_decrypt($survey->id)]) }}">
            <input type="hidden" name="id" value="{{ encrypt_decrypt($survey->id) }}" />
            <div class="col-md-4 col-sm-6 col-xs-12">
                @include("{$bkpmumkm_identifier}::survey.backend.berita_acara_{$category_company}")
            </div>
        </form>

    </div>
@endsection

@push('js_stack')
    {!! module_script('core', 'plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}
    {!! plugins_script('bkpmumkm', 'survey/backend/js/berita-acara.js') !!}
@endpush
