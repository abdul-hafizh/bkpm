@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.cross_matching.index", ['company' => $category_company]) }}" title="{{ __("label.index_cross_matching_{$category_company}") }}"> {{ __("label.index_cross_matching_{$category_company}") }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_datatables('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.cross_matching.index", ['company' => $category_company]) }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4>
                                @if ( hasRoute("{$bkpmumkm_identifier}.backend.survey.detail_survey") && hasRoutePermission("{$bkpmumkm_identifier}.backend.survey.detail_survey") && ($company->survey && $company->survey->survey_result ) )
                                    <a href="javascript:void(0);" class="show_modal_ex_lg" data-action="{{ route("{$bkpmumkm_identifier}.backend.survey.detail_survey", ['company' => $category_company, 'survey'=>encrypt_decrypt($company->survey->id), 'in_modal' => true]) }}" data-method="GET" title="@lang("label.survey_detail_survey_{$category_company}")">{{ $company->name }}</a>
                                @else
                                    {{ $company->name }}
                                @endif
                                </h4>
                            </div>
                            <div class="col-6">
                                <dl class="row">
                                    <dt class="col-sm-4">@lang("label.nib_{$category_company}")</dt>
                                    <dd class="col-sm-8">{{ ($company->nib ?? '-') }}</dd>

                                    <dt class="col-sm-4">@lang("wilayah::label.province")</dt>
                                    <dd class="col-sm-8">{{ ($company->provinsi ? $company->provinsi->nama_provinsi : '-') }}</dd>

                                    <dt class="col-sm-4">@lang("label.name_pic_of_{$category_company}")</dt>
                                    <dd class="col-sm-8">
                                        <div class="user-block">
                                            <span class="username ml-1"><a>{{ $company->name_pic }}</a></span>
                                            <span class="description ml-1">
                                                @if (!empty($company->email_pic))
                                                    <i class="fas fa-envelope"></i> {{ $company->email_pic }}
                                                @endif
                                                @if (!empty($company->phone_pic))
                                                    <br/><i class="fas fa-phone"></i> {{ $company->phone_pic }}
                                                @endif
                                            </span>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-12 companyPartDetail">
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_kebutuhan_kemitraan", ['survey'=>$company->survey, 'hide_number' => true])
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_standar_kriteria_persyaratan", ['survey'=>$company->survey, 'hide_number' => true])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('label.cross_matching_available')</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! $cross_matching_available->table() !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">@lang('label.cross_matching_picked')</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! $cross_matching_picked->table() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_stack')
    <script>
        @php
            $periodes = [];
            foreach (list_years() as $y) {
                $periodes[] = $y;
            }
        @endphp
        const periodes = @json($periodes),
            activePeriode = '{{ \Carbon\Carbon::parse($company->survey->created_at)->format('Y') }}';
        $(document).ready(function(){
            $('.companyPartDetail > .card').find('.card-header .card-tools button[data-card-widget="collapse"]').trigger('click');
        });
    </script>
    {!! library_datatables('js') !!}
    {!! $cross_matching_available->scripts() !!}
    {!! $cross_matching_picked->scripts() !!}
    {!! module_script('core','js/events.js') !!}
    {!! plugins_script('bkpmumkm', 'cross-matching/backend/js/edit.js') !!}
@endpush
