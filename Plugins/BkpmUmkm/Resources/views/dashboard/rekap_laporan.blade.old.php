@extends('core::layouts.backend')
@section('title', 'Rekap Laporan')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Rekap Laporan"> Rekap Laporan</a></li>
@endsection
@push('css_stack')

@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>CAPAIAN UMKM OBSERVASI DI MASING-MASING PROVINSI BERDASARKAN TARGET UMKM</h4>
                    </div>
                    <div class="card-body p-0">
                        @include("{$bkpmumkm_identifier}::dashboard.table_capaian_target_umkm_observasi")
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_stack')

@endpush
