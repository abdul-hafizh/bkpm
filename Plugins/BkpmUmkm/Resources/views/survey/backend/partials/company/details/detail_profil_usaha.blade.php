<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">1. Profil Perusahaan</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">

        <table class="table table-sm row">
            <tbody class="col-12">
            @php
                $profil_usaha    = ($survey->survey_result && (isset($survey->survey_result->data)&&$survey->survey_result->data) && (isset($survey->survey_result->data['profil_usaha'])&&$survey->survey_result->data['profil_usaha']) ? $survey->survey_result->data['profil_usaha'] : '');
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
                <td class="col-md-3 col-sm-8 col-xs-8">Bidang Usaha</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    {!! nl2br(isset($profil_usaha['bidang_usaha']) ? $profil_usaha['bidang_usaha'] : '-') !!}
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.3</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Nilai Investasi </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    {{ (isset($profil_usaha['nilai_investasi']) ? $profil_usaha['nilai_investasi'] : '-') }}
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
                <td class="col-md-3 col-sm-8 col-xs-8">Produk / Jasa</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    {!! nl2br(isset($profil_usaha['produk_jasa']) ? $profil_usaha['produk_jasa'] : '-') !!}
                </td>
            </tr>
            <tr class="row">
                @php
                    $flow_chart_proses_produksi    = ( isset($profil_usaha['flow_chart_proses_produksi'])&&$profil_usaha['flow_chart_proses_produksi'] ? $profil_usaha['flow_chart_proses_produksi'] : []);
                @endphp
                <td class="col-md-1 col-sm-3 col-xs-3">1.7</td>
                <td class="col-md-3 col-sm-8 col-xs-8">
                    Flow Chart Proses Produksi
                </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row text-center text-lg-left">
                        @foreach($flow_chart_proses_produksi as $fcpp)
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="{{ asset($fcpp['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($fcpp['file'])) }}">
                                    <img class="img-fluid img-thumbnail" src="{{ view_asset($fcpp['file']) }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.8</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Alamat Kantor Pusat </td>
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
                <td class="col-md-1 col-sm-3 col-xs-3"></td>
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
                <td class="col-md-1 col-sm-3 col-xs-3">1.9</td>
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
                <td class="col-md-1 col-sm-3 col-xs-3">1.10</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Email Perusahaan </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    {{ (isset($profil_usaha['email']) ? $profil_usaha['email'] : '-') }}
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.11</td>
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
                <td class="col-md-1 col-sm-3 col-xs-3">1.12</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Nama Kontak Person </td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    {{ (isset($profil_usaha['nama_cp']) ? $profil_usaha['nama_cp'] : '-') }}
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.13</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Email/Nomor Telepon/Fax/Ponsel Kontak Person </td>
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
            </tbody>
        </table>

    </div>
</div>
