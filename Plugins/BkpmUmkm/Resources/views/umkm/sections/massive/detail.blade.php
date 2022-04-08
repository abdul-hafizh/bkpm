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
                    <label>{{ trans('label.nib_umkm') }}: </label>
                    <br/>
                    {{ $umkm->nib ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.sector_umkm') }}: </label>
                    <br/>
                    {{ ($umkm->sector ?? '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.code_kbli_umkm') }}: </label>
                    <br/>
                    {{ ($umkm->kbli ? "[{$umkm->kbli->code}] {$umkm->kbli->name}" : '-') }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>{{ trans('wilayah::label.country') }}: </label>
                    <br/>
                    {{ ($umkm->negara ? $umkm->negara->nama_negara : '-') }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.province') }}: </label>
                    <br/>
                    {{ $umkm->nama_provinsi ?: '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.city_district') }}: </label>
                    <br/>
                    {{ $umkm->nama_kabupaten ?: '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.sub_district') }}: </label>
                    <br/>
                    {{ $umkm->nama_kecamatan ?: '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('wilayah::label.village') }}: </label>
                    <br/>
                    {{ $umkm->nama_desa ?: '-' }}
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
                    <label>{{ trans('label.startup_capital') }}: </label>
                    <br/>
                    {{ number_format($umkm->startup_capital,0,",",".") ?? '-' }}
                </div>
                <div class="form-group">
                    <label>{{ trans('label.omset_every_year_umkm') }}: </label>
                    <br/>
                    {{ number_format($umkm->omset_every_year,0,",",".") ?? '-' }}
                </div>
            </div>
        </div>
    </div>
</div>
