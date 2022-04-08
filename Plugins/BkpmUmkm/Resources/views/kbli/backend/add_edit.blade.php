@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.kbli.index") }}" title="{{ trans('label.index_kbli') }}"> {{ trans('label.index_kbli') }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')

@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3 justify-content-center">
            <div class="col-5">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.kbli.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                @if($kbli->id)
                    <a class="btn btn-primary btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.kbli.add") }}" title="{{ trans('label.add_new_kbli') }}"><i class="fa fa-plus"></i> {{ trans('label.add_new_kbli') }}</a>
                @endif
            </div>
        </div>

        <form id="formAddEditKbli" class="row justify-content-center" data-action="{{ route("{$bkpmumkm_identifier}.backend.kbli.save_update") }}">
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ encrypt_decrypt($kbli->id) }}" />
                        <div class="form-group">
                            <label for="code">Code <i class="text-danger">*</i></label>
                            <input id="code" type="text" name="code" value="{{ $kbli->code }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name <i class="text-danger">*</i></label>
                            <input id="name" type="text" name="name" value="{{ $kbli->name }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="parent_code">Parent Code </label>
                            <select id="parent_code" type="text" name="parent_code" class="form-control">
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @foreach ($parent_kbli as $pacode)
                                    <option value="{{ $pacode->code }}" {{ ($pacode->code == $kbli->parent_code ? 'selected':'') }}>{{ $pacode->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description </label>
                            <textarea id="description" name="description" class="form-control">{!! nl2br($kbli->description) !!}</textarea>
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
    {!! plugins_script('bkpmumkm', 'kbli/backend/js/add-edit.js') !!}
@endpush
