@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.company.index") }}" title="{{ trans('label.index_company') }}"> {{ trans('label.index_company') }}</a></li>
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
                <a id="btnKembali" class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.company.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                @if($company->id != '')
                    <a class="btn btn-primary btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.company.add") }}" title="{{ trans('label.add_new_company') }}"><i class="fa fa-plus"></i> {{ trans('label.add_new_company') }}</a>
                @endif
            </div>
        </div>

        <form id="formAddEditCompany" class="row" data-action="{{ route("{$bkpmumkm_identifier}.backend.company.save_update") }}">
            <input type="hidden" name="id" value="{{ encrypt_decrypt($company->id) }}">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ trans('label.name_company') }} <i class="text-danger">*</i></label>
                            <input id="name" name="name" type="text" value="{{ $company->name }}" class="form-control" placeholder="{{ trans('label.name_company') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="code">{{ trans('label.code_company') }} </label>
                            <input id="code" name="code" type="text" value="{{ $company->code }}" class="form-control" placeholder="{{ trans('label.code_company') }}">
                        </div>
                        <div class="form-group">
                            <label for="npwp">{{ trans('label.npwp_company') }} </label>
                            <input id="npwp" name="npwp" type="text" value="{{ $company->npwp }}" class="form-control" placeholder="{{ trans('label.npwp_company') }}">
                        </div>
                        <div class="form-group">
                            <label for="nib">{{ trans('label.nib_company') }} </label>
                            <input id="nib" name="nib" type="text" value="{{ $company->nib }}" class="form-control" placeholder="{{ trans('label.nib_company') }}">
                        </div>
                        <div class="form-group">
                            <label for="date_nib">{{ trans('label.date_nib_company') }} </label>
                            <input id="date_nib" name="date_nib" type="text" value="{{ (!empty($company->date_nib) ? \Illuminate\Support\Carbon::parse($company->date_nib)->format('d-m-Y') : '') }}" class="form-control datepickerInit" placeholder="{{ trans('label.date_nib_company') }}" autocomplete="nope">
                        </div>
                        <div class="form-group">
                            <label for="type">{{ trans('label.type_company') }}</label>
                            <input id="type" name="type" type="text" value="{{ $company->type }}" class="form-control" data-action="{{ route("{$bkpmumkm_identifier}.json_type_jenis_company") }}" placeholder="{{ trans('label.type_company') }}">
                        </div>
                        <div class="form-group">
                            <label for="business_sector_id">{{ trans('label.sector_company') }}</label>
                            <select id="business_sector_id" name="business_sector_id" class="form-control select2InitBusinessSector" data-action="{{ route("{$bkpmumkm_identifier}.json_sector") }}">
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @if ($company->sector)
                                    <option value="{{ $company->business_sector_id }}" selected>{{ $company->sector->name }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="code_kbli">{{ trans('label.code_kbli_company') }} </label>
                            <select id="code_kbli" name="code_kbli[]" class="form-control select2InitKBLI" multiple data-action="{{ route("{$bkpmumkm_identifier}.json_kbli") }}">
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @if ($company->kbli)
                                    @foreach($company->kbli as $kbli)
                                        <option value="{{ $kbli->code }}" selected>[{{ $kbli->code }}] {{ $kbli->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pmdn_pma">{{ trans('label.pmdn_pma_company') }}</label>
                            <select id="pmdn_pma" name="pmdn_pma" class="form-control select2InitB4">
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @foreach ($pmdn_pma as $pmdnpma)
                                    <option value="{{ $pmdnpma }}" {{ ($pmdnpma == $company->pmdn_pma ? 'selected':'') }}>{{ $pmdnpma }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group {{ ($company->pmdn_pma != 'PMA' ? 'd-none':'') }}">
                            <label for="pma_negara_id">{{ trans('label.pma_negara') }} <strong class="text-danger">*</strong></label>
                            <select id="pma_negara_id" name="pma_negara_id" class="form-control select2InitB4" required {{ ($company->pmdn_pma != 'PMA' ? 'disabled':'') }}>
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @foreach (\SimpleCMS\Wilayah\Models\NegaraModel::orderBy('nama_negara', 'ASC')->cursor() as $negara)
                                    <option value="{{ $negara->kode_negara }}" {{ ($negara->kode_negara == $company->pma_negara_id ? 'selected':'') }}>{{ $negara->nama_negara }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">{{ trans('label.email_company') }}</label>
                            <input id="email" name="email" type="email" value="{{ $company->email }}" class="form-control" placeholder="{{ trans('label.email_company') }}">
                        </div>
                        <div class="form-group">
                            <label for="telp">{{ trans('label.telp_company') }} </label>
                            <input id="telp" name="telp" type="text" value="{{ $company->telp }}" placeholder="{{ trans('label.telp_company') }}" class="form-control numberonly">
                        </div>
                        <div class="form-group">
                            <label for="fax">{{ trans('label.fax_company') }} </label>
                            <input id="fax" name="fax" type="text" value="{{ $company->fax }}" class="form-control numberonly" placeholder="{{ trans('label.fax_company') }}">
                        </div>

                        {!! template_wilayah_negara(
                                $company->id_negara,
                                $company->id_provinsi,
                                $company->id_kabupaten,
                                $company->id_kecamatan,
                                $company->id_desa
                            )
                        !!}

                        <div class="form-group">
                            <label for="address">{{ trans('label.address_company') }} </label>
                            <textarea id="address" name="address" class="form-control" placeholder="{{ trans('label.address_company') }}">{!! nl2br($company->address) !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="postal_code">{{ trans('label.postal_code_company') }} </label>
                            <input id="postal_code" name="postal_code" type="text" value="{{ $company->postal_code }}" placeholder="{{ trans('label.postal_code_company') }}" class="form-control numberonly">
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
                            <label for="name_director">{{ trans('label.name_director_of_company') }}</label>
                            <input id="name_director" name="name_director" type="text" value="{{ $company->name_director }}" placeholder="{{ trans('label.name_director_of_company') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email_director">{{ trans('label.email_director_of_company') }} </label>
                            <input id="email_director" name="email_director" type="email" value="{{ $company->email_director }}" placeholder="{{ trans('label.email_director_of_company') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phone_director">{{ trans('label.phone_director_of_company') }} </label>
                            <input id="phone_director" name="phone_director" type="text" value="{{ $company->phone_director }}" placeholder="{{ trans('label.phone_director_of_company') }}" class="form-control numberonly">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('label.pic_of_company') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name_pic">{{ trans('label.name_pic_of_company') }}</label>
                            <input id="name_pic" name="name_pic" type="text" value="{{ $company->name_pic }}" placeholder="{{ trans('label.name_pic_of_company') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email_pic">{{ trans('label.email_pic_of_company') }}</label>
                            <input id="email_pic" name="email_pic" type="email" value="{{ $company->email_pic }}" placeholder="{{ trans('label.email_pic_of_company') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phone_pic">{{ trans('label.phone_pic_of_company') }}</label>
                            <input id="phone_pic" name="phone_pic" type="text" value="{{ $company->phone_pic }}" placeholder="{{ trans('label.phone_pic_of_company') }}" class="form-control numberonly">
                        </div>

                        <input type="hidden" name="pic_id" value="{{ encrypt_decrypt(($company->pic->id??'')) }}">
                        @if (!$company->pic OR ($company->pic && !$company->pic->id))
                            <div class="form-group">
                                <label for="password_account_pic">{{ trans('core::label.password') }}</label>
                                <input id="password_account_pic" name="password" type="password" value="" placeholder="{{ trans('core::label.password') }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation_account_pic">{{ trans('core::label.password_confirmation') }}</label>
                                <input id="password_confirmation_account_pic" name="password_confirmation" type="password" value="" placeholder="{{ trans('core::label.password_confirmation') }}" class="form-control">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="logo_company">Logo</label>
                            <div class="input-group input-group-sm">
                                <input id="logo_company" type="text" class="form-control thumbViewImage" name="logo" value="{{ $company->logo }}" data-extensions="png,jpg,jpeg">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-success btn-sm popup_selector" data-inputid="logo_company" {{ ($company->path ? 'data-path='. $company->path .'':'') }} ><i class="fas fa-image"></i> </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="simple_cms.removeViewImage('logo_company')"><i class="fas fa-remove"></i> </button>
                                </span>
                            </div>
                            <span class="text-info">Extension .png, .jpg, .jpeg</span>
                        </div>
                        <div class="form-group">
                            <div id="viewImage-logo_company"></div>
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
                                    <label for="about_company">{{ trans('label.about_company') }}</label>
                                    <textarea id="about_company" name="about" class="form-control about_company" placeholder="{{ trans('label.about_company') }}">{!! shortcodes($company->about) !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('label.map_location_company') }}</label>
                                    <div id="boxOpenMap">
                                        <div id="openMap" class="sizeOpenMap"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="mapLng">Longitude</label>
                                                <input id="mapLng" name="longitude" value="{{ $company->longitude }}" type="text" placeholder="Longitude" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="mapLat">Latitude</label>
                                                <input id="mapLat" name="latitude" value="{{ $company->latitude }}" type="text" placeholder="Latitude" class="form-control">
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
                                    <label for="total_employees">{{ trans('label.total_employees_company') }} </label>
                                    <input id="total_employees" name="total_employees" value="{{ $company->total_employees ?? 0 }}" type="text" placeholder="{{ trans('label.total_employees_company') }}" class="form-control numberonly">
                                </div>
                                <div class="form-group">
                                    <label for="investment_plan">{{ trans('label.investment_plan_company') }} </label>
                                    <input id="investment_plan" name="investment_plan" value="{{ number_format($company->investment_plan) }}" type="text" placeholder="{{ trans('label.investment_plan_company') }}" class="form-control nominal">
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
    {!! plugins_script('bkpmumkm', 'company/backend/js/add-edit.js') !!}
@endpush
