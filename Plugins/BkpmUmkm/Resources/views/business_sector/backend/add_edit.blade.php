@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.business_sector.index") }}" title="{{ trans('label.index_business_sector') }}"> {{ trans('label.index_business_sector') }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')

@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.business_sector.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                @if($sector->id)
                    <a class="btn btn-primary btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.business_sector.add") }}" title="{{ trans('label.add_new_business_sector') }}"><i class="fa fa-plus"></i> {{ trans('label.add_new_business_sector') }}</a>
                @endif
            </div>
        </div>

        <form id="formAddEditBusinessSector" class="row" data-action="{{ route("{$bkpmumkm_identifier}.backend.business_sector.save_update") }}">
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ encrypt_decrypt($sector->id) }}" />
                        <div class="form-group">
                            <label for="name">Name <i class="text-danger">*</i></label>
                            <input id="name" type="text" name="name" value="{{ $sector->name }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-sm" title="{{ trans('label.save') }}"><i class="fa fa-save"></i> {{ trans('label.save') }}</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@push('js_stack')
    {!! plugins_script('bkpmumkm', 'business-sector/backend/js/add-edit.js') !!}
@endpush
