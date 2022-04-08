@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.kemitraan.index") }}" title="{{ __("label.index_kemitraan") }}"> {{ __("label.index_kemitraan") }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_datepicker('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.kemitraan.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __("label.index_{$category_company}") }} : {{ $kemitraan->{$category_company}->name }}</h4>
                            </div>
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">@lang("label.nib_{$category_company}")</dt>
                                    <dd class="col-sm-8">{{ ($kemitraan->{$category_company}->nib ?? '-') }}</dd>

                                    <dt class="col-sm-4">@lang("wilayah::label.province")</dt>
                                    <dd class="col-sm-8">{{ ($kemitraan->{$category_company}->provinsi ? $kemitraan->{$category_company}->provinsi->nama_provinsi : '-') }}</dd>

                                    <dt class="col-sm-4">@lang("label.name_pic_of_{$category_company}")</dt>
                                    <dd class="col-sm-8">
                                        <div class="user-block">
                                            <span class="username ml-1"><a>{{ $kemitraan->{$category_company}->name_pic }}</a></span>
                                            <span class="description ml-1">
                                                @if (!empty($kemitraan->{$category_company}->email_pic))
                                                    <i class="fas fa-envelope"></i> {{ $kemitraan->{$category_company}->email_pic }}
                                                @endif
                                                @if (!empty($kemitraan->{$category_company}->phone_pic))
                                                    <br/><i class="fas fa-phone"></i> {{ $kemitraan->{$category_company}->phone_pic }}
                                                @endif
                                            </span>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __("label.index_{$category_umkm}") }} : {{ $kemitraan->{$category_umkm}->name }}</h4>
                            </div>
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">@lang("label.nib_{$category_umkm}")</dt>
                                    <dd class="col-sm-8">{{ ($kemitraan->{$category_umkm}->nib ?? '-') }}</dd>

                                    <dt class="col-sm-4">@lang("wilayah::label.province")</dt>
                                    <dd class="col-sm-8">{{ ($kemitraan->{$category_umkm}->provinsi ? $kemitraan->{$category_umkm}->provinsi->nama_provinsi : '-') }}</dd>

                                    <dt class="col-sm-4">@lang("label.name_pic_of_{$category_umkm}")</dt>
                                    <dd class="col-sm-8">
                                        <div class="user-block">
                                            <span class="username ml-1"><a>{{ $kemitraan->{$category_umkm}->name_pic }}</a></span>
                                            <span class="description ml-1">
                                                @if (!empty($kemitraan->{$category_umkm}->email_pic))
                                                    <i class="fas fa-envelope"></i> {{ $kemitraan->{$category_umkm}->email_pic }}
                                                @endif
                                                @if (!empty($kemitraan->{$category_umkm}->phone_pic))
                                                    <br/><i class="fas fa-phone"></i> {{ $kemitraan->{$category_umkm}->phone_pic }}
                                                @endif
                                            </span>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <form id="formKemitraanSave" data-action="{{ route("{$bkpmumkm_identifier}.backend.kemitraan.save", ['kemitraan_id' => encrypt_decrypt($kemitraan->id)]) }}" class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="sector">{{ __('label.sector_kemitraan') }}</label>
                                    <input id="sector" type="text" name="sector" class="form-control" value="{{ $kemitraan->sector }}" placeholder="Inputkan bidang/sektor kemitraan">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="nominal_investasi">{{ __('label.nominal_investasi') }}</label>
                                    <input id="nominal_investasi" type="text" name="nominal_investasi" class="form-control nominal" value="{{ number_format($kemitraan->nominal_investasi) }}" placeholder="100.000.000" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="date_kemitraan">{{ __('label.date_kemitraan') }}</label>
                                    <input id="date_kemitraan" type="text" name="date_kemitraan" class="form-control dateRangePickerInit" value="{{ $kemitraan->start_date }}" placeholder="2021-12-12" required  readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="file_kerjasama">@lang('label.file_kerjasama')</label>
                                    <input id="file_kerjasama" type="file" name="file_kerjasama" class="form-control" accept=".pdf">
                                    <span class="text-info">Note: file extension: .pdf</span>
                                </div>
                                @if(!empty($kemitraan->file_kerjasama))
                                    <div class="form-group">
                                        <a href="{{ asset($kemitraan->file_kerjasama) }}" class="d-block mb-4 w-25 h-25 {{ bkpmumkm_colorbox(asset($kemitraan->file_kerjasama)) }}">
                                            <img class="img-fluid img-thumbnail" src="{{ view_asset($kemitraan->file_kerjasama) }}">
                                        </a>
                                    </div>
                                    <input type="hidden" name="file_kerjasama_old" value="{{ $kemitraan->file_kerjasama }}">
                                @endif
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="file_kontrak">@lang('label.file_kontrak')</label>
                                    <input id="file_kontrak" type="file" name="file_kontrak" class="form-control" accept=".pdf">
                                    <span class="text-info">Note: file extension: .pdf</span>
                                </div>
                                @if(!empty($kemitraan->file_kontrak))
                                    <div class="form-group">
                                        <a href="{{ asset($kemitraan->file_kontrak) }}" class="d-block mb-4 w-25 h-25 {{ bkpmumkm_colorbox(asset($kemitraan->file_kontrak)) }}">
                                            <img class="img-fluid img-thumbnail" src="{{ view_asset($kemitraan->file_kontrak) }}">
                                        </a>
                                    </div>
                                    <input type="hidden" name="file_kontrak_old" value="{{ $kemitraan->file_kontrak }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-sm" title="@lang('label.save')"><i class="fas fa-save"></i> @lang('label.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js_stack')
    {!! library_datepicker('js') !!}
    {!! plugins_script('bkpmumkm', 'kemitraan/backend/js/edit.js') !!}
@endpush
