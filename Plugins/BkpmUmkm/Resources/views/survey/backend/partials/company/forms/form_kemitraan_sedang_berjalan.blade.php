<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">3. Kemitraan UMKM yang Sedang Berjalan dengan UB <button type="button" class="btn btn-xs btn-primary eventAddNewKemitraanSedangBerjalan" title="{{ trans('label.add_new') }}"><i class="fas fa-plus"></i> {{ trans('label.add_new') }}</button></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="d-none d-md-block">
            <tr class="row">
                <th class="col-md-2 col-sm-12 col-xs-12">Pola Kemitraan</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Nama Perusahaan UMKM</th>
                <th class="col-md-2 col-sm-12 col-xs-12">@lang('label.kemitraan_berjalan_keterangan_lain_1')</th>
                <th class="col-md-2 col-sm-12 col-xs-12">@lang('label.kemitraan_berjalan_keterangan_lain_2')</th>
                <th class="col-md-2 col-sm-12 col-xs-12">@lang('label.kemitraan_berjalan_nilai_kontrak')</th>
                <th class="col-md-2 col-sm-12 col-xs-12">@lang('label.kemitraan_berjalan_lain_lain')</th>
            </tr>
            </thead>
            <tbody class="itemsKemitraanSedangBerjalan">
            @php
                $kemitraan_sedang_berjalan    = ($survey->survey_result->data && (isset($survey->survey_result->data['kemitraan_sedang_berjalan'])&&$survey->survey_result->data['kemitraan_sedang_berjalan']) ? $survey->survey_result->data['kemitraan_sedang_berjalan'] : []);
                $index_ksb = 1;
                $kemitraan_berjalan_total_potensi_nilai = 0;
            @endphp
            @foreach($kemitraan_sedang_berjalan as $k_ksb => $ksb)
                <tr class="itemKemitraanSedangBerjalan row">
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Pola Kemitraan</label>
                        <input type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][pola_kemitraan]" value="{{ (isset($ksb['pola_kemitraan'])?$ksb['pola_kemitraan']:'') }}" placeholder="Pola Kemitraan" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Nama Perusahaan UMKM</label>
                        <input type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][nama_perusahaan]" value="{{ (isset($ksb['nama_perusahaan'])?$ksb['nama_perusahaan']:'') }}" placeholder="Nama Perusahaan UMKM" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="">Bidang Usaha</label>
                            <input type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][bidang_usaha]" value="{{ (isset($ksb['bidang_usaha'])?$ksb['bidang_usaha']:'') }}" placeholder="Bidang Usaha" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label class="">Jenis Pekerjaan</label>
                            <input type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][jenis_pekerjaan]" value="{{ (isset($ksb['jenis_pekerjaan'])?$ksb['jenis_pekerjaan']:'') }}" placeholder="Jenis Pekerjaan" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label class="">Spesifikasi/Persyaratan</label>
                            <textarea name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][persyaratan]" rows="2" placeholder="Spesifikasi/Persyaratan" class="form-control form-control-sm">{!! nl2br(isset($ksb['persyaratan'])?$ksb['persyaratan']:'') !!}</textarea>
                        </div>
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Waktu Pelaksanaan</label>
                            <input type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][waktu_pelaksanaan]" value="{{ (isset($ksb['waktu_pelaksanaan'])?$ksb['waktu_pelaksanaan']:'') }}" placeholder="Waktu Pelaksanaan" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>No Telp UMKM</label>
                            <input type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][no_telp]" value="{{ (isset($ksb['no_telp'])?$ksb['no_telp']:'') }}" placeholder="No Telp UMKM" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Alamat UMKM</label>
                            <textarea type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][alamat]" rows="2" placeholder="Alamat UMKM" class="form-control form-control-sm">{!! nl2br((isset($ksb['alamat'])?$ksb['alamat']:'')) !!}</textarea>
                        </div>
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">@lang('label.kemitraan_berjalan_nilai_kontrak')</label>
                        <input type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][nilai]" value="{{ (isset($ksb['nilai'])?$ksb['nilai']:'0') }}" placeholder="@lang('label.kemitraan_berjalan_nilai_kontrak')" class="form-control form-control-sm nominal kemitraan_berjalan_nilai_kontrak">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Term of Payment</label>
                            <textarea name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][term_of_payment]" rows="2" placeholder="Term of Payment" class="form-control form-control-sm">{!! nl2br((isset($ksb['term_of_payment'])?$ksb['term_of_payment']:'')) !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kemitraan_berjalan_satuan')</label>
                            <input type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][satuan]" value="{{ (isset($ksb['satuan'])?$ksb['satuan']:'') }}" placeholder="e.g: Hari/Bulan/Tahun/Ton" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kemitraan_berjalan_pengali')</label>
                            <input type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][pengali]" value="{{ (isset($ksb['pengali'])?$ksb['pengali']:0) }}" placeholder="@lang('label.kemitraan_berjalan_pengali')" class="form-control form-control-sm nominal kemitraan_berjalan_pengali_nilai_kontrak">
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kemitraan_berjalan_total_potensi_nilai')</label>
                            <input type="text" name="data[kemitraan_sedang_berjalan][{{ $index_ksb }}][total_potensi_nilai]" value="{{ (isset($ksb['total_potensi_nilai'])?$ksb['total_potensi_nilai']:0) }}" placeholder="@lang('label.kemitraan_berjalan_total_potensi_nilai')" class="form-control form-control-sm nominal kemitraan_berjalan_total_potensi_nilai" readonly>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-xs btn-danger eventRemoveKemitraanSedangBerjalan mt-3" title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                        </div>
                    </td>
                </tr>
                @php
                    $kemitraan_berjalan_total_potensi_nilai += (int) (isset($ksb['total_potensi_nilai'])&&!empty($ksb['total_potensi_nilai'])? str_replace([',','.'], '', $ksb['total_potensi_nilai']):0);
                    $index_ksb++;
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr class="row">
                <th colspan="2" class="col-md-6 col-sm-12 col-xs-12 text-left total_data_kemitraan_berjalan">Total Data: {{ count($kemitraan_sedang_berjalan) }}</th>
                <th colspan="4" class="col-md-6 col-sm-12 col-xs-12 text-right kemitraan_berjalan_total_potensi_nilai_end">Total Semua Potensi Nilai: {{ number_format($kemitraan_berjalan_total_potensi_nilai) }}</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
