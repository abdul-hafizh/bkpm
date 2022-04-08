@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')

@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="search-company">@lang('label.search_company_by_nib_name_email')</label>
                            <div class="input-group input-group-sm">
                                <input id="search-company" type="text" name="search" class="form-control" placeholder="@lang('label.search_company_by_nib_name_email')">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-info btn-flat eventSearchCompany" data-action="{{ route("{$bkpmumkm_identifier}.backend.company.confirm_add") }}"><i class="fas fa-search"></i> @lang('label.search')</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 loadResultSearchCompany"></div>
        </div>
    </div>
@endsection
@push('js_stack')
    {!! plugins_script('bkpmumkm', 'company/backend/js/confirm-add.js') !!}
@endpush
