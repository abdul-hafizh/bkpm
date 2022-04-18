<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">5. Fasilitas Usaha <button type="button" class="btn btn-xs btn-primary eventAddNewFasilitasUsaha" title="{{ trans('label.add_new') }}"><i class="fas fa-plus"></i> {{ trans('label.add_new') }}</button></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="d-none d-md-block">
            <tr class="row">
                <th class="col-md-3 col-sm-12 col-xs-12">Jenis Kegiatan Kerja</th>
                <th class="col-md-6 col-sm-12 col-xs-12">Peralatan/Mesin yang Digunakan</th>
                <th class="col-md-3 col-sm-12 col-xs-12">Perkiraan Nilai (Rp)</th>
            </tr>
            </thead>
            <tbody class="itemsFasilitasUsaha">
            @php
                $fasilitas_usaha    = ($survey->survey_result->data && (isset($survey->survey_result->data['fasilitas_usaha'])&&$survey->survey_result->data['fasilitas_usaha']) ? $survey->survey_result->data['fasilitas_usaha']: []);
                $index_fu = 1;
                $fasilitas_usaha_total_nilai = 0;
            @endphp
            @foreach($fasilitas_usaha as $kfu => $fu)
                <tr class="itemFasilitasUsaha row">
                    <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Jenis Kegiatan Kerja</label>
                        <input type="text" name="data[fasilitas_usaha][{{ $index_fu }}][jenis_kegiatan]" value="{{ (isset($fu['jenis_kegiatan'])?$fu['jenis_kegiatan']:'') }}" placeholder="Jenis Kegiatan Kerja" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-6 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Peralatan/Mesin yang Digunakan</label>
                        <textarea name="data[fasilitas_usaha][{{ $index_fu }}][peralatan_mesin]" rows="3" placeholder="Peralatan/Mesin yang Digunakan" class="form-control form-control-sm">{!! nl2br(strip_tags(isset($fu['peralatan_mesin'])?$fu['peralatan_mesin']:'')) !!}</textarea>
                    </td>
                    <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Perkiraan Nilai (Rp)</label>
                        <input type="text" name="data[fasilitas_usaha][{{ $index_fu }}][nilai]" value="{{ (isset($fu['nilai'])?$fu['nilai']:'') }}" placeholder="Perkiraan Nilai (Rp)" class="form-control form-control-sm nominal">
                        <button type="button" class="btn btn-xs btn-danger eventRemoveFasilitasUsaha mt-3" title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                    </td>
                </tr>
                @php
                    $fasilitas_usaha_total_nilai += (int) (isset($fu['nilai'])&&!empty($fu['nilai'])? str_replace([',','.'], '', $fu['nilai']):0);
                    $index_fu++;
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr class="row">
                <th colspan="2" class="col-md-6 col-sm-12 col-xs-12 text-left total_data_fasilitas_usaha">Total Data: {{ count($fasilitas_usaha) }}</th>
                <th colspan="1" class="col-md-6 col-sm-12 col-xs-12 text-right fasilitas_usaha_total_nilai">Total Nilai: {{ number_format($fasilitas_usaha_total_nilai) }}</th>
            </tr>
            </tfoot>
        </table>
        <p class="text-justify">Catatan: Mohon menjelaskan aset yang dimiliki berdasarkan urut-urutan kegiatan yang dijalankan untuk menghasilkan produk/jasa.</p>
    </div>
</div>
