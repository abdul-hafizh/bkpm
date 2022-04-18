<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">3. Profil Produk Barang/Jasa yang Dihasilkan</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="d-none d-md-block">
            <tr class="row">
                <th class="col-md-3 col-sm-12 col-xs-12">Produk Barang/Jasa</th>
                <th class="col-md-4 col-sm-12 col-xs-12">Deskripsi & Spesifikasi Produk Barang/Jasa</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Kapasitas Produksi per bulan</th>
                <th class="col-md-3 col-sm-12 col-xs-12">**Foto/Dokumen</th>
            </tr>
            </thead>
            <tbody class="">
            @php
                $profil_produk_barang_jasa    = ($survey->survey_result->data && (isset($survey->survey_result->data['profil_produk_barang_jasa'])&&$survey->survey_result->data['profil_produk_barang_jasa']) ? $survey->survey_result->data['profil_produk_barang_jasa'] : []);
            @endphp
            @foreach($profil_produk_barang_jasa as $ppbj)
                <tr class="row">
                    <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Produk Barang/Jasa</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>{{ (isset($ppbj['nama'])?$ppbj['nama']:'-') }}
                    </td>
                    <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Deskripsi & Spesifikasi Produk Barang/Jasa</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {!! nl2br((isset($ppbj['deskripsi'])?$ppbj['deskripsi']:'-')) !!}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Kapasitas Produksi per bulan</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($ppbj['kapasitas'])?$ppbj['kapasitas']:'-') }}
                    </td>
                    <td class="col-md-3 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-12 d-md-none d-lg-none d-xl-none"><label>**Foto/Dokumen</label></div>
                            <div class="col-12 mt-2">
                                @php
                                    $profil_produk_barang_jasa_foto_dokumen    = (isset($ppbj['foto_dokumen'])?$ppbj['foto_dokumen']: []);
                                @endphp
                                <div class="row text-center text-lg-left">
                                    @foreach($profil_produk_barang_jasa_foto_dokumen as $foto_dokumen)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <a href="{{ asset($foto_dokumen['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($foto_dokumen['file'])) }}">
                                                <img class="img-fluid img-thumbnail" src="{{ view_asset($foto_dokumen['file']) }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <p class="text-justify">Catatan: **)Mohon sampaikan kepada surveyor foto produk ataupun dokumen-mengenai produk barang/jasa yang dilayani untuk didokumentasikan.</p>

    </div>
</div>
