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
                <a class="btn btn-warning btn-sm btnBack" href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10 col-sm-12 col-xs-12">
                @switch($category_company)
                    @case(CATEGORY_COMPANY)
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
                    {{--@include("{$bkpmumkm_identifier}::survey.backend.partials.note_revision")--}}

                    @break
                    @case(CATEGORY_UMKM)
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">FORMULIR SURVEI KELOMPOK USAHA MENENGAH KECIL MIKRO (UMKM)</h3>
                                <h3 class="text-center">MENDORONG INVESTASI BESAR BERMITRA DENGAN UMKM TAHUN {{ ($survey ? \Carbon\Carbon::parse($survey->created_at)->format('Y') : \Carbon\Carbon::now()->format('Y')) }}</h3>
                            </div>
                        </div>

                    @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_profil_usaha")
                    @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_kemampuan_finansial")
                    @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_profil_produk_barang_jasa")
                    @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_profil_pengelolaan_usaha")
                    @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_pengalaman_ekspor")
                    @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_fasilitas_usaha")
                    @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_pengalaman_kerja_sama_kemitraan")
                    @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_hal_lain")
                    @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_responden")
                    @break
                @endswitch
                <div class="card">
                    <div class="card-body">

                    </div>
                    <div class="card-footer text-right">
                        <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                        @if (hasRoutePermission("{$bkpmumkm_identifier}.backend.survey.change_status_revision"))
                            <a class="btn btn-info btn-sm show_modal_bs" href="javascript:void(0);" data-action="{{ route("{$bkpmumkm_identifier}.backend.survey.change_status_revision", ['company' => $category_company, 'survey'=>encrypt_decrypt($survey->id), 'in_modal' => encrypt_decrypt('revision')]) }}" data-title="@lang("label.change_status_to_revision")"><i class="fas fa-refresh"></i> @lang("label.change_status_to_revision")</a>
                        @endif
                        @if( hasRoute("{$bkpmumkm_identifier}.backend.survey.verified_save") && hasRoutePermission("{$bkpmumkm_identifier}.backend.survey.verified_save") && (in_array($survey->status, ['done']) && ($survey->survey_result && (isset($survey->survey_result->documents['file']) && !empty($survey->survey_result->documents['file'])) && (isset($survey->survey_result->documents['photo']) && !empty($survey->survey_result->documents['photo'])) )) )

                            @if ( hasRoute("{$bkpmumkm_identifier}.backend.survey.input_survey") && hasRoutePermission("{$bkpmumkm_identifier}.backend.survey.input_survey") && $survey->survey_result && in_array($survey->status, ['done']) && $survey->surveyor_id == auth()->user()->id )
                                <a class="btn btn-sm btn-primary" href="{{ route("{$bkpmumkm_identifier}.backend.survey.input_survey", ['company' => $category_company, 'survey'=>encrypt_decrypt($survey->id)]) }}" title="{{ trans("label.survey_edit_survey") }}"><i class="fas fa-poll"></i> {{ trans('label.survey_edit_survey') }}</a>
                            @endif

                            <button class="btn btn-success btn-sm eventSurveyVerified" data-action="{{ route("{$bkpmumkm_identifier}.backend.survey.verified_save", ['company' => $category_company, 'survey'=>encrypt_decrypt($survey->id)]) }}" title="{{ trans("label.survey_verified_{$category_company}") }}" data-title="{{ trans("label.survey_verified_{$category_company}") }}"><i class="fas fa-check-double"></i> {{ trans("label.survey_verified_{$category_company}") }}</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js_stack')
    <script>
        const textConfirm = "{{ trans('message.survey_verified') }}";
    </script>
    {!! library_leaflet('js', true) !!}
    <script>
        $(document).ready(function(){
            $(document).on('click', 'input[type="radio"], input[type="checkbox"]', function(e){
                e.preventDefault();
                return false;
            });
        });
    </script>
    {!! plugins_script('bkpmumkm', 'survey/backend/js/verified.js') !!}
@endpush
