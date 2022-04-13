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
        
        const periodes = @json($periodes);

        const provinsi_id = @json($provinsi_id);

        $(document).ready(function () {
            let dataTableID = $(document).find('table.dataTable').attr('id'),
            filter = '<div class="form-group col-2">';
            filter += '<label>Periode</label>';
            filter += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="periode">';
            $.each(periodes, function(idx, val){
                filter += '<option value="'+ val +'">'+ val +'</option>';
            });
            filter += '</select>';
            filter += '</div>';

            filter += '<div class="form-group col-4">';
            filter += '<label>Provinsi</label>';
            filter += '<select class="form-control form-control-sm" name="provinsi_id_select">';    
            filter += '<option value="">Semua Provinsi</option>';
            $.each(provinsi_id, function(idx, val){
                filter += '<option value="'+ val['kode_provinsi'] +'">'+ val['nama_provinsi'] +'</option>';
            });
            filter += '</select>';
            filter += '</div>';

            $(`form#${dataTableID}Form`).append(filter);
        });
        
    </script>
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    {!! module_script('core','js/events.js') !!}
@endpush
