@extends('core::layouts.backend')
@section('title', 'Rekap Laporan: Tenaga Ahli dalam satu Wilayah')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Rekap Laporan: Tenaga Ahli"> Rekap Laporan: Tenaga Ahli dalam satu Wilayah</a></li>
@endsection
@push('css_stack')
    {!! library_datatables('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center mb-0 text-uppercase">Laporan Tenaga Ahli dalam satu Wilayah</h4>
                    </div>
                </div>

                @if ($show_select_dw)
                    <form class="col-4 p-0" action="{{ route("{$bkpmumkm_identifier}.backend.rekap_laporan.tenaga_ahli") }}" method="GET">
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
                @endif
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Nama-nama Tenaga Ahli</dt>
                            <dd class="col-sm-8">
                                @if($user_tenaga_ahli->count())
                                    <ol class="pl-3">
                                        @foreach($user_tenaga_ahli as $u_ta)
                                            <li><strong>{{ $u_ta->name }}</strong> {{ ($u_ta->provinsi ? "[{$u_ta->provinsi->nama_provinsi}]":'') }}</li>
                                        @endforeach
                                    </ol>
                                @else
                                    <i>Nama-nama Tenaga Ahli tidak ada.</i>
                                @endif
                            </dd>
                            <dt class="col-sm-4">Nama-nama Koordinator Wilayah</dt>
                            <dd class="col-sm-8">
                                @if($user_korwil->count())
                                    <ol class="pl-3">
                                        @foreach($user_korwil as $u_korwil)
                                            <li><strong>{{ $u_korwil->name }}</strong> {{ ($u_korwil->provinsi ? "[{$u_korwil->provinsi->nama_provinsi}]":'') }}</li>
                                        @endforeach
                                    </ol>
                                @else
                                    <i>Nama-nama Koordinator Wilayah tidak ada.</i>
                                @endif
                            </dd>
                            <dt class="col-sm-4">Nama-nama Asisten Wilayah</dt>
                            <dd class="col-sm-8">
                                @if($user_ass_korwil->count())
                                    <ol class="pl-3">
                                        @foreach($user_ass_korwil as $uas_korwil)
                                            <li><strong>{{ $uas_korwil->name }}</strong> {{ ($uas_korwil->provinsi ? "[{$uas_korwil->provinsi->nama_provinsi}]":'') }}</li>
                                        @endforeach
                                    </ol>
                                @else
                                    <i>Nama-nama Asisten Wilayah tidak ada.</i>
                                @endif
                            </dd>
                            <dt class="col-sm-4">Wilayah</dt>
                            <dd class="col-sm-8">
                                <strong>{{ $bkpmumkm_wilayah[$dw_selected]['name'] }}</strong>
                                <ol class="pl-4">
                                    @foreach($provinces as $province)
                                        <li>{{ $province->nama_provinsi }}</li>
                                    @endforeach
                                </ol>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function () {
            $('form#tenagaAhliDatatable').remove();
        });
    </script>
@endpush
