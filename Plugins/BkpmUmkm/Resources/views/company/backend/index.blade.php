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
            {!! form_import_single("{$bkpmumkm_identifier}.backend.company.import", plugins_asset('bkpmumkm', 'company/files/format-import-usaha-besar.xlsx'), '', true) !!}
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
                filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableProvinsi select2FilterDataTableProvinsi" name="provinsi_id">';
            @else
                filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableProvinsi" select2FilterDataTableProvinsi" name="provinsi_id">';
            @endif
            filter_wilayah_status += '<option value="all" selected>@lang('label.all_provinsi')</option>';
            filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';    
            filter_wilayah_status += '<div class="col-3 form-group">';
            filter_wilayah_status += '<label>Status</label>';
            filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="status_filter">';    
            filter_wilayah_status += '<option value="all">Semua Status</option>';             
            filter_wilayah_status += '<option value="bersedia">Bersedia</option>';             
            filter_wilayah_status += '<option value="tidak_bersedia">Belum Bersedia</option>';             
            filter_wilayah_status += '<option value="tidak_respon">Tidak Respon</option>';             
            filter_wilayah_status += '<option value="konsultasi_bkpm">Konsultasi BKPM</option>';             
            filter_wilayah_status += '<option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>';             
            filter_wilayah_status += '<option value="belum_terisi">Status Belum Terisi</option>';             
            filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';        
        @endif
    </script>
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    {!! module_script('core','js/events.js') !!}
    {!! plugins_script('bkpmumkm', 'survey/backend/js/index.js') !!}
@endpush
