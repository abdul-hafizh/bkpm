<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">1. Profil Usaha</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">

        <table class="table table-sm row">
            <tbody class="col-12">
            @php
                $profil_usaha    = ($survey->survey_result->data && (isset($survey->survey_result->data['profil_usaha'])&&$survey->survey_result->data['profil_usaha']) ? $survey->survey_result->data['profil_usaha'] : '');
            @endphp
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.1</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Nama Usaha </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    {{ (isset($profil_usaha['nama_usaha']) ? $profil_usaha['nama_usaha'] : '-') }}
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.2</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Bentuk Badan Hukum</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_usaha][bentuk_badan_hukum]" value="Perseroan Terbatas (PT.)" {{ (isset($profil_usaha['bentuk_badan_hukum'])&&$profil_usaha['bentuk_badan_hukum']=='Perseroan Terbatas (PT.)' ? 'checked':'') }} class="form-check-input" id="profil_usaha_bentuk_badan_hukum_1">
                                <label class="form-check-label" for="profil_usaha_bentuk_badan_hukum_1">Perseroan Terbatas (PT.)</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_usaha][bentuk_badan_hukum]" value="CV" {{ (isset($profil_usaha['bentuk_badan_hukum'])&&$profil_usaha['bentuk_badan_hukum']=='CV' ? 'checked':'') }} class="form-check-input" id="profil_usaha_bentuk_badan_hukum_2">
                                <label class="form-check-label" for="profil_usaha_bentuk_badan_hukum_2">CV</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_usaha][bentuk_badan_hukum]" value="UD." {{ (isset($profil_usaha['bentuk_badan_hukum'])&&$profil_usaha['bentuk_badan_hukum']=='UD.' ? 'checked':'') }} class="form-check-input" id="profil_usaha_bentuk_badan_hukum_3">
                                <label class="form-check-label" for="profil_usaha_bentuk_badan_hukum_3">UD.</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_usaha][bentuk_badan_hukum]" value="Firma" {{ (isset($profil_usaha['bentuk_badan_hukum'])&&$profil_usaha['bentuk_badan_hukum']=='Firma' ? 'checked':'') }} class="form-check-input" id="profil_usaha_bentuk_badan_hukum_4">
                                <label class="form-check-label" for="profil_usaha_bentuk_badan_hukum_4">Firma</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="radio" name="data[profil_usaha][bentuk_badan_hukum]" value="Lainnya" {{ (isset($profil_usaha['bentuk_badan_hukum'])&&$profil_usaha['bentuk_badan_hukum']=='Lainnya' ? 'checked':'') }} class="form-check-input" id="profil_usaha_bentuk_badan_hukum_5">
                                <label class="form-check-label" for="profil_usaha_bentuk_badan_hukum_5">Lainnya</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            {{ (isset($profil_usaha['bentuk_badan_hukum_lainnya'])?$profil_usaha['bentuk_badan_hukum_lainnya']:'') }}
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.3</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Bidang Usaha</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    {!! nl2br(isset($profil_usaha['bidang_usaha']) ? $profil_usaha['bidang_usaha'] : '-') !!}
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.4</td>
                <td class="col-md-3 col-sm-8 col-xs-8">NIB (Nomor Induk Berusaha)</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {{ (isset($profil_usaha['kepemilikan_nib_nomor']) ? $profil_usaha['kepemilikan_nib_nomor'] : '-') }}
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.5</td>
                <td class="col-md-3 col-sm-8 col-xs-8">KBLI Usaha</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            @if (isset($profil_usaha['kbli'])&&$profil_usaha['kbli']&&$kblis = \Plugins\BkpmUmkm\Models\KbliModel::whereIn('code', $profil_usaha['kbli'])->get())
                                <ul>
                                    @foreach($kblis as $kbli)
                                        <li>[{{ $kbli->code }}] {{ $kbli->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.6</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Alamat Usaha </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th style="width: 20%;"></th>
                            <th style="width: 78%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Alamat </td>
                            <td>
                                {!! nl2br(isset($profil_usaha['alamat']) ? $profil_usaha['alamat'] : '-') !!}
                            </td>
                        </tr>
                        <tr>
                            @php
                                $profil_usaha_negara    = (isset($profil_usaha['negara'])&&!empty($profil_usaha['negara']) ? \SimpleCMS\Wilayah\Models\NegaraModel::select('kode_negara', 'nama_negara')->where('kode_negara', $profil_usaha['negara'])->first()->nama_negara : '-');
                                $profil_usaha_provinsi  = (isset($profil_usaha['provinsi'])&&!empty($profil_usaha['provinsi']) ? \SimpleCMS\Wilayah\Models\ProvinsiModel::select('kode_provinsi', 'nama_provinsi')->where('kode_provinsi', $profil_usaha['provinsi'])->first()->nama_provinsi : '-');
                                $profil_usaha_kabupaten = (isset($profil_usaha['kabupaten'])&&!empty($profil_usaha['kabupaten']) ? \SimpleCMS\Wilayah\Models\KabupatenModel::select('kode_kabupaten', 'nama_kabupaten')->where('kode_kabupaten', $profil_usaha['kabupaten'])->first()->nama_kabupaten : '-');
                                $profil_usaha_kecamatan = (isset($profil_usaha['kecamatan'])&&!empty($profil_usaha['kecamatan']) ? \SimpleCMS\Wilayah\Models\KecamatanModel::select('kode_kecamatan', 'nama_kecamatan')->where('kode_kecamatan', $profil_usaha['kecamatan'])->first()->nama_kecamatan : '-');
                                $profil_usaha_desa      = (isset($profil_usaha['desa'])&&!empty($profil_usaha['desa']) ? \SimpleCMS\Wilayah\Models\DesaModel::select('kode_desa', 'nama_desa')->where('kode_desa', $profil_usaha['desa'])->first()->nama_desa : '-');
                            @endphp
                            <td>Negara  </td>
                            <td>
                                {{ $profil_usaha_negara }}
                            </td>
                        </tr>
                        <tr>
                            <td>Provinsi  </td>
                            <td>
                                {{ $profil_usaha_provinsi }}
                            </td>
                        </tr>
                        <tr>
                            <td>Kabupaten</td>
                            <td>
                                {{ $profil_usaha_kabupaten }}
                            </td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>
                                {{ $profil_usaha_kecamatan }}
                            </td>
                        </tr>
                        <tr>
                            <td>Desa</td>
                            <td>
                                {{ $profil_usaha_desa }}
                            </td>
                        </tr>
                        <tr>
                            <td>Kode Pos</td>
                            <td>
                                {{ (isset($profil_usaha['kode_pos']) ? $profil_usaha['kode_pos'] : '-') }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.7</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Koordinat GPS Lokasi </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    @if((isset($profil_usaha['koordinat_gps_longitude'])&&!empty($profil_usaha['koordinat_gps_longitude']))&&(isset($profil_usaha['koordinat_gps_latitude'])&&!empty($profil_usaha['koordinat_gps_latitude'])))
                        <div id="boxOpenMap">
                            <div id="openMapView" class="sizeOpenMap openMapView" data-longitude="{{ (isset($profil_usaha['koordinat_gps_longitude']) ? $profil_usaha['koordinat_gps_longitude'] : '') }}" data-latitude="{{ (isset($profil_usaha['koordinat_gps_latitude']) ? $profil_usaha['koordinat_gps_latitude'] : '') }}"></div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Longitude: <br/>
                            <input id="mapLng" type="hidden" >
                            {{ (isset($profil_usaha['koordinat_gps_longitude']) ? $profil_usaha['koordinat_gps_longitude'] : '-') }}
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Latitude: <br/>
                            {{ (isset($profil_usaha['koordinat_gps_latitude']) ? $profil_usaha['koordinat_gps_latitude'] : '-') }}
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.8</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Nomor Telepon/Fax/Ponsel Perusahaan </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th style="width: 20%;"></th>
                            <th style="width: 78%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Telepon </td>
                            <td>
                                {{ (isset($profil_usaha['telepon']) ? $profil_usaha['telepon'] : '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Fax</td>
                            <td>
                                {{ (isset($profil_usaha['fax']) ? $profil_usaha['fax'] : '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Ponsel </td>
                            <td>
                                {{ (isset($profil_usaha['ponsel']) ? $profil_usaha['ponsel'] : '-') }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.9</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Email Perusahaan </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    {{ (isset($profil_usaha['email']) ? $profil_usaha['email'] : '-') }}
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.10</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Akun Media Sosial/Website Perusahaan</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th style="width: 20%;"></th>
                            <th style="width: 78%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Website</td>
                            <td>
                                {{ (isset($profil_usaha['website']) ? $profil_usaha['website'] : '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Facebook</td>
                            <td>
                                {{ (isset($profil_usaha['facebook']) ? $profil_usaha['facebook'] : '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Instagram</td>
                            <td>
                                {{ (isset($profil_usaha['instagram']) ? $profil_usaha['instagram'] : '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Twitter</td>
                            <td>
                                {{ (isset($profil_usaha['twitter']) ? $profil_usaha['twitter'] : '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td>LinkedIn</td>
                            <td>
                                {{ (isset($profil_usaha['linkedin']) ? $profil_usaha['linkedin'] : '-') }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.11</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Nama Contact Person </td>
                <td class="col-md-8 col-sm-12 col-xs-12">                    
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Nama : {{ (isset($profil_usaha['nama_cp']) ? $profil_usaha['nama_cp'] : '-') }}
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Jabatan : {{ (isset($profil_usaha['jabatan_cp']) ? $profil_usaha['jabatan_cp'] : '-') }}
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.12</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Email/Nomor Telepon/Fax/Ponsel Contact Person </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th style="width: 20%;"></th>
                            <th style="width: 78%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Email</td>
                            <td>
                                {{ (isset($profil_usaha['email_cp']) ? $profil_usaha['email_cp'] : '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>
                                {{ (isset($profil_usaha['telepon_cp']) ? $profil_usaha['telepon_cp'] : '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Fax</td>
                            <td>
                                {{ (isset($profil_usaha['fax_cp']) ? $profil_usaha['fax_cp'] : '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Ponsel</td>
                            <td>
                                {{ (isset($profil_usaha['ponsel_cp']) ? $profil_usaha['ponsel_cp'] : '-') }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.13</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Modal Usaha </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    {{ (isset($profil_usaha['modal_usaha']) ? $profil_usaha['modal_usaha'] : '-') }}
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.14</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Jumlah Tenaga Kerja</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Laki-laki : {{ (isset($profil_usaha['jumlah_tenaga_kerja_laki_laki']) ? $profil_usaha['jumlah_tenaga_kerja_laki_laki'] : '-') }}
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Perempuan : {{ (isset($profil_usaha['jumlah_tenaga_kerja_perempuan']) ? $profil_usaha['jumlah_tenaga_kerja_perempuan'] : '-') }}
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.15</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Keanggotaan Asosiasi</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    {{ (isset($profil_usaha['keanggotaan_asosiasi']) ? $profil_usaha['keanggotaan_asosiasi'] : '-') }}
                </td>
            </tr>
            <tr class="row">
                @php
                    $dokumentasi_profil_usaha_penghargaan    = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['penghargaan'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['penghargaan'] : []);
                @endphp
                <td class="col-md-1 col-sm-3 col-xs-3">1.16</td>
                <td class="col-md-3 col-sm-8 col-xs-8">
                    **Penghargaan <i>(Award)</i>
                </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row text-center text-lg-left">
                        @foreach($dokumentasi_profil_usaha_penghargaan as $penghargaan)
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="{{ asset($penghargaan['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($penghargaan['file'])) }}">
                                    <img class="img-fluid img-thumbnail" src="{{ view_asset($penghargaan['file']) }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </td>
            </tr>
            <tr class="row">
                @php
                    $dokumentasi_profil_usaha_sertifikasi_mutu    = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['mutu'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['mutu'] : ['file'=>'']);
                    $dokumentasi_profil_usaha_sertifikasi_halal  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['halal'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['halal'] : ['file'=>'']);
                    $dokumentasi_profil_usaha_sertifikasi_lainya  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['lainya'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['lainya'] : []);
                @endphp
                <td class="col-md-1 col-sm-3 col-xs-3">1.17</td>
                <td class="col-md-3 col-sm-8 col-xs-8">**Sertifikasi (mutu, halal, dst.)</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            (a) Mutu
                        </div>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            @if (!empty($dokumentasi_profil_usaha_sertifikasi_mutu['file']))
                                <div class="row text-center text-lg-left">
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <a href="{{ asset($dokumentasi_profil_usaha_sertifikasi_mutu['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($dokumentasi_profil_usaha_sertifikasi_mutu['file'])) }}">
                                            <img class="img-fluid img-thumbnail" src="{{ view_asset($dokumentasi_profil_usaha_sertifikasi_mutu['file']) }}">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            (b) Halal
                        </div>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            @if(!empty($dokumentasi_profil_usaha_sertifikasi_halal['file']))
                                <div class="row text-center text-lg-left">
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <a href="{{ asset($dokumentasi_profil_usaha_sertifikasi_halal['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($dokumentasi_profil_usaha_sertifikasi_halal['file'])) }}">
                                            <img class="img-fluid img-thumbnail" src="{{ view_asset($dokumentasi_profil_usaha_sertifikasi_halal['file']) }}">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            (c) Lainnya
                        </div>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            <div class="row text-center text-lg-left">
                                @foreach($dokumentasi_profil_usaha_sertifikasi_lainya as $lainya)
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <a href="{{ asset($lainya['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($lainya['file'])) }}">
                                            <img class="img-fluid img-thumbnail" src="{{ view_asset($lainya['file']) }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                @php
                    $dokumentasi_profil_usaha_legalitas_siup    = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['siup'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['siup'] : ['file'=>'']);
                    $dokumentasi_profil_usaha_legalitas_tdp  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['tdp'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['tdp'] : ['file'=>'']);
                    $dokumentasi_profil_usaha_legalitas_npwp  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['npwp'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['npwp'] : ['file'=>'']);
                    $dokumentasi_profil_usaha_legalitas_nib  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['nib'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['nib'] : ['file'=>'']);
                    $dokumentasi_profil_usaha_legalitas_lainya  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['lainya'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['lainya'] : []);
                @endphp
                <td class="col-md-1 col-sm-3 col-xs-3">1.18</td>
                <td class="col-md-3 col-sm-8 col-xs-8">**Legalitas (NPWP, TDP, SIUP, NIB, dll.)</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            (a) SIUP
                        </div>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            @if(!empty($dokumentasi_profil_usaha_legalitas_siup['file']))
                                <div class="row text-center text-lg-left">
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <a href="{{ asset($dokumentasi_profil_usaha_legalitas_siup['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($dokumentasi_profil_usaha_legalitas_siup['file'])) }}">
                                            <img class="img-fluid img-thumbnail" src="{{ view_asset($dokumentasi_profil_usaha_legalitas_siup['file']) }}">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            (b) TDP
                        </div>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            @if(!empty($dokumentasi_profil_usaha_legalitas_tdp['file']))
                                <div class="row text-center text-lg-left">
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <a href="{{ asset($dokumentasi_profil_usaha_legalitas_tdp['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($dokumentasi_profil_usaha_legalitas_tdp['file'])) }}">
                                            <img class="img-fluid img-thumbnail" src="{{ view_asset($dokumentasi_profil_usaha_legalitas_tdp['file']) }}">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            (c) NPWP
                        </div>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            @if(!empty($dokumentasi_profil_usaha_legalitas_npwp['file']))
                                <div class="row text-center text-lg-left">
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <a href="{{ asset($dokumentasi_profil_usaha_legalitas_npwp['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($dokumentasi_profil_usaha_legalitas_npwp['file'])) }}">
                                            <img class="img-fluid img-thumbnail" src="{{ view_asset($dokumentasi_profil_usaha_legalitas_npwp['file']) }}">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            (d) NIB
                        </div>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            @if(!empty($dokumentasi_profil_usaha_legalitas_nib['file']))
                                <div class="row text-center text-lg-left">
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <a href="{{ asset($dokumentasi_profil_usaha_legalitas_nib['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($dokumentasi_profil_usaha_legalitas_nib['file'])) }}">
                                            <img class="img-fluid img-thumbnail" src="{{ view_asset($dokumentasi_profil_usaha_legalitas_nib['file']) }}">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            (e) Lainnya
                        </div>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            <div class="row text-center text-lg-left">
                                @foreach($dokumentasi_profil_usaha_legalitas_lainya as $lainya)
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <a href="{{ asset($lainya['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($lainya['file'])) }}">
                                            <img class="img-fluid img-thumbnail" src="{{ view_asset($lainya['file']) }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <p class="text-justify">Catatan: **) Mohon sampaikan kepada surveyor kami dokumen-dokumen tersebut untuk didokumentasikan melalui media digital.</p>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</div>
