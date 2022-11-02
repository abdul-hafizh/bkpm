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
                <td class="col-md-3 col-sm-8 col-xs-8">Nama Usaha <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" name="data[profil_usaha][nama_usaha]" value="{{ (isset($profil_usaha['nama_usaha'])&&!empty($profil_usaha['nama_usaha']) ? $profil_usaha['nama_usaha'] : $survey->umkm->name) }}" placeholder="Nama Usaha" class="form-control form-control-sm">
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
                        <div class="col-md-12 col-sm-12 col-xs-12 profil_usaha_bentuk_badan_hukum_lainnya d-none">
                            <input type="text" name="data[profil_usaha][bentuk_badan_hukum_lainnya]" value="{{ (isset($profil_usaha['bentuk_badan_hukum_lainnya'])?$profil_usaha['bentuk_badan_hukum_lainnya']:'') }}" placeholder="Sebutkan" class="form-control form-control-sm">
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.3</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Bidang Usaha <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <textarea name="data[profil_usaha][bidang_usaha]" placeholder="Bidang Usaha" rows="2" class="form-control form-control-sm">{!! nl2br(isset($profil_usaha['bidang_usaha']) ? $profil_usaha['bidang_usaha'] : '') !!}</textarea>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.4</td>
                <td class="col-md-3 col-sm-8 col-xs-8">NIB (Nomor Induk Berusaha)</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input type="text" name="data[profil_usaha][kepemilikan_nib_nomor]" value="{{ (isset($profil_usaha['kepemilikan_nib_nomor'])&&!empty($profil_usaha['kepemilikan_nib_nomor']) ? $profil_usaha['kepemilikan_nib_nomor'] : $survey->umkm->nib) }}" placeholder="Nomor NIB" class="form-control form-control-sm numberonly">
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
                            <select id="code_kbli" name="data[profil_usaha][kbli][]" class="form-control select2InitKBLI" data-action="{{ route("{$bkpmumkm_identifier}.json_kbli") }}" multiple>
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @php
                                    if (isset($profil_usaha['kbli'])&&$profil_usaha['kbli']){
                                        $kblis = \Plugins\BkpmUmkm\Models\KbliModel::whereIn('code', $profil_usaha['kbli'])->get();
                                    }else{
                                        $survey->umkm->sync_kbli_single_to_multiple();
                                        $kblis = $survey->umkm->kbli_multiple;
                                    }
                                @endphp
                                @if ( $kblis )
                                    @foreach($kblis as $kbli)
                                        <option value="{{ $kbli->code }}" selected>[{{ $kbli->code }}] {{ $kbli->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.6</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Alamat Usaha <strong class="text-danger">**</strong></td>
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
                            <td>Alamat <strong class="text-danger">**</strong></td>
                            <td>
                                <textarea name="data[profil_usaha][alamat]" placeholder="Alamat" rows="3" class="form-control form-control-sm">{!! nl2br( (isset($profil_usaha['alamat'])&&!empty($profil_usaha['alamat']) ? $profil_usaha['alamat'] : $survey->umkm->address) ) !!}</textarea>
                            </td>
                        </tr>
                        <tr>
                            @php
                                $profil_usaha_negara    = (isset($profil_usaha['negara'])&&!empty($profil_usaha['negara']) ? $profil_usaha['negara'] : $survey->umkm->id_negara);
                                $profil_usaha_provinsi  = (isset($profil_usaha['provinsi'])&&!empty($profil_usaha['provinsi']) ? $profil_usaha['provinsi'] : $survey->umkm->id_provinsi);
                                $profil_usaha_kabupaten = (isset($profil_usaha['kabupaten'])&&!empty($profil_usaha['kabupaten']) ? $profil_usaha['kabupaten'] : $survey->umkm->id_kabupaten);
                                $profil_usaha_kecamatan = (isset($profil_usaha['kecamatan'])&&!empty($profil_usaha['kecamatan']) ? $profil_usaha['kecamatan'] : $survey->umkm->id_kecamatan);
                                $profil_usaha_desa      = (isset($profil_usaha['desa'])&&!empty($profil_usaha['desa']) ? $profil_usaha['desa'] : $survey->umkm->id_desa);
                            @endphp
                            <td>Negara <strong class="text-danger">**</strong> </td>
                            <td>
                                <select id="data_profil_usaha_negara" class="form-control select2InitB4 selectWilayah wilayah_negara" data-wilayah-off="profil_usaha" name="data[profil_usaha][negara]" data-value='{"selected":"{{ $profil_usaha_provinsi }}","to":"provinsi"}' required>
                                    <option value="">-Pilih-</option>
                                    @foreach($negara as $ngr)
                                        <option value="{{ $ngr->kode_negara }}" {{ ($profil_usaha_negara == $ngr->kode_negara ? 'selected':'') }}>{{ $ngr->nama_negara }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Provinsi <strong class="text-danger">**</strong> </td>
                            <td>
                                <select id="data_profil_usaha_provinsi" class="form-control select2InitB4 selectWilayah wilayah_provinsi" data-wilayah-off="profil_usaha" name="data[profil_usaha][provinsi]" data-value='{"selected":"{{ $profil_usaha_kabupaten }}","to":"kabupaten"}' required>
                                    <option value="">-Pilih-</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Kabupaten</td>
                            <td>
                                <select id="data_profil_usaha_kabupaten" class="form-control select2InitB4 selectWilayah wilayah_kabupaten" data-wilayah-off="profil_usaha" name="data[profil_usaha][kabupaten]" data-value='{"selected":"{{ $profil_usaha_kecamatan }}","to":"kecamatan"}'>
                                    <option value="">-Pilih-</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>
                                <select id="data_profil_usaha_kecamatan" class="form-control select2InitB4 selectWilayah wilayah_kecamatan" data-wilayah-off="profil_usaha" name="data[profil_usaha][kecamatan]" data-value='{"selected":"{{ $profil_usaha_desa }}","to":"desa"}'>
                                    <option value="">-Pilih-</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Desa</td>
                            <td>
                                <select id="data_profil_usaha_desa" class="form-control select2InitB4 selectWilayah wilayah_desa" data-wilayah-off="profil_usaha" name="data[profil_usaha][desa]" data-value='{"selected":"","to":""}'>
                                    <option value="">-Pilih-</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Kode Pos</td>
                            <td>
                                <input type="text" name="data[profil_usaha][kode_pos]" value="{{ (isset($profil_usaha['kode_pos'])&&!empty($profil_usaha['kode_pos']) ? $profil_usaha['kode_pos'] : $survey->umkm->postal_code) }}" placeholder="Kode Pos" class="form-control form-control-sm">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.7</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Koordinat GPS Lokasi <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div id="boxOpenMap">
                        <div id="openMap" class="sizeOpenMap"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Longitude <strong class="text-danger">**</strong>
                            <input id="mapLng" type="text" name="data[profil_usaha][koordinat_gps_longitude]" value="{{ (isset($profil_usaha['koordinat_gps_longitude'])&&!empty($profil_usaha['koordinat_gps_longitude']) ? $profil_usaha['koordinat_gps_longitude'] : $survey->umkm->longitude) }}" placeholder="Longitude" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Latitude <strong class="text-danger">**</strong>
                            <input id="mapLat" type="text" name="data[profil_usaha][koordinat_gps_latitude]" value="{{ (isset($profil_usaha['koordinat_gps_latitude'])&&!empty($profil_usaha['koordinat_gps_latitude']) ? $profil_usaha['koordinat_gps_latitude'] : $survey->umkm->latitude) }}" placeholder="Latitude" class="form-control form-control-sm">
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.8</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Nomor Telepon/Fax/Ponsel Perusahaan <strong class="text-danger">**</strong></td>
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
                            <td>Telepon <strong class="text-danger">**</strong></td>
                            <td>
                                <input type="text" name="data[profil_usaha][telepon]" value="{{ (isset($profil_usaha['telepon'])&&!empty($profil_usaha['telepon']) ? $profil_usaha['telepon'] : $survey->umkm->telp) }}" placeholder="Telepon" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>Fax</td>
                            <td>
                                <input type="text" name="data[profil_usaha][fax]" value="{{ (isset($profil_usaha['fax'])&&!empty($profil_usaha['fax']) ? $profil_usaha['fax'] : $survey->umkm->fax) }}" placeholder="Fax" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>Ponsel <strong class="text-danger">**</strong></td>
                            <td>
                                <input type="text" name="data[profil_usaha][ponsel]" value="{{ (isset($profil_usaha['ponsel'])&&!empty($profil_usaha['ponsel']) ? $profil_usaha['ponsel'] : '') }}" placeholder="Ponsel" class="form-control form-control-sm">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.9</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Email Perusahaan <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <input type="email" name="data[profil_usaha][email]" value="{{ (isset($profil_usaha['email'])&&!empty($profil_usaha['email']) ? $profil_usaha['email'] : $survey->umkm->email) }}" placeholder="Email Perusahaan" class="form-control form-control-sm">
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
                                <input type="text" name="data[profil_usaha][website]" value="{{ (isset($profil_usaha['website']) ? $profil_usaha['website'] : '') }}" placeholder="Website" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>Facebook</td>
                            <td>
                                <input type="text" name="data[profil_usaha][facebook]" value="{{ (isset($profil_usaha['facebook']) ? $profil_usaha['facebook'] : '') }}" placeholder="Facebook" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>Instagram</td>
                            <td>
                                <input type="text" name="data[profil_usaha][instagram]" value="{{ (isset($profil_usaha['instagram']) ? $profil_usaha['instagram'] : '') }}" placeholder="Instagram" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>Twitter</td>
                            <td>
                                <input type="text" name="data[profil_usaha][twitter]" value="{{ (isset($profil_usaha['twitter']) ? $profil_usaha['twitter'] : '') }}" placeholder="Twitter" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>LinkedIn</td>
                            <td>
                                <input type="text" name="data[profil_usaha][linkedin]" value="{{ (isset($profil_usaha['linkedin']) ? $profil_usaha['linkedin'] : '') }}" placeholder="LinkedIn" class="form-control form-control-sm">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.11</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Nama Kontak Person <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">                    
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Nama
                            <input type="text" name="data[profil_usaha][nama_cp]" value="{{ (isset($profil_usaha['nama_cp'])&&!empty($profil_usaha['nama_cp']) ? $profil_usaha['nama_cp'] : $survey->umkm->name_pic) }}" placeholder="Nama Kontak Person" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Jabatan
                            <input type="text" name="data[profil_usaha][jabatan_cp]" value="{{ (isset($profil_usaha['jabatan_cp'])&&!empty($profil_usaha['jabatan_cp']) ? $profil_usaha['jabatan_cp'] : '') }}" placeholder="Jabatan Person" class="form-control form-control-sm">
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.12</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Email/Nomor Telepon/Fax/Ponsel Kontak Person <strong class="text-danger">**</strong></td>
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
                            <td>Email <strong class="text-danger">**</strong> </td>
                            <td>
                                <input type="email" name="data[profil_usaha][email_cp]" value="{{ (isset($profil_usaha['email_cp'])&&!empty($profil_usaha['email_cp']) ? $profil_usaha['email_cp'] : $survey->umkm->email_pic) }}" placeholder="Email" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>
                                <input type="text" name="data[profil_usaha][telepon_cp]" value="{{ (isset($profil_usaha['telepon_cp']) ? $profil_usaha['telepon_cp'] : '') }}" placeholder="Telepon" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>Fax</td>
                            <td>
                                <input type="text" name="data[profil_usaha][fax_cp]" value="{{ (isset($profil_usaha['fax_cp']) ? $profil_usaha['fax_cp'] : '') }}" placeholder="Fax" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>Ponsel <strong class="text-danger">**</strong></td>
                            <td>
                                <input type="text" name="data[profil_usaha][ponsel_cp]" value="{{ (isset($profil_usaha['ponsel_cp']) ? $profil_usaha['ponsel_cp'] : $survey->umkm->phone_pic) }}" placeholder="Ponsel" class="form-control form-control-sm">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.13</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Modal Usaha <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" name="data[profil_usaha][modal_usaha]" value="{{ (isset($profil_usaha['modal_usaha']) ? $profil_usaha['modal_usaha'] : '') }}" placeholder="Modal Usaha" class="form-control form-control-sm nominal">
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.14</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Jumlah Tenaga Kerja</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Laki-laki
                            <input id="profil_usaha_jumlah_tenaga_kerja_laki_laki" type="text" name="data[profil_usaha][jumlah_tenaga_kerja_laki_laki]" value="{{ (isset($profil_usaha['jumlah_tenaga_kerja_laki_laki']) ? $profil_usaha['jumlah_tenaga_kerja_laki_laki'] : '') }}" placeholder="Laki-laki" class="form-control form-control-sm numberonly">
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Perempuan
                            <input id="profil_usaha_jumlah_tenaga_kerja_perempuan" type="text" name="data[profil_usaha][jumlah_tenaga_kerja_perempuan]" value="{{ (isset($profil_usaha['jumlah_tenaga_kerja_perempuan']) ? $profil_usaha['jumlah_tenaga_kerja_perempuan'] : '') }}" placeholder="Perempuan" class="form-control form-control-sm numberonly">
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.15</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Keanggotaan Asosiasi</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" name="data[profil_usaha][keanggotaan_asosiasi]" value="{{ (isset($profil_usaha['keanggotaan_asosiasi']) ? $profil_usaha['keanggotaan_asosiasi'] : '') }}" placeholder="Keanggotaan Asosiasi" class="form-control form-control-sm">
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
                    <div class="row">
                        <div class="myDropZone myDropZoneSingle col-12">
                            <input type="file" name="data[dokumentasi_profil_usaha][penghargaan_upload][]" data-named="data[dokumentasi_profil_usaha][penghargaan][][file]" data-index="data.dokumentasi_profil_usaha.penghargaan" multiple>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row myDropZoneView">
                                @foreach($dokumentasi_profil_usaha_penghargaan as $penghargaan)
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <input type="hidden" name="data[dokumentasi_profil_usaha][penghargaan][][file]" value="{{ $penghargaan['file'] }}">
                                        <div class="mdz-image">
                                            <img src="{{ view_asset($penghargaan['file']) }}" class="img-thumbnail"/>
                                        </div>
                                        <div class="mdz-footer text-right">
                                            <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$penghargaan['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                </td>
            </tr>
            <tr class="row">
                @php
                    $dokumentasi_profil_usaha_sertifikasi_mutu    = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['mutu'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['mutu'] : ['label'=>'','file'=>'']);
                    $dokumentasi_profil_usaha_sertifikasi_halal  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['halal'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['halal'] : ['label'=>'','file'=>'']);
                    $dokumentasi_profil_usaha_sertifikasi_lainya  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['lainya'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['sertifikasi']['lainya'] : []);
                @endphp
                <td class="col-md-1 col-sm-3 col-xs-3">1.17</td>
                <td class="col-md-3 col-sm-8 col-xs-8">**Sertifikasi (mutu, halal, dst.)</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row mb-4">
                        <div class="col-12">(a) Mutu</div>
                        <div class="myDropZone myDropZoneSingle col-12">
                            <input type="file" name="data[dokumentasi_profil_usaha][sertifikasi][mutu_upload][file]" data-named="data[dokumentasi_profil_usaha][sertifikasi][mutu][file]" data-index="data.dokumentasi_profil_usaha.sertifikasi.mutu.file">
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row myDropZoneView">
                                @if (isset($dokumentasi_profil_usaha_sertifikasi_mutu['file'])&&$dokumentasi_profil_usaha_sertifikasi_mutu['file'])
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <input type="hidden" name="data[dokumentasi_profil_usaha][sertifikasi][mutu][file]" value="{{ $dokumentasi_profil_usaha_sertifikasi_mutu['file'] }}">
                                        <div class="mdz-image">
                                            <img src="{{ view_asset($dokumentasi_profil_usaha_sertifikasi_mutu['file']) }}" class="img-thumbnail"/>
                                        </div>
                                        <div class="mdz-footer text-right">
                                            <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$dokumentasi_profil_usaha_sertifikasi_mutu['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-12">(b) Halal</div>
                        <div class="myDropZone myDropZoneSingle col-12">
                            <input type="file" name="data[dokumentasi_profil_usaha][sertifikasi][halal_upload][file]" data-named="data[dokumentasi_profil_usaha][sertifikasi][halal][file]" data-index="data.dokumentasi_profil_usaha.sertifikasi.halal.file">
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row myDropZoneView">
                                @if (isset($dokumentasi_profil_usaha_sertifikasi_halal['file'])&&$dokumentasi_profil_usaha_sertifikasi_halal['file'])
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <input type="hidden" name="data[dokumentasi_profil_usaha][sertifikasi][halal_upload][file]" value="{{ $dokumentasi_profil_usaha_sertifikasi_halal['file'] }}">
                                        <div class="mdz-image">
                                            <img src="{{ view_asset($dokumentasi_profil_usaha_sertifikasi_halal['file']) }}" class="img-thumbnail"/>
                                        </div>
                                        <div class="mdz-footer text-right">
                                            <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$dokumentasi_profil_usaha_sertifikasi_halal['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row mb-4">
                        <div class="col-12">(c) Lainnya</div>
                        <div class="myDropZone myDropZoneSingle col-12">
                            <input type="file" name="data[dokumentasi_profil_usaha][sertifikasi][lainya_upload][]" data-named="data[dokumentasi_profil_usaha][sertifikasi][lainya][][file]" data-index="data.dokumentasi_profil_usaha.sertifikasi.lainya"  multiple>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row myDropZoneView">
                                @foreach($dokumentasi_profil_usaha_sertifikasi_lainya as $lainya)
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <input type="hidden" name="data[dokumentasi_profil_usaha][sertifikasi][lainya][][file]" value="{{ $lainya['file'] }}">
                                        <div class="mdz-image">
                                            <img src="{{ view_asset($lainya['file']) }}" class="img-thumbnail"/>
                                        </div>
                                        <div class="mdz-footer text-right">
                                            <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$lainya['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                @php
                    $dokumentasi_profil_usaha_legalitas_siup    = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['siup'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['siup'] : ['label'=>'','file'=>'']);
                    $dokumentasi_profil_usaha_legalitas_tdp  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['tdp'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['tdp'] : ['label'=>'','file'=>'']);
                    $dokumentasi_profil_usaha_legalitas_npwp  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['npwp'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['npwp'] : ['label'=>'','file'=>'']);
                    $dokumentasi_profil_usaha_legalitas_nib  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['nib'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['nib'] : ['label'=>'','file'=>'']);
                    $dokumentasi_profil_usaha_legalitas_lainya  = ($survey->survey_result->data && (isset($survey->survey_result->data['dokumentasi_profil_usaha'])&&isset($survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['lainya'])) ? $survey->survey_result->data['dokumentasi_profil_usaha']['legalitas']['lainya'] : []);
                @endphp
                <td class="col-md-1 col-sm-3 col-xs-3">1.18</td>
                <td class="col-md-3 col-sm-8 col-xs-8">**Legalitas (NPWP, TDP, SIUP, NIB, dll.)</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row mb-4">
                        <div class="col-12">(a) SIUP</div>
                        <div class="myDropZone myDropZoneSingle col-12">
                            <input type="file" name="data[dokumentasi_profil_usaha][legalitas][siup_upload][file]" data-named="data[dokumentasi_profil_usaha][legalitas][siup][file]" data-index="data.dokumentasi_profil_usaha.legalitas.siup.file">
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row myDropZoneView">
                                @if ($dokumentasi_profil_usaha_legalitas_siup['file'])
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <input type="hidden" name="data[dokumentasi_profil_usaha][legalitas][siup][file]" value="{{ $dokumentasi_profil_usaha_legalitas_siup['file'] }}">
                                        <div class="mdz-image">
                                            <img src="{{ view_asset($dokumentasi_profil_usaha_legalitas_siup['file']) }}" class="img-thumbnail"/>
                                        </div>
                                        <div class="mdz-footer text-right">
                                            <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$dokumentasi_profil_usaha_legalitas_siup['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row mb-4">
                        <div class="col-12">(b) TDP</div>
                        <div class="myDropZone myDropZoneSingle col-12">
                            <input type="file" name="data[dokumentasi_profil_usaha][legalitas][tdp_upload][file]" data-named="data[dokumentasi_profil_usaha][legalitas][tdp][file]" data-index="data.dokumentasi_profil_usaha.legalitas.tdp.file">
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row myDropZoneView">
                                @if ($dokumentasi_profil_usaha_legalitas_tdp['file'])
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <input type="hidden" name="data[dokumentasi_profil_usaha][legalitas][tdp][file]" value="{{ $dokumentasi_profil_usaha_legalitas_tdp['file'] }}">
                                        <div class="mdz-image">
                                            <img src="{{ view_asset($dokumentasi_profil_usaha_legalitas_tdp['file']) }}" class="img-thumbnail"/>
                                        </div>
                                        <div class="mdz-footer text-right">
                                            <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$dokumentasi_profil_usaha_legalitas_tdp['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row mb-4">
                        <div class="col-12">(c) NPWP</div>
                        <div class="myDropZone myDropZoneSingle col-12">
                            <input type="file" name="data[dokumentasi_profil_usaha][legalitas][npwp_upload][file]" data-named="data[dokumentasi_profil_usaha][legalitas][npwp][file]" data-index="data.dokumentasi_profil_usaha.legalitas.npwp.file">
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row myDropZoneView">
                                @if ($dokumentasi_profil_usaha_legalitas_npwp['file'])
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <input type="hidden" name="data[dokumentasi_profil_usaha][legalitas][npwp][file]" value="{{ $dokumentasi_profil_usaha_legalitas_npwp['file'] }}">
                                        <div class="mdz-image">
                                            <img src="{{ view_asset($dokumentasi_profil_usaha_legalitas_npwp['file']) }}" class="img-thumbnail"/>
                                        </div>
                                        <div class="mdz-footer text-right">
                                            <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$dokumentasi_profil_usaha_legalitas_npwp['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row mb-4">
                        <div class="col-12">(d) NIB</div>
                        <div class="myDropZone myDropZoneSingle col-12">
                            <input type="file" name="data[dokumentasi_profil_usaha][legalitas][nib_upload][file]" data-named="data[dokumentasi_profil_usaha][legalitas][nib][file]" data-index="data.dokumentasi_profil_usaha.legalitas.nib.file">
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row myDropZoneView">
                                @if ($dokumentasi_profil_usaha_legalitas_nib['file'])
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <input type="hidden" name="data[dokumentasi_profil_usaha][legalitas][nib][file]" value="{{ $dokumentasi_profil_usaha_legalitas_nib['file'] }}">
                                        <div class="mdz-image">
                                            <img src="{{ view_asset($dokumentasi_profil_usaha_legalitas_nib['file']) }}" class="img-thumbnail"/>
                                        </div>
                                        <div class="mdz-footer text-right">
                                            <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$dokumentasi_profil_usaha_legalitas_nib['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row mb-4">
                        <div class="col-12">(e) Lainnya</div>
                        <div class="myDropZone myDropZoneSingle col-12">
                            <input type="file" name="data[dokumentasi_profil_usaha][legalitas][lainya_upload][]" data-named="data[dokumentasi_profil_usaha][legalitas][lainya][][file]" data-index="data.dokumentasi_profil_usaha.legalitas.lainya" multiple>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row myDropZoneView">
                                @foreach($dokumentasi_profil_usaha_legalitas_lainya as $lainya)
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <input type="hidden" name="data[dokumentasi_profil_usaha][legalitas][lainya][][file]" value="{{ view_asset($lainya['file']) }}">
                                        <div class="mdz-image">
                                            <img src="{{ view_asset($lainya['file']) }}" class="img-thumbnail"/>
                                        </div>
                                        <div class="mdz-footer text-right">
                                            <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$lainya['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                        </div>
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
