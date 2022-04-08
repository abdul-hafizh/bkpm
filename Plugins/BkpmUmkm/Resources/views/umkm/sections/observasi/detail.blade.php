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
                    <label>{{ trans('label.name_director_of_umkm') }}: </label>
                    <br/>
                    {{ $umkm->name_director ?? '-' }}
                </div>
                <div class="form-group">
                    <label>Deskripsi Jenis Usaha: </label>
                    {!! shortcodes($umkm->about) ?? '<br/>-' !!}
                </div>
                {{-- <div class="form-group">
                    <label>{{ trans('label.surveyor') }}: </label>
                    <br/>
                    {{ ($umkm->surveyor_observasi ? $umkm->surveyor_observasi->name : '-') }}
                </div> --}}
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
</div>
