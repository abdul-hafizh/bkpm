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
                $profil_usaha    = ($survey->survey_result->data && (isset($survey->survey_result->data['profil_usaha'])&&$survey->survey_result->data['profil_usaha']) ? $survey->survey_result->data['profil_usaha'] : '');
            @endphp
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.1</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Nama Usaha <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" name="data[profil_usaha][nama_usaha]" value="{{ (isset($profil_usaha['nama_usaha'])&&!empty($profil_usaha['nama_usaha']) ? $profil_usaha['nama_usaha'] : $survey->company->name) }}" placeholder="Nama Usaha" class="form-control form-control-sm">
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.2</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Bidang Usaha</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <textarea name="data[profil_usaha][bidang_usaha]" placeholder="Bidang Usaha" rows="2" class="form-control form-control-sm">{!! nl2br(isset($profil_usaha['bidang_usaha']) ? $profil_usaha['bidang_usaha'] : '') !!}</textarea>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.3</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Nilai Investasi <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <input type="text" name="data[profil_usaha][nilai_investasi]" value="{{ (isset($profil_usaha['nilai_investasi']) ? $profil_usaha['nilai_investasi'] : '') }}" placeholder="Nilai Investasi" class="form-control form-control-sm nominal">
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.4</td>
                <td class="col-md-3 col-sm-8 col-xs-8">NIB (Nomor Induk Berusaha)</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input type="text" name="data[profil_usaha][kepemilikan_nib_nomor]" value="{{ (isset($profil_usaha['kepemilikan_nib_nomor'])&&!empty($profil_usaha['kepemilikan_nib_nomor']) ? $profil_usaha['kepemilikan_nib_nomor'] : $survey->company->nib) }}" placeholder="Nomor NIB" class="form-control form-control-sm numberonly">
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
                                        $survey->company->sync_kbli_single_to_multiple();
                                        $kblis = $survey->company->kbli_multiple;
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
                <td class="col-md-3 col-sm-8 col-xs-8">Produk / Jasa</td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <textarea name="data[profil_usaha][produk_jasa]" placeholder="Produk / Jasa" rows="2" class="form-control form-control-sm">{!! nl2br(isset($profil_usaha['produk_jasa']) ? $profil_usaha['produk_jasa'] : '') !!}</textarea>
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
                    <div class="row">
                        <div class="myDropZone myDropZoneSingle col-12">
                            <input type="file" name="data[profil_usaha][flow_chart_proses_produksi_upload][]" data-named="data[profil_usaha][flow_chart_proses_produksi][][file]" data-index="data.profil_usaha.flow_chart_proses_produksi" multiple>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row myDropZoneView">
                                @foreach($flow_chart_proses_produksi as $fcpp)
                                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                                        <input type="hidden" name="data[profil_usaha][flow_chart_proses_produksi][][file]" value="{{ $fcpp['file'] }}">
                                        <div class="mdz-image">
                                            <img src="{{ view_asset($fcpp['file']) }}" class="img-thumbnail"/>
                                        </div>
                                        <div class="mdz-footer text-right">
                                            <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$fcpp['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.8</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Alamat Kantor Pusat <strong class="text-danger">**</strong></td>
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
                                <textarea name="data[profil_usaha][alamat]" placeholder="Alamat" rows="3" class="form-control form-control-sm">{!! nl2br( (isset($profil_usaha['alamat'])&&!empty($profil_usaha['alamat']) ? $profil_usaha['alamat'] : $survey->company->address) ) !!}</textarea>
                            </td>
                        </tr>
                        <tr>
                            @php
                                $profil_usaha_negara    = (isset($profil_usaha['negara'])&&!empty($profil_usaha['negara']) ? $profil_usaha['negara'] : $survey->company->id_negara);
                                $profil_usaha_provinsi  = (isset($profil_usaha['provinsi'])&&!empty($profil_usaha['provinsi']) ? $profil_usaha['provinsi'] : $survey->company->id_provinsi);
                                $profil_usaha_kabupaten = (isset($profil_usaha['kabupaten'])&&!empty($profil_usaha['kabupaten']) ? $profil_usaha['kabupaten'] : $survey->company->id_kabupaten);
                                $profil_usaha_kecamatan = (isset($profil_usaha['kecamatan'])&&!empty($profil_usaha['kecamatan']) ? $profil_usaha['kecamatan'] : $survey->company->id_kecamatan);
                                $profil_usaha_desa      = (isset($profil_usaha['desa'])&&!empty($profil_usaha['desa']) ? $profil_usaha['desa'] : $survey->company->id_desa);
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
                                <input type="text" name="data[profil_usaha][kode_pos]" value="{{ (isset($profil_usaha['kode_pos'])&&!empty($profil_usaha['kode_pos']) ? $profil_usaha['kode_pos'] : $survey->company->postal_code) }}" placeholder="Kode Pos" class="form-control form-control-sm">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3"></td>
                <td class="col-md-3 col-sm-8 col-xs-8">Koordinat GPS Lokasi asd<strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div id="boxOpenMap">
                        <div id="openMap" class="sizeOpenMap"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Longitude <strong class="text-danger">**</strong>
                            <input id="mapLng" type="text" name="data[profil_usaha][koordinat_gps_longitude]" value="{{ (isset($profil_usaha['koordinat_gps_longitude'])&&!empty($profil_usaha['koordinat_gps_longitude']) ? $profil_usaha['koordinat_gps_longitude'] : $survey->company->longitude) }}" placeholder="Longitude" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Latitude <strong class="text-danger">**</strong>
                            <input id="mapLat" type="text" name="data[profil_usaha][koordinat_gps_latitude]" value="{{ (isset($profil_usaha['koordinat_gps_latitude'])&&!empty($profil_usaha['koordinat_gps_latitude']) ? $profil_usaha['koordinat_gps_latitude'] : $survey->company->latitude) }}" placeholder="Latitude" class="form-control form-control-sm">
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3"></td>
                <td class="col-md-3 col-sm-8 col-xs-8">Jumlah Kantor Cabang <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">                    
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">                            
                            <input type="number" min="0" max="999" name="data[profil_usaha][jumlah_kantor_cabang]" value="{{ (isset($profil_usaha['jumlah_kantor_cabang'])&&!empty($profil_usaha['jumlah_kantor_cabang']) ? $profil_usaha['jumlah_kantor_cabang'] : '-') }}" placeholder="Jumlah Kantor Cabang" class="form-control form-control-sm">
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.9</td>
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
                                <input type="text" name="data[profil_usaha][telepon]" value="{{ (isset($profil_usaha['telepon'])&&!empty($profil_usaha['telepon']) ? $profil_usaha['telepon'] : $survey->company->telp) }}" placeholder="Telepon" class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td>Fax</td>
                            <td>
                                <input type="text" name="data[profil_usaha][fax]" value="{{ (isset($profil_usaha['fax'])&&!empty($profil_usaha['fax']) ? $profil_usaha['fax'] : $survey->company->fax) }}" placeholder="Fax" class="form-control form-control-sm">
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
                <td class="col-md-1 col-sm-3 col-xs-3">1.10</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Email Perusahaan <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <input type="email" name="data[profil_usaha][email]" value="{{ (isset($profil_usaha['email'])&&!empty($profil_usaha['email']) ? $profil_usaha['email'] : $survey->company->email) }}" placeholder="Email Perusahaan" class="form-control form-control-sm">
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
                <td class="col-md-1 col-sm-3 col-xs-3">1.12</td>
                <td class="col-md-3 col-sm-8 col-xs-8">Nama Kontak Person <strong class="text-danger">**</strong></td>
                <td class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Nama
                            <input type="text" name="data[profil_usaha][nama_cp]" value="{{ (isset($profil_usaha['nama_cp'])&&!empty($profil_usaha['nama_cp']) ? $profil_usaha['nama_cp'] : $survey->company->name_pic) }}" placeholder="Nama Kontak Person" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Jabatan
                            <input type="text" name="data[profil_usaha][jabatan_cp]" value="{{ (isset($profil_usaha['jabatan_cp'])&&!empty($profil_usaha['jabatan_cp']) ? $profil_usaha['jabatan_cp'] : '') }}" placeholder="Jabatan Person" class="form-control form-control-sm">
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="row">
                <td class="col-md-1 col-sm-3 col-xs-3">1.13</td>
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
                                <input type="email" name="data[profil_usaha][email_cp]" value="{{ (isset($profil_usaha['email_cp'])&&!empty($profil_usaha['email_cp']) ? $profil_usaha['email_cp'] : $survey->company->email_pic) }}" placeholder="Email" class="form-control form-control-sm">
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
                                <input type="text" name="data[profil_usaha][ponsel_cp]" value="{{ (isset($profil_usaha['ponsel_cp']) ? $profil_usaha['ponsel_cp'] : $survey->company->phone_pic) }}" placeholder="Ponsel" class="form-control form-control-sm">
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
            </tbody>
        </table>

    </div>
</div>
