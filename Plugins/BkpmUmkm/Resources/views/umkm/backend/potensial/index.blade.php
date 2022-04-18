@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
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
            {!! form_import_single("{$bkpmumkm_identifier}.backend.umkm.potensial.import", plugins_asset('bkpmumkm', 'umkm/files/format-import-umkm-potensial.xlsx'), '', true) !!}
        </div>
    </div>
@endsection
@push('js_stack')
    <script>
        @php
            $periodes = [];
            foreach (list_years() as $y) {
                $periodes[] = $y;
            }
        @endphp
        
        const periodes = @json($periodes),
        sektor = @json($sektor);
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
                filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableProvinsi select2FilterDataTableProvinsi" name="provinsi_id">';
            @else
                filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableProvinsi" select2FilterDataTableProvinsi" name="provinsi_id">';
            @endif
            filter_wilayah_status += '<option value="all" selected>@lang('label.all_provinsi')</option>';
            filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';
            filter_wilayah_status += '<div class="col-3 form-group">';
            filter_wilayah_status += '<label>Sektor</label>';
            filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="sektor_id">';    
            filter_wilayah_status += '<option value="all">Semua Sektor</option>';
            $.each(sektor, function(idxs, vals){
                filter_wilayah_status += '<option value="'+ vals['id'] +'">'+ vals['slug'] +'</option>';
            });        
            filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';
        @endif

    </script>
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    {!! module_script('core','js/events.js') !!}
    {!! plugins_script('bkpmumkm', 'survey/backend/js/index.js') !!}
@endpush
