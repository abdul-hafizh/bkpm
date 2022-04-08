@extends('core::layouts.backend')
@section('title', 'Rekap Laporan: UMKM POTENSIAL')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Rekap Laporan: UMKM POTENSIAL"> Rekap Laporan: UMKM POTENSIAL</a></li>
@endsection
@push('css_stack')

@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center mb-0">LAPORAN UMKM POTENSIAL</h4>
                    </div>
                </div>

                <form class="col-4 p-0" action="{{ route("{$bkpmumkm_identifier}.backend.rekap_laporan.umkm.potensial") }}" method="GET">
                    <div class="form-group">
                        <div class="input-group input-group-sm">
                            <select id="selectDW" name="dw" class="form-control">
                                @foreach ($bkpmumkm_wilayah as $idx_bw => $bw)
                                    <option value="{{ encrypt_decrypt($idx_bw) }}" {{ ($idx_bw == $dw_selected ? 'selected':'') }}>{{ $bw['name'] }}</option>
                                @endforeach
                            </select>
                            <select id="selectPeriode" name="periode" class="form-control">
                                @foreach (list_years() as $year)
                                    <option value="{{ $year }}" {{ ($year == $periode ? 'selected':'') }}>{{ $year }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-info btn-flat">Go!</button>
                            </span>
                        </div>
                    </div>
                </form>

                @include("{$bkpmumkm_identifier}::rekap_laporan.umkm.table_potensial")

            </div>
        </div>
    </div>
@endsection
@push('js_stack')

@endpush
