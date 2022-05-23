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
            </div>
        </div>

        <form id="formAddEditCompany" class="row" data-action="{{ route("{$bkpmumkm_identifier}.backend.company.save_journal") }}">
            <div class="col-md-3"></div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <input name="user_id" type="hidden" value="{{ $user->id }}">
                        <div class="form-group">
                            <label for="company_id">{{ trans('label.name_company') }} <i class="text-danger">*</i></label>
                            <select id="company_id" name="company_id" class="form-control" required>
                                <option value="">{{ trans('label.select_choice') }}</option>            
                                @foreach($companies as $ub)
                                    <option value="{{ $ub->id }}">{{ $ub->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="task_id">Journal Task <i class="text-danger">*</i></label>
                            <select id="task_id" name="task_id" class="form-control" required>
                                <option value="">{{ trans('label.select_choice') }}</option>            
                                @foreach($journal_task as $jt)
                                    <option value="{{ $jt->id }}">{{ $jt->journal_task }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="activity_date">Activity Date <i class="text-danger">*</i></label>
                            <input id="activity_date" name="activity_date" type="date" class="form-control" placeholder="Activity Date" required>
                        </div>
                        <div class="form-group">
                            <label for="jurnal">Detail Jurnal <i class="text-danger">*</i></label>
                            <textarea id="jurnal" name="jurnal" class="form-control" placeholder="Detail jurnal" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>

            <div class="col-md-3"></div>
            <div class="col-md-6  col-sm-12">
                <div class="card">
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-sm" title="{{ trans('label.save') }}"><i class="fa fa-save"></i> {{ trans('label.save') }}</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
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

