@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans("label.survey_{$category_company}") }}"> {{ trans("label.survey_{$category_company}") }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_leaflet('css') !!}
@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3 justify-content-center">
            <div class="col-md-10 col-sm-12 col-xs-12">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                @if ( hasRoute("{$bkpmumkm_identifier}.backend.survey.input_survey") && hasRoutePermission("{$bkpmumkm_identifier}.backend.survey.input_survey") && $survey->survey_result && !in_array($survey->status, ['verified', 'done', 'bersedia', 'menolak', 'tutup', 'pindah'])  && !$survey->trashed() && auth()->user()->group_id == GROUP_SURVEYOR )
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route("{$bkpmumkm_identifier}.backend.survey.input_survey", ['company' => $category_company, 'survey'=>encrypt_decrypt($survey->id)]) }}" title="{{ trans("label.survey_edit_survey") }}"><i class="fas fa-poll"></i> {{ trans('label.survey_edit_survey') }}</a>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">FORMULIR SURVEI KELOMPOK USAHA BESAR (UB)</h3>
                    </div>
                </div>

                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_profil_usaha")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_kebutuhan_kemitraan")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_kemitraan_sedang_berjalan")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_standar_kriteria_persyaratan")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_responden")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.note_revision")

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status_survey">Status</label>
                                    <br/>
                                    {{ trans("label.survey_status_{$survey->status}") }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                        @if ( hasRoute("{$bkpmumkm_identifier}.backend.survey.input_survey") && hasRoutePermission("{$bkpmumkm_identifier}.backend.survey.input_survey") && $survey->survey_result && !in_array($survey->status, ['verified', 'done', 'bersedia', 'menolak', 'tutup', 'pindah']) && !$survey->trashed()  && auth()->user()->group_id == GROUP_SURVEYOR)
                            <a class="btn btn-sm btn-primary" href="{{ route("{$bkpmumkm_identifier}.backend.survey.input_survey", ['company' => $category_company, 'survey'=>encrypt_decrypt($survey->id)]) }}" title="{{ trans("label.survey_edit_survey") }}"><i class="fas fa-poll"></i> {{ trans('label.survey_edit_survey') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js_stack')
    {!! library_leaflet('js', true) !!}
    <script>
        $(document).ready(function(){
            $(document).on('click', 'input[type="radio"], input[type="checkbox"]', function(e){
                e.preventDefault();
                return false;
            });
        });
    </script>
@endpush
