@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_select2('css') !!}
    {!! library_leaflet('css') !!}
    {!! library_datepicker('css') !!}
@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <a id="btnKembali" class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.potensial.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                @if($umkm->id != '')
                    <a class="btn btn-primary btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.potensial.add") }}" title="{{ trans('label.add_new_umkm_potensial') }}"><i class="fa fa-plus"></i> {{ trans('label.add_new_umkm_potensial') }}</a>
                @endif
            </div>
        </div>

        <form id="formAddEditUmkm" class="row" data-action="{{ route("{$bkpmumkm_identifier}.backend.umkm.potensial.save_update") }}">
            <input type="hidden" name="id" value="{{ encrypt_decrypt($umkm->id) }}">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ trans('label.name_umkm') }} <i class="text-danger">*</i></label>
                            <input id="name" name="name" type="text" value="{{ $umkm->name }}" class="form-control" placeholder="{{ trans('label.name_umkm') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="code">{{ trans('label.code_umkm') }} </label>
                            <input id="code" name="code" type="text" value="{{ $umkm->code }}" class="form-control" placeholder="{{ trans('label.code_umkm') }}">
                        </div>
                        <div class="form-group">
                            <label for="npwp">{{ trans('label.npwp_umkm') }} </label>
                            <input id="npwp" name="npwp" type="text" value="{{ $umkm->npwp }}" class="form-control" placeholder="{{ trans('label.npwp_umkm') }}">
                        </div>
                        <div class="form-group">
                            <label for="nib">{{ trans('label.nib_umkm') }} </label>
                            <input id="nib" name="nib" type="text" value="{{ $umkm->nib }}" class="form-control" placeholder="{{ trans('label.nib_umkm') }}">
                        </div>
                        <div class="form-group">
                            <label for="date_nib">{{ trans('label.date_nib_umkm') }} </label>
                            <input id="date_nib" name="date_nib" type="text" value="{{ (!empty($umkm->date_nib) ? \Illuminate\Support\Carbon::parse($umkm->date_nib)->format('d-m-Y') : '') }}" class="form-control datepickerInit" placeholder="{{ trans('label.date_nib_umkm') }}" autocomplete="nope">
                        </div>
                        <div class="form-group">
                            <label for="type">{{ trans('label.type_umkm') }} </label>
                            <input id="type" name="type" type="text" value="{{ $umkm->type }}" data-action="{{ route("{$bkpmumkm_identifier}.json_type_jenis_company") }}" class="form-control" placeholder="{{ trans('label.type_umkm') }}" >
                        </div>
                        <div class="form-group">
                            <label for="business_sector_id">{{ trans('label.sector_umkm') }} </label>
                            <select id="business_sector_id" name="business_sector_id" class="form-control select2InitBusinessSector" data-action="{{ route("{$bkpmumkm_identifier}.json_sector") }}">
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @if ($umkm->sector)
                                    <option value="{{ $umkm->business_sector_id }}" selected>{{ $umkm->sector->name }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="code_kbli">{{ trans('label.code_kbli_umkm') }} <i class="text-danger">*</i></label>
                            <select id="code_kbli" name="code_kbli[]" class="form-control select2InitKBLI" data-action="{{ route("{$bkpmumkm_identifier}.json_kbli") }}" multiple required>
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @if ($umkm->kbli)
                                    @foreach($umkm->kbli as $kbli)
                                        <option value="{{ $kbli->code }}" selected>[{{ $kbli->code }}] {{ $kbli->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">{{ trans('label.email_umkm') }} <i class="text-danger">*</i></label>
                            <input id="email" name="email" type="email" value="{{ $umkm->email }}" class="form-control" placeholder="{{ trans('label.email_umkm') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="telp">{{ trans('label.telp_umkm') }} </label>
                            <input id="telp" name="telp" type="text" value="{{ $umkm->telp }}" placeholder="{{ trans('label.telp_umkm') }}" class="form-control numberonly">
                        </div>
                        <div class="form-group">
                            <label for="fax">{{ trans('label.fax_umkm') }} </label>
                            <input id="fax" name="fax" type="text" value="{{ $umkm->fax }}" class="form-control numberonly" placeholder="{{ trans('label.fax_umkm') }}">
                        </div>

                        {!! template_wilayah_negara(
                                $umkm->id_negara,
                                $umkm->id_provinsi,
                                $umkm->id_kabupaten,
                                $umkm->id_kecamatan,
                                $umkm->id_desa
                            )
                        !!}

                        <div class="form-group">
                            <label for="address">{{ trans('label.address_umkm') }} </label>
                            <textarea id="address" name="address" class="form-control" placeholder="{{ trans('label.address_umkm') }}">{!! nl2br($umkm->address) !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="postal_code">{{ trans('label.postal_code_umkm') }} </label>
                            <input id="postal_code" name="postal_code" type="text" value="{{ $umkm->postal_code }}" placeholder="{{ trans('label.postal_code_umkm') }}" class="form-control numberonly">
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
                            <label for="name_director">{{ trans('label.name_director_of_umkm') }} <i class="text-danger">*</i></label>
                            <input id="name_director" name="name_director" type="text" value="{{ $umkm->name_director }}" placeholder="{{ trans('label.name_director_of_umkm') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email_director">{{ trans('label.email_director_of_umkm') }} </label>
                            <input id="email_director" name="email_director_of_umkm" type="email" value="{{ $umkm->email_director }}" placeholder="{{ trans('label.email_director_of_umkm') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phone_director">{{ trans('label.phone_director_of_umkm') }} </label>
                            <input id="phone_director" name="phone_director" type="text" value="{{ $umkm->phone_director }}" placeholder="{{ trans('label.phone_director_of_umkm') }}" class="form-control numberonly">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('label.pic_of_umkm') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name_pic">{{ trans('label.name_pic_of_umkm') }} <i class="text-danger">*</i></label>
                            <input id="name_pic" name="name_pic" type="text" value="{{ $umkm->name_pic }}" placeholder="{{ trans('label.name_pic_of_umkm') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email_pic">{{ trans('label.email_pic_of_umkm') }} <i class="text-danger">*</i></label>
                            <input id="email_pic" name="email_pic" type="email" value="{{ $umkm->email_pic }}" placeholder="{{ trans('label.email_pic_of_umkm') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_pic">{{ trans('label.phone_pic_of_umkm') }} <i class="text-danger">*</i></label>
                            <input id="phone_pic" name="phone_pic" type="text" value="{{ $umkm->phone_pic }}" placeholder="{{ trans('label.phone_pic_of_umkm') }}" class="form-control numberonly" required>
                        </div>

                        <input type="hidden" name="pic_id" value="{{ encrypt_decrypt(($umkm->pic->id??'')) }}">
                        @if (!$umkm->pic OR ($umkm->pic && !$umkm->pic->id))
                            <div class="form-group">
                                <label for="password_account_pic">{{ trans('core::label.password') }} <i class="text-danger">*</i></label>
                                <input id="password_account_pic" name="password" type="password" value="" placeholder="{{ trans('core::label.password') }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation_account_pic">{{ trans('core::label.password_confirmation') }} <i class="text-danger">*</i></label>
                                <input id="password_confirmation_account_pic" name="password_confirmation" type="password" value="" placeholder="{{ trans('core::label.password_confirmation') }}" class="form-control" required>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="infrastructure_umkm">{{ trans('label.infrastructure_umkm') }} </label>
                                    <textarea id="infrastructure_umkm" name="infrastructure" class="form-control infrastructure_umkm" placeholder="{{ trans('label.infrastructure_umkm') }}">{!! shortcodes($umkm->infrastructure) !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="about_umkm">{{ trans('label.about_umkm') }}</label>
                                    <textarea id="about_umkm" name="about" class="form-control about_umkm" placeholder="{{ trans('label.about_umkm') }}">{!! shortcodes($umkm->about) !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('label.map_location_umkm') }}</label>
                                    <div id="boxOpenMap">
                                        <div id="openMap" class="sizeOpenMap"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="mapLng">Longitude</label>
                                                <input id="mapLng" name="longitude" value="{{ $umkm->longitude }}" type="text" placeholder="Longitude" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="mapLat">Latitude</label>
                                                <input id="mapLat" name="latitude" value="{{ $umkm->latitude }}" type="text" placeholder="Latitude" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="total_employees">{{ trans('label.total_employees_umkm') }} </label>
                                    <input id="total_employees" name="total_employees" value="{{ $umkm->total_employees ?? 0 }}" type="text" placeholder="{{ trans('label.total_employees_umkm') }}" class="form-control numberonly">
                                </div>
                                <div class="form-group">
                                    <label for="net_worth_umkm">{{ trans('label.net_worth_umkm') }} </label>
                                    <input id="net_worth_umkm" name="net_worth" value="{{ number_format($umkm->net_worth) }}" type="text" placeholder="{{ trans('label.net_worth_umkm') }}" class="form-control nominal" >
                                </div>
                                <div class="form-group">
                                    <label for="omset_every_year_umkm">{{ trans('label.omset_every_year_umkm') }} </label>
                                    <input id="omset_every_year_umkm" name="omset_every_year" value="{{ number_format($umkm->omset_every_year) }}" type="text" placeholder="{{ trans('label.omset_every_year_umkm') }}" class="form-control nominal" >
                                </div>
                                <div class="form-group">
                                    <label for="estimated_venture_capital_umkm">{{ trans('label.estimated_venture_capital_umkm') }} </label>
                                    <input id="estimated_venture_capital_umkm" name="estimated_venture_capital" value="{{ number_format($umkm->estimated_venture_capital) }}" type="text" placeholder="{{ trans('label.estimated_venture_capital_umkm') }}" class="form-control nominal" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-sm" title="{{ trans('label.save') }}"><i class="fa fa-save"></i> {{ trans('label.save') }}</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@push('js_stack')

    {!! library_tinymce('js') !!}
    {!! library_select2('js') !!}
    {!! module_script('core','js/event-select2.js') !!}
    {!! filemanager_standalonepopup() !!}
    {!! library_leaflet('js') !!}
    {!! library_datepicker('js') !!}
    {!! plugins_script('bkpmumkm', 'js/event-company-umkm.js') !!}
    {!! plugins_script('bkpmumkm', 'umkm/backend/js/add-edit.js') !!}
@endpush
