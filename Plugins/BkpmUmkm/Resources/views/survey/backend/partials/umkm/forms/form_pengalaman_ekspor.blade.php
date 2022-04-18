<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">6. Pengalaman Ekspor <button type="button" class="btn btn-xs btn-primary eventAddNewPengalamanEkspor" title="{{ trans('label.add_new') }}"><i class="fas fa-plus"></i> {{ trans('label.add_new') }}</button></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="d-none d-md-block">
            <tr class="row">
                <th class="col-md-4 col-sm-12 col-xs-12">Jenis Produk</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Negara Tujuan Ekspor</th>
                <th class="col-md-4 col-sm-12 col-xs-12">Nilai Ekspor</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Tahun</th>
            </tr>
            </thead>
            <tbody class="itemsPengalamanEkspor">
            @php
                $pengalaman_ekspor    = ($survey->survey_result->data && (isset($survey->survey_result->data['pengalaman_ekspor'])&&$survey->survey_result->data['pengalaman_ekspor']) ? $survey->survey_result->data['pengalaman_ekspor'] : []);
                $index_pe = 1;
                $pengalaman_ekspor_total_nilai = 0;
            @endphp
            @foreach($pengalaman_ekspor as $k_pe => $pe)
                <tr class="itemPengalamanEkspor row">
                    <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Jenis Produk</label>
                        <input type="text" name="data[pengalaman_ekspor][{{ $index_pe }}][jenis_produk]" value="{{ (isset($pe['jenis_produk'])?$pe['jenis_produk']:'') }}" placeholder="Jenis Produk" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Negara Tujuan Ekspor</label>
                        <input type="text" name="data[pengalaman_ekspor][{{ $index_pe }}][negara_tujuan]" value="{{ (isset($pe['negara_tujuan'])?$pe['negara_tujuan']:'') }}" placeholder="Negara Tujuan Ekspor" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Nilai Ekspor</label>
                        <input type="text" name="data[pengalaman_ekspor][{{ $index_pe }}][nilai]" value="{{ (isset($pe['nilai'])?$pe['nilai']:'') }}" placeholder="Nilai Ekspor" class="form-control form-control-sm nominal">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Tahun</label>
                        <input type="text" name="data[pengalaman_ekspor][{{ $index_pe }}][tahun]" value="{{ (isset($pe['tahun'])?$pe['tahun']:'') }}" placeholder="Tahun" class="form-control form-control-sm numberonly">
                        <button type="button" class="btn btn-xs btn-danger eventRemovePengalamanEkspor mt-3" title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                    </td>
                </tr>
                @php
                    $pengalaman_ekspor_total_nilai += (int) (isset($pe['nilai'])&&!empty($pe['nilai'])? str_replace([',','.'], '', $pe['nilai']):0);
                    $index_pe++;
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr class="row">
                <th colspan="2" class="col-md-6 col-sm-12 col-xs-12 text-left total_data_pengalaman_ekspor">Total Data: {{ count($pengalaman_ekspor) }}</th>
                <th colspan="2" class="col-md-6 col-sm-12 col-xs-12 text-left pengalaman_ekspor_total_nilai">Total Nilai: {{ number_format($pengalaman_ekspor_total_nilai) }}</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
