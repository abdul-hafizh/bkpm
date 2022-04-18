<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">{{ (isset($hide_number)&&$hide_number?'':'2.') }} Kebutuhan Kemitraan dengan UMKM</h3>
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
            <tbody class="">
            @php
                $kebutuhan_kemitraan    = ($survey->survey_result && (isset($survey->survey_result->data)&&$survey->survey_result->data) && (isset($survey->survey_result->data['kebutuhan_kemitraan'])&&$survey->survey_result->data['kebutuhan_kemitraan']) ? $survey->survey_result->data['kebutuhan_kemitraan'] : []);
                $kebutuhan_kemitraan_total_potensi_nilai = 0;
            @endphp
            @foreach($kebutuhan_kemitraan as $k_kk => $kk)
                <tr class="row">
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">                            
                            <label class="d-md-none d-lg-none d-xl-none">Jenis Pekerjaan</label>
                            <br class="d-md-none d-lg-none d-xl-none"/>
                            {{ (isset($kk['jenis_pekerjaan'])?$kk['jenis_pekerjaan']:'-') }}
                        </div> 
                        <!-- <div class="form-group">                            
                            <label class="">Jenis Supply</label>
                            <br class="d-md-none d-lg-none d-xl-none"/>
                            {{ (isset($kk['jenis_supply'])?$kk['jenis_supply']:'-') }}
                        </div>    -->
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Produk</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($kk['produk'])?$kk['produk']:'-') }}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Kapasitas</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($kk['kapasitas'])?$kk['kapasitas']:'-') }}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Spesifikasi/Persyaratan</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {!! nl2br(isset($kk['persyaratan'])?$kk['persyaratan']:'-') !!}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">@lang('label.kebutuhan_kemitraan_nilai_kontrak')</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($kk['nilai'])?$kk['nilai']:'') }}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_terms_of_payment')</label>
                            <br/>
                            {!! nl2br(isset($kk['terms_of_payment'])?$kk['terms_of_payment']:'') !!}
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_satuan')</label>
                            <br/>
                            {{ (isset($kk['satuan'])?$kk['satuan']:'') }}
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_pengali')</label>
                            <br/>
                            {{ (isset($kk['pengali'])?$kk['pengali']:0) }}
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_total_potensi_nilai')</label>
                            <br/>
                            {{ (isset($kk['total_potensi_nilai'])?$kk['total_potensi_nilai']:0) }}
                        </div>
                    </td>
                </tr>
                @php
                    $kebutuhan_kemitraan_total_potensi_nilai += (int) (isset($kk['total_potensi_nilai'])&&!empty($kk['total_potensi_nilai'])? str_replace([',','.'], '', $kk['total_potensi_nilai']):0);
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr class="row">
                <th colspan="2" class="col-md-6 col-sm-12 col-xs-12 text-left total_data_kebutuhan_kemitraan">Total Data: {{ count($kebutuhan_kemitraan) }}</th>
                <th colspan="4" class="col-md-6 col-sm-12 col-xs-12 text-right kebutuhan_kemitraan_total_potensi_nilai">Total Semua Potensi Nilai: {{ number_format($kebutuhan_kemitraan_total_potensi_nilai,0,",",".") }}</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
