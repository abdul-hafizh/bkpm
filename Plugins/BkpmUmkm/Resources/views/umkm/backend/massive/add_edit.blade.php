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
                <a id="btnKembali" class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.massive.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                @if($umkm->id != '')
                    <a class="btn btn-primary btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.massive.add") }}" title="{{ trans('label.add_new_umkm_observasi_massive') }}"><i class="fa fa-plus"></i> {{ trans('label.add_new_umkm_observasi_massive') }}</a>
                @endif
            </div>
        </div>

        <form id="formAddEditUmkm" class="row" data-action="{{ route("{$bkpmumkm_identifier}.backend.umkm.massive.save_update") }}">
            <input type="hidden" name="id" value="{{ encrypt_decrypt($umkm->id) }}">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ trans('label.name_umkm') }} <i class="text-danger">*</i></label>
                            <input id="name" name="name" type="text" value="{{ $umkm->name }}" class="form-control" placeholder="{{ trans('label.name_umkm') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nib">{{ trans('label.nib_umkm') }} </label>
                            <input id="nib" name="nib" type="text" value="{{ $umkm->nib }}" class="form-control" placeholder="{{ trans('label.nib_umkm') }}">
                        </div>
                        <div class="form-group">
                            <label for="sector_massive">{{ trans('label.sector_umkm') }} </label>
                            <input id="sector_massive" name="type" type="text" value="{{ $umkm->sector }}" data-action="{{ route("{$bkpmumkm_identifier}.json_sector_umkm_observasi_massive") }}" class="form-control" placeholder="{{ trans('label.sector_umkm') }}" >
                        </div>
                        <div class="form-group">
                            <label for="code_kbli">{{ trans('label.code_kbli_umkm') }} <i class="text-danger">*</i></label>
                            <select id="code_kbli" name="code_kbli" class="form-control select2InitKBLI" data-action="{{ route("{$bkpmumkm_identifier}.json_kbli") }}" required>
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @if ($umkm->kbli)
                                    <option value="{{ $umkm->code_kbli }}" selected>{{ $umkm->kbli->name }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body">

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
                            <label for="startup_capital">{{ trans('label.startup_capital') }} </label>
                            <input id="startup_capital" name="startup_capital" value="{{ number_format($umkm->startup_capital) }}" type="text" placeholder="{{ trans('label.startup_capital') }}" class="form-control nominal" >
                        </div>
                        <div class="form-group">
                            <label for="omset_every_year_umkm">{{ trans('label.omset_every_year_umkm') }} </label>
                            <input id="omset_every_year_umkm" name="omset_every_year" value="{{ number_format($umkm->omset_every_year) }}" type="text" placeholder="{{ trans('label.omset_every_year_umkm') }}" class="form-control nominal" >
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
