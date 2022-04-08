@extends('core::layouts.setting')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_select2('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row bg-gradient-white">
            <div class="col-5 col-sm-3 p-0">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="vert-tabs-general-tab" data-toggle="pill" href="#vert-tabs-general" role="tab" aria-controls="vert-tabs-general" aria-selected="true">General</a>
                </div>
            </div>
            <div class="col-7 col-sm-9 p-5">
                <div id="vert-tabs-tabContent" class="tab-content bg-white">
                    <div class="tab-pane text-left fade show active" id="vert-tabs-general" role="tabpanel" aria-labelledby="vert-tabs-general-tab">
                        <form class="formSettingSaveUpdate row" data-action="{{ route('simple_cms.setting.backend.save_update') }}">
                            @foreach([CATEGORY_COMPANY, CATEGORY_UMKM] as $cc)
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>{{ trans("label.template_form_survey_{$cc}") }}</label>
                                    </div>
                                    <hr/>
                                    @foreach(config()->get('simple_cms.plugins.bkpmumkm.template_download_form_survey') as $config)
                                        @if ($config == "surat_tugas")
                                            @if ($bkpmumkm_wilayah)
                                                @foreach($bkpmumkm_wilayah as $key => $wilayah)
                                                    <div class="form-group">
                                                        <label for="template_form_survey_{{ $cc }}_{{ $config }}_{{ $key }}_survey">{{ trans("label.template_form_survey_{$cc}_{$config}_survey") }}: {{ $wilayah['name'] }}</label>
                                                        <div class="input-group input-group-sm">
                                                            <input id="template_form_survey_{{ $cc }}_{{ $config }}_{{ $key }}_survey" type="text" class="form-control thumbViewImage" name="settings[template_form_survey_{{ $cc }}_{{ $config }}_survey_{{ $key }}]" value="{{ simple_cms_setting("template_form_survey_{$cc}_{$config}_survey_{$key}", '') }}" data-extensions="doc,docx,jpg,jpeg,pdf">
                                                            <span class="input-group-append">
                                                                <button type="button" class="btn btn-success btn-sm popup_selector" data-inputid="template_form_survey_{{ $cc }}_{{ $config }}_{{ $key }}_survey"><i class="fas fa-image"></i> </button>
                                                                <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="simple_cms.removeViewImage('template_form_survey_{{ $cc }}_{{ $config }}_{{ $key }}_survey')"><i class="fas fa-remove"></i> </button>
                                                            </span>
                                                        </div>
                                                        <span class="text-info">Extension .doc, .docx, .jpg, .jpeg, .pdf</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div id="viewImage-template_form_survey_{{ $cc }}_{{ $config }}_{{ $key }}_survey"></div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                            <div class="form-group">
                                                <label for="template_form_survey_{{ $cc }}_{{ $config }}_survey">{{ trans("label.template_form_survey_{$cc}_{$config}_survey") }}</label>
                                                <div class="input-group input-group-sm">
                                                    <input id="template_form_survey_{{ $cc }}_{{ $config }}_survey" type="text" class="form-control thumbViewImage" name="settings[template_form_survey_{{ $cc }}_{{ $config }}_survey]" value="{{ simple_cms_setting("template_form_survey_{$cc}_{$config}_survey", '') }}" data-extensions="doc,docx,jpg,jpeg,pdf">
                                                    <span class="input-group-append">
                                                    <button type="button" class="btn btn-success btn-sm popup_selector" data-inputid="template_form_survey_{{ $cc }}_{{ $config }}_survey"><i class="fas fa-image"></i> </button>
                                                    <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="simple_cms.removeViewImage('template_form_survey_{{ $cc }}_{{ $config }}_survey')"><i class="fas fa-remove"></i> </button>
                                                </span>
                                                </div>
                                                <span class="text-info">Extension .doc, .docx, .jpg, .jpeg, .pdf</span>
                                            </div>
                                            <div class="form-group">
                                                <div id="viewImage-template_form_survey_{{ $cc }}_{{ $config }}_survey"></div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                            <hr/>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <h3>{{ trans('label.bkpmumkm_wilayah') }}</h3>
                                        <hr class="mt-0"/>
                                        <button type="button" class="btn btn-primary btn-sm bkpmumkm_add_new_wilayah" title="{{ trans('label.bkpmumkm_add_new_wilayah') }}"><i class="fas fa-plus"></i> {{ trans('label.bkpmumkm_add_new_wilayah') }}</button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row itemsBkpmUmkmWilayah">
                                            @if ($bkpmumkm_wilayah)
                                                @foreach($bkpmumkm_wilayah as $key => $wilayah)
                                                    <div class="col-6 itemBkpmUmkmWilayah">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="bkpmumkm_wilayah_name_{{ $key }}">{{ trans('label.bkpmumkm_name_wilayah') }} <i class="text-danger">*</i> </label>
                                                                    <input id="bkpmumkm_wilayah_name_{{ $key }}" type="text" name="settings[bkpmumkm_wilayah][][name]" value="{{ $wilayah['name'] }}" class="form-control" placeholder="{{ trans('label.bkpmumkm_name_wilayah') }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="bkpmumkm_wilayah_provinces_{{ $key }}">{{ trans('label.bkpmumkm_province_wilayah') }} <i class="text-danger">*</i> </label>
                                                                    <select id="bkpmumkm_wilayah_provinces_{{ $key }}" name="settings[bkpmumkm_wilayah][][provinces][]" class="form-control select2InitB4" multiple required>
                                                                        @foreach($provinces as $province)
                                                                            <option value="{{ $province->kode_provinsi }}" {{ (in_array($province->kode_provinsi, $wilayah['provinces']) ? 'selected':'') }}>{{ $province->nama_provinsi }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer text-right">
                                                                <button type="button" class="btn btn-danger btn-sm bkpmumkm_delete_wilayah" title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-10">
                                <div class="row">
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-sm btn-primary" title="Save"><i class="fas fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_stack')
    <script>
        const label_bkpmumkm_name_wilayah = "{{ trans('label.bkpmumkm_name_wilayah') }}",
            label_bkpmumkm_province_wilayah = "{{ trans('label.bkpmumkm_province_wilayah') }}",
            label_delete = "{{ trans('label.delete') }}",
            provinces       = @json($provinces);

    </script>
    {!! library_select2('js') !!}
    {!! plugins_script('bkpmumkm', 'setting/js/index.js') !!}
@endpush
