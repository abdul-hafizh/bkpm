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
                    <div class="card-body">
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
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
        $(document).ready(function(){
            $('.selectTrashedDatable', document).remove();
            let dataTableID = $(document).find('table.dataTable').attr('id'),
                periode = '<div class="form-group col-2">';
            periode += '<label>Periode</label>';
            periode += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="periode">';
            $.each(periodes, function(idx, val){
                periode += '<option value="'+ val +'">'+ val +'</option>';
            });
            periode += '</select>';
            periode += '</div>';

            $(`form#${dataTableID}Form`).append(periode);
        });
    </script>
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    {!! module_script('core','js/events.js') !!}
@endpush
