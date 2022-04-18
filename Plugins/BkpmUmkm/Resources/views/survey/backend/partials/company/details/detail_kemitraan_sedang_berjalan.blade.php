<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">3. Kemitraan UMKM yang Sedang Berjalan dengan UB</h3>
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
            <tbody class="">
            @php
                $kemitraan_sedang_berjalan    = ($survey->survey_result && (isset($survey->survey_result->data)&&$survey->survey_result->data) && (isset($survey->survey_result->data['kemitraan_sedang_berjalan'])&&$survey->survey_result->data['kemitraan_sedang_berjalan']) ? $survey->survey_result->data['kemitraan_sedang_berjalan'] : []);
                $index_ksb = 1;
                $kemitraan_berjalan_total_potensi_nilai = 0;
            @endphp
            @foreach($kemitraan_sedang_berjalan as $k_ksb => $ksb)
                <tr class="row">
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Pola Kemitraan</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($ksb['pola_kemitraan'])?$ksb['pola_kemitraan']:'-') }}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Nama Perusahaan UMKM</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($ksb['nama_perusahaan'])?$ksb['nama_perusahaan']:'-') }}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="">Bidang Usaha</label>
                            <br/>
                            {{ (isset($ksb['bidang_usaha'])?$ksb['bidang_usaha']:'-') }}
                        </div>
                        <div class="form-group">
                            <label class="">Jenis Pekerjaan</label>
                            <br/>
                            {{ (isset($ksb['jenis_pekerjaan'])?$ksb['jenis_pekerjaan']:'-') }}
                        </div>
                        <div class="form-group">
                            <label class="">Spesifikasi/Persyaratan</label>
                            <br/>
                            {!! nl2br(isset($ksb['persyaratan'])?$ksb['persyaratan']:'-') !!}
                        </div>
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Waktu Pelaksanaan</label>
                            <br/>
                            {{ (isset($ksb['waktu_pelaksanaan'])?$ksb['waktu_pelaksanaan']:'-') }}
                        </div>
                        <div class="form-group">
                            <label>No Telp UMKM</label>
                            <br/>
                            {{ (isset($ksb['no_telp'])?$ksb['no_telp']:'-') }}
                        </div>
                        <div class="form-group">
                            <label>Alamat UMKM</label>
                            <br/>
                            {!! nl2br((isset($ksb['alamat'])?$ksb['alamat']:'-')) !!}
                        </div>
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">@lang('label.kemitraan_berjalan_nilai_kontrak')</label>
                        <br/>
                        {{ (isset($ksb['nilai'])?$ksb['nilai']:'-') }}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Term of Payment</label>
                            <br/>
                            {!! nl2br((isset($ksb['term_of_payment'])?$ksb['term_of_payment']:'-')) !!}
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kemitraan_berjalan_satuan')</label>
                            <br/>
                            {{ (isset($ksb['satuan'])?$ksb['satuan']:'-') }}
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kemitraan_berjalan_pengali')</label>
                            <br/>
                            {{ (isset($ksb['pengali'])?$ksb['pengali']:'-') }}
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kemitraan_berjalan_total_potensi_nilai')</label>
                            <br/>
                            {{ (isset($ksb['total_potensi_nilai'])?$ksb['total_potensi_nilai']:'-') }}
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
                <th colspan="2" class="col-md-6 col-sm-12 col-xs-12 text-left">Total Data: {{ count($kemitraan_sedang_berjalan) }}</th>
                <th colspan="4" class="col-md-6 col-sm-12 col-xs-12 text-right">Total Semua Potensi Nilai: {{ number_format($kemitraan_berjalan_total_potensi_nilai,0,",",".") }}</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
