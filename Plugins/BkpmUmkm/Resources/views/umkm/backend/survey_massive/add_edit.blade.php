@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! plugins_style('bkpmumkm', 'survey/backend/css/dropzone-style.css') !!}
    {!! library_select2('css') !!}
    {!! library_leaflet('css') !!}
    {!! library_datepicker('css') !!}
@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <a id="btnKembali" class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.survey_massive.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                @if($survey->id != '')
                    <a class="btn btn-primary btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.survey_massive.add") }}" title="{{ trans('label.add_new_survey_umkm_observasi_massive') }}"><i class="fa fa-plus"></i> {{ trans('label.add_new_umkm_observasi_massive') }}</a>
                @endif
            </div>
        </div>

        <form id="formAddEditUmkm" class="row" data-action="{{ route("{$bkpmumkm_identifier}.backend.umkm.survey_massive.save_update") }}">
            <input type="hidden" name="id" value="{{ encrypt_decrypt($survey->id) }}">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="id_umkm_massive">{{ trans("label.index_umkm") }} <strong class="text-danger">*</strong></label>
                                    <select id="id_umkm_massive" name="id_umkm_massive" class="form-control select2UmkmMassiveInit" data-action="{{ route("{$bkpmumkm_identifier}.json_umkm_massive") }}" required>
                                        @if ($survey->id_umkm_massive)
                                            <option value="{{ $survey->id_umkm_massive }}" selected>{{ $survey->umkm->name }} [{{ $survey->umkm->nib }}{{ ($survey->umkm->provinsi ? '|'.$survey->umkm->provinsi->nama_provinsi :'') }}]</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="date_survey">{{ trans("label.date_survey") }} <strong class="text-danger">*</strong> </label>
                                    <input id="date_survey" type="text" name="date_survey" value="{{ ($survey->created_at ? carbonParseTransFormat($survey->created_at, 'd-m-Y') : '') }}" class="form-control datepickerInit" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ trans('label.map_location_umkm') }}</label>
                                    <div id="boxOpenMap">
                                        <div id="openMap" class="sizeOpenMap"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="mapLat">Latitude</label>
                                                <input id="mapLat" name="latitude" value="{{ $survey->latitude }}" type="text" placeholder="Latitude" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="mapLng">Longitude</label>
                                                <input id="mapLng" name="longitude" value="{{ $survey->longitude }}" type="text" placeholder="Longitude" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan">{!! nl2br($survey->keterangan) !!}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Foto Berita Acara</label>

                                    <div class="row">
                                        <div class="myDropZone myDropZoneSingle col-12">
                                            <input type="file" name="foto_berita_acara_upload[]" data-named="foto_berita_acara[]" data-index="foto_berita_acara" multiple>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="row myDropZoneView">
                                                @if($survey->foto_berita_acara)
                                                    @foreach($survey->foto_berita_acara as $fba)
                                                        <div class="col-lg-3 col-md-4 col-6 mb-3">
                                                            <input type="hidden" name="foto_berita_acara[]" value="{{ $fba }}">
                                                            <div class="mdz-image">
                                                                <img src="{{ view_asset($fba) }}" class="img-thumbnail"/>
                                                            </div>
                                                            <div class="mdz-footer text-right">
                                                                <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$fba}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Foto Legalitas Usaha</label>

                                    <div class="row">
                                        <div class="myDropZone myDropZoneSingle col-12">
                                            <input type="file" name="foto_legalitas_usaha_upload[]" data-named="foto_legalitas_usaha[]" data-index="foto_legalitas_usaha" multiple>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="row myDropZoneView">
                                                @if($survey->foto_legalitas_usaha)
                                                    @foreach($survey->foto_legalitas_usaha as $flu)
                                                        <div class="col-lg-3 col-md-4 col-6 mb-3">
                                                            <input type="hidden" name="foto_legalitas_usaha[]" value="{{ $flu }}">
                                                            <div class="mdz-image">
                                                                <img src="{{ view_asset($flu) }}" class="img-thumbnail"/>
                                                            </div>
                                                            <div class="mdz-footer text-right">
                                                                <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$flu}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Foto Tempat Usaha</label>

                                    <div class="row">
                                        <div class="myDropZone myDropZoneSingle col-12">
                                            <input type="file" name="foto_tempat_usaha_upload[]" data-named="foto_tempat_usaha[]" data-index="foto_tempat_usaha" multiple>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="row myDropZoneView">
                                                @if($survey->foto_tempat_usaha)
                                                    @foreach($survey->foto_tempat_usaha as $ftu)
                                                        <div class="col-lg-3 col-md-4 col-6 mb-3">
                                                            <input type="hidden" name="foto_tempat_usaha[]" value="{{ $ftu }}">
                                                            <div class="mdz-image">
                                                                <img src="{{ view_asset($ftu) }}" class="img-thumbnail"/>
                                                            </div>
                                                            <div class="mdz-footer text-right">
                                                                <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$ftu}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Foto Produk</label>

                                    <div class="row">
                                        <div class="myDropZone myDropZoneSingle col-12">
                                            <input type="file" name="foto_produk_upload[]" data-named="foto_produk[]" data-index="foto_produk" multiple>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="row myDropZoneView">
                                                @if($survey->foto_produk)
                                                    @foreach($survey->foto_produk as $fp)
                                                        <div class="col-lg-3 col-md-4 col-6 mb-3">
                                                            <input type="hidden" name="foto_produk[]" value="{{ $fp }}">
                                                            <div class="mdz-image">
                                                                <img src="{{ view_asset($fp) }}" class="img-thumbnail"/>
                                                            </div>
                                                            <div class="mdz-footer text-right">
                                                                <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$fp}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                                            </div>
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
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('label.surveyor') }}</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name_surveyor">{{ trans('label.name_surveyor') }} <i class="text-danger">*</i></label>
                            <input id="name_surveyor" name="nama_surveyor" type="text" value="{{ $survey->nama_surveyor }}" class="form-control" placeholder="{{ trans('label.name_surveyor') }}">
                        </div>
                        <div class="form-group">
                            <label for="phone_surveyor">{{ trans('label.phone_surveyor') }} </label>
                            <input id="phone_surveyor" name="type" type="text" value="{{ $survey->phone_surveyor }}" data-action="{{ route("{$bkpmumkm_identifier}.json_sector_umkm_observasi_massive") }}" class="form-control" placeholder="{{ trans('label.sector_umkm') }}" >
                        </div>

                        {!! template_wilayah_negara_provinsi_all(
                                $survey->id_negara_surveyor,
                                $survey->id_provinsi_surveyor,
                                $survey->id_kabupaten_surveyor,
                                $survey->id_kecamatan_surveyor,
                                $survey->id_desa_surveyor
                            )
                        !!}

                        <div class="form-group">
                            <label for="address_surveyor">{{ trans('label.address_surveyor') }} </label>
                            <textarea id="address_surveyor" name="address_surveyor" class="form-control" placeholder="{{ trans('label.address_surveyor') }}">{!! nl2br($survey->address_surveyor) !!}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12">
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
    <script>
        const labelDelete = "{{ trans('label.delete') }}";
    </script>
    {!! library_tinymce('js') !!}
    {!! library_select2('js') !!}
    {!! module_script('core','js/event-select2.js') !!}
    {!! filemanager_standalonepopup() !!}
    {!! library_leaflet('js') !!}
    {!! library_datepicker('js') !!}
    {!! plugins_script('bkpmumkm', 'umkm/backend/massive/js/dropzone.js') !!}
    {!! plugins_script('bkpmumkm', 'js/event-company-umkm.js') !!}
    {!! plugins_script('bkpmumkm', 'umkm/backend/js/add-edit.js') !!}
@endpush
