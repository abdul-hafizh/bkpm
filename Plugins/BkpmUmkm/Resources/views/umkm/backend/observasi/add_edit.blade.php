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
                <a id="btnKembali" class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.observasi.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                @if($umkm->id != '')
                    <a class="btn btn-primary btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.observasi.add") }}" title="{{ trans('label.add_new_umkm_observasi') }}"><i class="fa fa-plus"></i> {{ trans('label.add_new_umkm_observasi') }}</a>
                @endif
            </div>
        </div>

        <form id="formAddEditUmkm" class="row" data-action="{{ route("{$bkpmumkm_identifier}.backend.umkm.observasi.save_update") }}">
            <input type="hidden" name="id" value="{{ encrypt_decrypt($umkm->id) }}">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ trans('label.name_umkm') }} <i class="text-danger">*</i></label>
                            <input id="name" name="name" type="text" value="{{ $umkm->name }}" class="form-control" placeholder="{{ trans('label.name_umkm') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="name_director">{{ trans('label.name_director_of_umkm') }} <i class="text-danger">*</i></label>
                            <input id="name_director" name="name_director" type="text" value="{{ $umkm->name_director }}" placeholder="{{ trans('label.name_director_of_umkm') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="about_umkm">Deskripsi Jenis Usaha</label>
                            <textarea id="about_umkm" name="about" class="form-control about_umkm" placeholder="Deskripsi Jenis Usaha">{!! shortcodes($umkm->about) !!}</textarea>
                        </div>

                        {{-- <div class="form-group">
                            <label for="surveyor_observasi_id">{{ trans("label.surveyor") }} <i class="text-danger">*</i></label>
                            <select id="surveyor_observasi_id" name="surveyor_observasi_id" class="form-control select2InitB4">
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @foreach($surveyors as $surveyor)
                                    <option value="{{ $surveyor->id }}" {{ ($surveyor->id == $umkm->surveyor_observasi_id ? 'selected':'') }}>{{ $surveyor->name }} [{{ $surveyor->email . (isset($surveyor->provinsi) && $surveyor->provinsi ? '|'.$surveyor->provinsi->nama_provinsi : '') }}]</option>
                                @endforeach
                            </select>
                        </div> --}}

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
    {!! plugins_script('bkpmumkm', 'survey/backend/js/add-edit.js') !!}
    {!! plugins_script('bkpmumkm', 'js/event-company-umkm.js') !!}
    {!! plugins_script('bkpmumkm', 'umkm/backend/js/add-edit.js') !!}
@endpush
