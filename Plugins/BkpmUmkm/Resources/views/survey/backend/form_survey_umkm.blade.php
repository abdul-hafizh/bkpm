@extends('core::layouts.backend')
@section('title', $title)
@push('body_class', 'sidebar-collapse')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans("label.survey_{$category_company}") }}"> {{ trans("label.survey_{$category_company}") }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {{--{!! module_style('core', 'plugins/dropzone/5.7.0/css/dropzone.min.css') !!}--}}
    {!! plugins_style('bkpmumkm', 'survey/backend/css/dropzone-style.css') !!}
    {!! library_select2('css') !!}
    {!! library_datepicker('css') !!}
    {!! library_leaflet('css') !!}
    {!! plugins_style('bkpmumkm', 'survey/backend/css/input-survey.css') !!}
@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3 justify-content-center">
            <div class="col-md-10 col-sm-12 col-xs-12">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
            </div>
        </div>

        <form id="formInputSurvey" class="row justify-content-center" data-action="{{ route("{$bkpmumkm_identifier}.backend.survey.input_survey.save", ['company' => $category_company, 'survey' => encrypt_decrypt($survey->id)]) }}">
            <input type="hidden" name="id" value="{{ encrypt_decrypt($survey->survey_result->id) }}" />
            <input type="hidden" name="survey_id" value="{{ encrypt_decrypt($survey->id) }}" />
            <input type="hidden" name="company_id" value="{{ encrypt_decrypt($survey->company_id) }}" />
            <div class="col-md-10 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">FORMULIR SURVEI KELOMPOK USAHA MENENGAH KECIL MIKRO (UMKM)</h3>
                        <h3 class="text-center">MENDORONG INVESTASI BESAR BERMITRA DENGAN UMKM TAHUN {{ ($survey ? \Carbon\Carbon::parse($survey->created_at)->format('Y') : \Carbon\Carbon::now()->format('Y')) }}</h3>
                    </div>
                </div>

                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_profil_usaha")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_profil_pengelolaan_usaha")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_kemampuan_finansial")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_profil_produk_barang_jasa")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_fasilitas_usaha")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_pengalaman_ekspor")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_pengalaman_kerja_sama_kemitraan")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_hal_lain")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_responden")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.note_revision")

                {{--@include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_jumlah_tenaga_kerja")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_jam_kerja_dalam_1_minggu")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_usia_tenaga_kerja")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_pendidikan_tenaga_kerja")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_struktur_organisasi")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_assessment_kemitraan_prospektif")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_dokumentasi")--}}

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <strong class="text-danger">**</strong>) {{ trans('message.survey_input_required') }}
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status_survey">Status</label>
                                    <select id="status_survey" name="status" class="form-control form-control-sm" required>
                                        @if (auth()->user()->group_id == GROUP_SURVEYOR)
                                            @foreach($status_survey as $key => $status)
                                                <option value="{{ $key }}" {{ ($survey->status == $key ? 'selected':'') }}>{{ trans("label.survey_status_{$key}") }}</option>
                                            @endforeach
                                        @else
                                            <option value="verified" {{ ($survey->status == 'verified' ? 'selected':'') }}>{{ trans("label.survey_status_verified") }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
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
    <script>
        window['wilayah'] = [
            'responden',
            'profil_usaha'
        ];
        const category_company = "{{ $category_company }}",
            labelDelete = "{{ trans('label.delete') }}",
            pathCompany = "{{ ($path_company ? $path_company:'') }}";
    </script>
    {{--{!! module_script('core', 'plugins/dropzone/5.7.0/js/dropzone.min.js') !!}--}}
    {!! library_datepicker('js') !!}
    {!! library_select2('js') !!}
    {!! library_tinymce('js') !!}
    {!! library_leaflet('js') !!}
    {{--{!! filemanager_standalonepopup() !!}--}}
    {!! module_script('wilayah', 'js/event-wilayah.js') !!}
    {!! plugins_script('bkpmumkm', 'survey/backend/js/dropzone.js') !!}
    {!! plugins_script('bkpmumkm', 'survey/backend/js/input-survey.js') !!}
    {!! plugins_script('bkpmumkm', "survey/backend/js/input-survey-{$category_company}.js") !!}
@endpush
