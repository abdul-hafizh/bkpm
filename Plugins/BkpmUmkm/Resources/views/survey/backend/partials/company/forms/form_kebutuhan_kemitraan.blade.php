<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">2. Kebutuhan Kemitraan dengan UMKM <button type="button" class="btn btn-xs btn-primary eventAddNewKebutuhanKemitraan" title="{{ trans('label.add_new') }}"><i class="fas fa-plus"></i> {{ trans('label.add_new') }}</button></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="d-none d-md-block">
            <tr class="row">
                <th class="col-md-2 col-sm-12 col-xs-12">Jenis Pekerjaan</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Produk</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Kapasitas</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Spesifikasi/Persyaratan</th>
                <th class="col-md-2 col-sm-12 col-xs-12">@lang('label.kebutuhan_kemitraan_nilai_kontrak')</th>
                <th class="col-md-2 col-sm-12 col-xs-12">@lang('label.kebutuhan_kemitraan_lain_lain')</th>
            </tr>
            </thead>
            <tbody class="itemsKebutuhanKemitraan">
            @php
                $kebutuhan_kemitraan    = ($survey->survey_result->data && (isset($survey->survey_result->data['kebutuhan_kemitraan'])&&$survey->survey_result->data['kebutuhan_kemitraan']) ? $survey->survey_result->data['kebutuhan_kemitraan'] : []);
                $index_kk = 1;
                $kebutuhan_kemitraan_total_potensi_nilai = 0;
            @endphp
            @foreach($kebutuhan_kemitraan as $k_kk => $kk)
                <tr class="itemKebutuhanKemitraan row">
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="d-md-none d-lg-none d-xl-none">Jenis Pekerjaan</label>
                            <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][jenis_pekerjaan]" value="{{ (isset($kk['jenis_pekerjaan'])?$kk['jenis_pekerjaan']:'') }}" placeholder="Jenis Pekerjaan" class="form-control form-control-sm">
                        </div>                        
                        <div class="form-group">
                            <label class="d-md-none d-lg-none d-xl-none">Jenis Supply</label>                            
                            <select name="data[kebutuhan_kemitraan][{{ $index_kk }}][jenis_supply]" class="form-control form-control-sm">
                                <option value="{{ $kk['jenis_supply']=='Rantai Pasok' ? 'selected' : '' }}">Rantai Pasok</option>
                                <option value="{{ $kk['jenis_supply']=='Bahan Baku Penolong' ? 'selected' : '' }}">Bahan Baku Penolong</option>
                                <option value="{{ $kk['jenis_supply']=='Jasa-jasa Lainnya' ? 'selected' : '' }}">Jasa-jasa Lainnya</option>
                            </select>
                        </div>
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Produk</label>
                        <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][produk]" value="{{ (isset($kk['produk'])?$kk['produk']:'') }}" placeholder="Produk" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Kapasitas</label>
                        <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][kapasitas]" value="{{ (isset($kk['kapasitas'])?$kk['kapasitas']:'') }}" placeholder="Kapasitas" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Spesifikasi/Persyaratan</label>
                        <textarea name="data[kebutuhan_kemitraan][{{ $index_kk }}][persyaratan]" rows="2" placeholder="Spesifikasi/Persyaratan" class="form-control form-control-sm">{!! nl2br(isset($kk['persyaratan'])?$kk['persyaratan']:'') !!}</textarea>
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">@lang('label.kebutuhan_kemitraan_nilai_kontrak')</label>
                        <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][nilai]" value="{{ (isset($kk['nilai'])?$kk['nilai']:'0') }}" placeholder="@lang('label.kebutuhan_kemitraan_nilai_kontrak')" class="form-control form-control-sm nominal nilai_kontrak">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_terms_of_payment')</label>
                            <textarea name="data[kebutuhan_kemitraan][{{ $index_kk }}][terms_of_payment]" rows="2" placeholder="@lang('label.kebutuhan_kemitraan_terms_of_payment')" class="form-control form-control-sm">{!! nl2br(isset($kk['terms_of_payment'])?$kk['terms_of_payment']:'') !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_satuan')</label>
                            <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][satuan]" value="{{ (isset($kk['satuan'])?$kk['satuan']:'') }}" placeholder="e.g: Hari/Bulan/Tahun/Ton" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_pengali')</label>
                            <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][pengali]" value="{{ (isset($kk['pengali'])?$kk['pengali']:0) }}" placeholder="@lang('label.kebutuhan_kemitraan_pengali')" class="form-control form-control-sm nominal pengali_nilai_kontrak">
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_total_potensi_nilai')</label>
                            <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][total_potensi_nilai]" value="{{ (isset($kk['total_potensi_nilai'])?$kk['total_potensi_nilai']:0) }}" placeholder="@lang('label.kebutuhan_kemitraan_total_potensi_nilai')" class="form-control form-control-sm nominal total_potensi_nilai">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-xs btn-danger eventRemoveKebutuhanKemitraan mt-3" title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                        </div>
                    </td>
                </tr>
                @php
                    $kebutuhan_kemitraan_total_potensi_nilai += (int) (isset($kk['total_potensi_nilai'])&&!empty($kk['total_potensi_nilai'])? str_replace([',','.'], '', $kk['total_potensi_nilai']):0);
                    $index_kk++;
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr class="row">
                <th colspan="2" class="col-md-6 col-sm-12 col-xs-12 text-left total_data_kebutuhan_kemitraan">Total Data: {{ count($kebutuhan_kemitraan) }}</th>
                <th colspan="4" class="col-md-6 col-sm-12 col-xs-12 text-right kebutuhan_kemitraan_total_potensi_nilai">Total Semua Potensi Nilai: {{ number_format($kebutuhan_kemitraan_total_potensi_nilai) }}</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>
    const kebutuhan_kemitraan_nilai_kontrak = '@lang('label.kebutuhan_kemitraan_nilai_kontrak')',
        kebutuhan_kemitraan_terms_of_payment = '@lang('label.kebutuhan_kemitraan_terms_of_payment')',
        kebutuhan_kemitraan_satuan = '@lang('label.kebutuhan_kemitraan_satuan')',
        kebutuhan_kemitraan_pengali = '@lang('label.kebutuhan_kemitraan_pengali')',
        kebutuhan_kemitraan_total_potensi_nilai = '@lang('label.kebutuhan_kemitraan_total_potensi_nilai')';
</script>
