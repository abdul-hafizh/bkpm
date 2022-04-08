@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans("label.survey_{$category_company}") }}"> {{ trans("label.survey_{$category_company}") }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    <style>
        .signatureAbsent canvas {
            border: 1px solid #b8b5b5;
        }
    </style>
@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3 justify-content-center">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
            </div>
        </div>

        <form id="formInputSurvey" class="row justify-content-center" data-action="{{ route("{$bkpmumkm_identifier}.backend.survey.input_survey.save", ['company' => $category_company, 'survey' => encrypt_decrypt($survey->id), 'sign' => 'signature']) }}">
            <input type="hidden" name="id" value="{{ encrypt_decrypt($survey->survey_result->id) }}" />
            <input type="hidden" name="survey_id" value="{{ encrypt_decrypt($survey->id) }}" />
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ trans('label.signature_below') }}</label>
                            <div class="signatureAbsent"></div>
                            <button type="button" class="btn btn-xs btn-info signature_clear"><i class="fas fa-refresh"></i> {{ trans('label.repeat') }}</button>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-sm" title="{{ trans('label.save') }}"><i class="fa fa-save"></i> {{ trans('label.save') }}</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@push('js_stack')
    {!! module_script('core', 'js/modernizr.min.js') !!}
    {!! module_script('core', 'plugins/signature/js/signature.js') !!}
    {!! plugins_script('bkpmumkm', 'survey/backend/js/signature.js') !!}
@endpush
