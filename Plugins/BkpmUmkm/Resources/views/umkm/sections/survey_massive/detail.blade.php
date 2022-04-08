{!! library_leaflet('css') !!}
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>{{ trans("label.index_umkm") }}:</label>
                            <br/>
                            @if ($umkm->id_umkm_massive)
                                {{ $umkm->umkm->name }} [{{ $umkm->umkm->nib }}{{ ($umkm->umkm->provinsi ? '|'.$umkm->umkm->provinsi->nama_provinsi :'') }}]
                            @else
                                {{ $umkm->name_umkm }} [{{ $umkm->nib_umkm }}{{ ($umkm->nama_provinsi_umkm ? '|'.$umkm->nama_provinsi_umkm :'') }}]
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>{{ trans("label.date_survey") }}: </label>
                            <br/>
                            {{ ($umkm->created_at ? carbonParseTransFormat($umkm->created_at, 'l, d F Y') : '-') }}
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>Provinsi UMKM: </label>
                            <br/>
                            {{ ($umkm->nama_provinsi_umkm ? $umkm->nama_provinsi_umkm : '-') }}
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>Kabupaten UMKM: </label>
                            <br/>
                            {{ ($umkm->nama_kabupaten_umkm ? $umkm->nama_kabupaten_umkm : '-') }}
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>Alamat UMKM: </label>
                            <br/>
                            {!! $umkm->address_umkm !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>{{ trans('label.map_location_umkm') }}:</label>

                            @if ($umkm->latitude && $umkm->longitude)
                                <div id="boxOpenMap">
                                    <div id="openMap" class="sizeOpenMap openMapView" data-latitude="{{ $umkm->latitude }}" data-longitude="{{ $umkm->longitude }}"></div>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Keterangan:</label>
                            {!! nl2br($umkm->keterangan) !!}
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>Foto Berita Acara:</label>

                            <div class="row text-center text-lg-left">
                                @if($umkm->foto_berita_acara)
                                    @foreach($umkm->foto_berita_acara as $fba)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <a href="{{ view_asset($fba, false) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox((is_base64($fba) ? $fba : asset($fba))) }}">
                                                <img class="img-fluid img-thumbnail" src="{{ view_asset($fba) }}">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Foto Legalitas Usaha:</label>

                            <div class="row text-center text-lg-left">
                                @if($umkm->foto_legalitas_usaha)
                                    @foreach($umkm->foto_legalitas_usaha as $flu)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <a href="{{ view_asset($flu, false) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox((is_base64($flu) ? $flu : asset($flu))) }}">
                                                <img class="img-fluid img-thumbnail" src="{{ view_asset($flu) }}">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Foto Tempat Usaha</label>

                            <div class="row text-center text-lg-left">
                                @if($umkm->foto_tempat_usaha)
                                    @foreach($umkm->foto_tempat_usaha as $ftu)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <a href="{{ view_asset($ftu, false) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox((is_base64($ftu) ? $ftu : asset($ftu))) }}">
                                                <img class="img-fluid img-thumbnail" src="{{ view_asset($ftu) }}">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Foto Produk</label>

                            <div class="row text-center text-lg-left">
                                @if($umkm->foto_produk)
                                    @foreach($umkm->foto_produk as $fp)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <a href="{{ view_asset($fp, false) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox((is_base64($fp) ? $fp : asset($fp))) }}">
                                                <img class="img-fluid img-thumbnail" src="{{ view_asset($fp) }}">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('label.surveyor') }}</h3>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label for="name_surveyor">{{ trans('label.name_surveyor') }}:</label>
                    <br/>
                    {{ $umkm->nama_surveyor }}
                </div>
                <div class="form-group">
                    <label for="phone_surveyor">{{ trans('label.phone_surveyor') }}:</label>
                    <br/>
                    {{ $umkm->phone_surveyor }}
                </div>

                <div class="form-group">
                    <label>{{ trans('wilayah::label.country') }}: </label>
                    <br/>
                    {{ ($umkm->negara ? $umkm->negara->nama_negara : ($umkm->nama_negara_surveyor ? $umkm->nama_negara_surveyor : '-') ) }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.province') }}: </label>
                    <br/>
                    {{ ($umkm->provinsi ? $umkm->provinsi->nama_provinsi : ($umkm->nama_provinsi_surveyor ? $umkm->nama_provinsi_surveyor : '-') ) }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.city_district') }}: </label>
                    <br/>
                    {{ ($umkm->kabupaten ? $umkm->kabupaten->nama_kabupaten : ($umkm->nama_kabupaten_surveyor ? $umkm->nama_kabupaten_surveyor : '-') ) }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.sub_district') }}: </label>
                    <br/>
                    {{ ($umkm->kecamatan ? $umkm->kecamatan->nama_kecamatan : ($umkm->nama_kecamatan_surveyor ? $umkm->nama_kecamatan_surveyor : '-') ) }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.village') }}: </label>
                    <br/>
                    {{ ($umkm->desa ? $umkm->desa->nama_desa : ($umkm->nama_desa_surveyor ? $umkm->nama_desa_surveyor : '-') ) }}
                </div>

                <div class="form-group">
                    <label for="address_surveyor">{{ trans('label.address_surveyor') }}: </label>
                    {!! nl2br($umkm->address_surveyor) !!}
                </div>

            </div>
        </div>
    </div>
</div>
{!! library_leaflet('js', true) !!}
