<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>{{ trans('label.name_company') }}: </label>
                    <br/>
                    {{ $company->name ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.code_company') }}: </label>
                    <br/>
                    {{ $company->code ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.npwp_company') }}: </label>
                    <br/>
                    {{ ($company->npwp ? mask_number($company->npwp, $auth_check) : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.type_company') }}: </label>
                    <br/>
                    {{ $company->type ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.sector_company') }}: </label>
                    <br/>
                    {{ ($company->sector ? $company->sector->name : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.code_kbli_company') }}: </label>
                    <br/>
                    @if($company->kbli)
                        <ul>
                            @foreach($company->kbli as $kbli)
                                <li>{{ "[{$kbli->code}] {$kbli->name}"}}</li>
                            @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </div>
                <div class="form-group">
                    <label>{{ trans('label.regional_directorate_company') }}: </label>
                    <br/>
                    {{ $company->directorate ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.pmdn_pma_company') }}: </label>
                    <br/>
                    {{ $company->pmdn_pma ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.nib_company') }}: </label>
                    <br/>
                    {{ $company->nib ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.date_nib_company') }}: </label>
                    <br/>
                    {{ (!empty($company->date_nib) ? \Illuminate\Support\Carbon::parse($company->date_nib)->format('d-m-Y') : '-') }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>{{ trans('label.email_company') }}: </label>
                    <br/>
                    {{ ($company->email ? mask_email($company->email, $auth_check) : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.telp_company') }}: </label>
                    <br/>
                    {{ ($company->telp ? mask_number($company->telp, $auth_check) : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.fax_company') }}: </label>
                    <br/>
                    {{ ($company->fax ? mask_number($company->fax, $auth_check) : '-') }}
                </div>

                <div class="form-group">
                    <label>{{ trans('wilayah::label.country') }}: </label>
                    <br/>
                    {{ ($company->negara ? $company->negara->nama_negara : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.province') }}: </label>
                    <br/>
                    {{ ($company->provinsi ? $company->provinsi->nama_provinsi : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.city_district') }}: </label>
                    <br/>
                    {{ ($company->kabupaten ? $company->kabupaten->nama_kabupaten : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.sub_district') }}: </label>
                    <br/>
                    {{ ($company->kecamatan ? $company->kecamatan->nama_kecamatan : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.village') }}: </label>
                    <br/>
                    {{ ($company->desa ? $company->desa->nama_desa : '-') }}
                </div>

                <div class="form-group">
                    <label>{{ trans('label.address_company') }}: </label>
                    <br/>
                    {!! nl2br($company->address) ?? '-' !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.postal_code_company') }}: </label>
                    <br/>
                    {{ $company->postal_code ?? '-' }}
                </div>

            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('label.director_of_company') }}</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>{{ trans('label.name_director_of_company') }}: </label>
                    <br/>
                    {{ $company->name_director ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.email_director_of_company') }}: </label>
                    <br/>
                    {{ ($company->email_director ? mask_email($company->email_director, $auth_check) : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.phone_director_of_company') }}: </label>
                    <br/>
                    {{ ($company->phone_director ? mask_number($company->phone_director, $auth_check) : '-') }}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('label.pic_of_company') }}</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>{{ trans('label.name_pic_of_company') }}: </label>
                    <br/>
                    {{ $company->name_pic ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.email_pic_of_company') }}: </label>
                    <br/>
                    {{ ($company->email_pic ? mask_email($company->email_pic, $auth_check) : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.phone_pic_of_company') }}: </label>
                    <br/>
                    {{ ( $company->phone_pic ? mask_number($company->phone_pic, $auth_check) : '-') }}
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Logo: </label>
                    <br/>
                    @if(!empty($company->logo))
                        <img src="{{ $company->logo }}" alt="{{ $company->name }}" class="img-responsive" style="max-width: 100%;">
                    @else
                        -
                    @endif
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
                            <label>{{ trans('label.about_company') }}: </label>
                            {!! shortcodes($company->about) ?? '<br/>-' !!}
                        </div>
                        <div class="form-group">
                            <label>{{ trans('label.map_location_company') }}: </label>
                            @if ($company->latitude && $company->longitude)
                                <div id="boxOpenMap">
                                    <div id="openMap" class="sizeOpenMap openMapView" data-latitude="{{ $company->latitude }}" data-longitude="{{ $company->longitude }}"></div>
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
                            <label>{{ trans('label.total_employees_company') }}: </label>
                            <br/>
                            {{ number_format($company->total_employees,0,",",".") ?? '-' }}
                        </div>
                        <div class="form-group">
                            <label>{{ trans('label.investment_plan_company') }}: </label>
                            <br/>
                            {{ number_format($company->investment_plan,0,",",".") ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
