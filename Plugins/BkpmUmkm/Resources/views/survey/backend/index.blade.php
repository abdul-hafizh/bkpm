@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_datatables('css') !!}
    {!! library_select2('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        @if($show_download)
            <div class="row mb-3">
                <div class="col-12 text-right">
                    @php
                        $title_download = trans('label.download');
                        $bkpmumkm_wilayah = bkpmumkm_wilayah(auth()->user()->id_provinsi);
                    @endphp
                    @foreach(config()->get('simple_cms.plugins.bkpmumkm.template_download_form_survey') as $config)
                        @if ($config == "surat_tugas")
                            @if ($bkpmumkm_wilayah && is_array($bkpmumkm_wilayah) && count($bkpmumkm_wilayah))
                                @php
                                    $link_download_form_survey = simple_cms_setting("template_form_survey_{$category_company}_{$config}_survey_{$bkpmumkm_wilayah['index']}");
                                @endphp
                                @if(!empty($link_download_form_survey))
                                    <a class="btn btn-info btn-sm" href="{{ generate_link_download($link_download_form_survey, true) }}" title="{{ $title_download . ': ' . trans("label.template_form_survey_{$category_company}_{$config}_survey") }}" target="_blank"><i class="fas fa-download"></i> {{ $title_download . ': ' . trans("label.template_form_survey_{$category_company}_{$config}_survey") }}</a>
                                @endif
                            @endif
                        @else
                            @php
                                $link_download_form_survey = simple_cms_setting("template_form_survey_{$category_company}_{$config}_survey");
                            @endphp
                            @if(!empty($link_download_form_survey))
                                <a class="btn btn-info btn-sm" href="{{ generate_link_download($link_download_form_survey, true) }}" title="{{ $title_download . ': ' . trans("label.template_form_survey_{$category_company}_{$config}_survey") }}" target="_blank"><i class="fas fa-download"></i> {{ $title_download . ': ' . trans("label.template_form_survey_{$category_company}_{$config}_survey") }}</a>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
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
    <script>
        $(document).ready(function () {
            let dataTables_wrapper= $('div.dataTables_wrapper').find('div.row');
            dataTables_wrapper.find('div.toolbar-button-datatable').removeClass('col-md-6').addClass('col-md-8');
            dataTables_wrapper.find('div.text-right').removeClass('col-md-6').addClass('col-md-4');

        });
        @php
            $periodes = [];
            foreach (list_years() as $y) {
                $periodes[] = $y;
            }
        @endphp
        const periodes = @json($periodes),
            label_all_provinsi = '@lang('label.all_provinsi')';
        let filter_wilayah_status = '';
        @if(in_array(auth()->user()->group_id, [GROUP_QC_KORWIL,GROUP_ASS_KORWIL,GROUP_TA,GROUP_SUPER_ADMIN,GROUP_ADMIN]))
            filter_wilayah_status += '<div class="col-2 form-group">';
            filter_wilayah_status += '<label>@lang('label.wilayah')</label>';
            filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableWilayah" name="wilayah_id">';
            @foreach(list_bkpmumkm_wilayah_by_user() as $wilayah_filter)
                filter_wilayah_status += '<option value="{{ $wilayah_filter['id'] }}" data-provinces=\'@json($wilayah_filter['provinces'])\'>{{ $wilayah_filter['name'] }}</option>';
            @endforeach
            filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';
            filter_wilayah_status += '<div class="col-3 form-group">';
            filter_wilayah_status += '<label>@lang('label.provinsi')</label>';
            @if(request()->route()->getName() == "simple_cms.plugins.bkpmumkm.backend.survey.company.index" || request()->route()->getName() == "simple_cms.plugins.bkpmumkm.backend.survey.umkm.index")
                filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableProvinsi select2FilterDataTableProvinsi" name="provinsi_id[]">';
            @else
                filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableProvinsi" select2FilterDataTableProvinsi" name="provinsi_id[]">';
            @endif
            filter_wilayah_status += '<option value="all" selected>@lang('label.all_provinsi')</option>';
            filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';
        @endif
        @php
        $list_status = ($category_company==CATEGORY_COMPANY? ['progress', 'done', 'verified', 'revision'] : ['progress', 'done', 'revision', 'verified', 'menolak', 'tutup', 'pindah', 'bersedia']);
        @endphp
        filter_wilayah_status += '<div class="col-3 form-group">';
        filter_wilayah_status += '<label>@lang('label.status')</label>';
        filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="status_survey">';
        filter_wilayah_status += '<option value="{{ encrypt_decrypt('all') }}">@lang('label.all_status_survey')</option>';
        @foreach($list_status as $status)
            filter_wilayah_status += '<option value="{{ encrypt_decrypt($status) }}">@lang("label.survey_status_{$status}")</option>';
        @endforeach
        filter_wilayah_status += '</select>';
        filter_wilayah_status += '</div>';
    </script>
    {!! library_select2('js') !!}
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    {!! module_script('core','js/events.js') !!}
    {!! plugins_script('bkpmumkm', 'survey/backend/js/index.js') !!}
@endpush
