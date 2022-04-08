<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>{{ trans('label.name_umkm') }}: </label>
                    <br/>
                    {{ $umkm->name ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.code_umkm') }}: </label>
                    <br/>
                    {{ $umkm->code ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.npwp_umkm') }}: </label>
                    <br/>
                    {{ ($umkm->npwp ? mask_number($umkm->npwp, $auth_check) : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.type_umkm') }}: </label>
                    <br/>
                    {{ $umkm->type ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.sector_umkm') }}: </label>
                    <br/>
                    {{ ($umkm->sector ? $umkm->sector->name : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.code_kbli_umkm') }}: </label>
                    <br/>
                    @if($umkm->kbli)
                        <ul>
                        @foreach($umkm->kbli as $kbli)
                            <li>{{ "[{$kbli->code}] {$kbli->name}"}}</li>
                        @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </div>
                <div class="form-group">
                    <label>{{ trans('label.nib_umkm') }}: </label>
                    <br/>
                    {{ $umkm->nib ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.date_nib_umkm') }}: </label>
                    <br/>
                    {{ (!empty($umkm->date_nib) ? \Illuminate\Support\Carbon::parse($umkm->date_nib)->format('d-m-Y') : '-') }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>{{ trans('label.email_umkm') }}: </label>
                    <br/>
                    {{ ($umkm->email ? mask_email($umkm->email, $auth_check) : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.telp_umkm') }}: </label>
                    <br/>
                    {{ ($umkm->telp ? mask_number($umkm->telp, $auth_check) : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.fax_umkm') }}: </label>
                    <br/>
                    {{ ($umkm->fax ? mask_number($umkm->fax, $auth_check) : '-') }}
                </div>

                <div class="form-group">
                    <label>{{ trans('wilayah::label.country') }}: </label>
                    <br/>
                    {{ ($umkm->negara ? $umkm->negara->nama_negara : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.province') }}: </label>
                    <br/>
                    {{ ($umkm->provinsi ? $umkm->provinsi->nama_provinsi : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.city_district') }}: </label>
                    <br/>
                    {{ ($umkm->kabupaten ? $umkm->kabupaten->nama_kabupaten : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.sub_district') }}: </label>
                    <br/>
                    {{ ($umkm->kecamatan ? $umkm->kecamatan->nama_kecamatan : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.village') }}: </label>
                    <br/>
                    {{ ($umkm->desa ? $umkm->desa->nama_desa : '-') }}
                </div>

                <div class="form-group">
                    <label>{{ trans('label.address_umkm') }}: </label>
                    <br/>
                    {!! nl2br($umkm->address) ?? '-' !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.postal_code_umkm') }}: </label>
                    <br/>
                    {{ $umkm->postal_code ?? '-' }}
                </div>

            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('label.director_of_umkm') }}</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>{{ trans('label.name_director_of_umkm') }}: </label>
                    <br/>
                    {{ $umkm->name_director ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.email_director_of_umkm') }}: </label>
                    <br/>
                    {{ ($umkm->email_director ? mask_email($umkm->email_director, $auth_check) : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.phone_director_of_umkm') }}: </label>
                    <br/>
                    {{ ($umkm->phone_director ? mask_number($umkm->phone_director, $auth_check) : '-') }}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('label.pic_of_umkm') }}</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>{{ trans('label.name_pic_of_umkm') }}: </label>
                    <br/>
                    {{ $umkm->name_pic ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.email_pic_of_umkm') }}: </label>
                    <br/>
                    {{ ($umkm->email_pic ? mask_email($umkm->email_pic, $auth_check) : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.phone_pic_of_umkm') }}: </label>
                    <br/>
                    {{ ( $umkm->phone_pic ? mask_number($umkm->phone_pic, $auth_check) : '-') }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ trans('label.infrastructure_umkm') }}: </label>
                            {!! shortcodes($umkm->infrastructure) ?? '<br/>-' !!}
                        </div>
                        <div class="form-group">
                            <label>{{ trans('label.about_umkm') }}: </label>
                            {!! shortcodes($umkm->about) ?? '<br/>-' !!}
                        </div>
                        <div class="form-group">
                            <label>{{ trans('label.map_location_umkm') }}: </label>
                            @if ($umkm->latitude && $umkm->longitude)
                                <div id="boxOpenMap">
                                    <div id="openMap" class="sizeOpenMap openMapView" data-latitude="{{ $umkm->latitude }}" data-longitude="{{ $umkm->longitude }}"></div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ trans('label.total_employees_umkm') }}: </label>
                            <br/>
                            {{ number_format($umkm->total_employees,0,",",".") ?? '-' }}
                        </div>

                        <div class="form-group">
                            <label>{{ trans('label.net_worth_umkm') }}: </label>
                            <br/>
                            {{ number_format($umkm->net_worth,0,",",".") ?? '-' }}
                        </div>
                        <div class="form-group">
                            <label>{{ trans('label.omset_every_year_umkm') }}: </label>
                            <br/>
                            {{ number_format($umkm->omset_every_year,0,",",".") ?? '-' }}
                        </div>
                        <div class="form-group">
                            <label>{{ trans('label.estimated_venture_capital_umkm') }}: </label>
                            <br/>
                            {{ number_format($umkm->estimated_venture_capital,0,",",".") ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
