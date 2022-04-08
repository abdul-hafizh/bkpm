@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans("label.survey_{$category_company}") }}"> {{ trans("label.survey_{$category_company}") }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_select2('css') !!}
    {!! library_datepicker('css') !!}
@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3 justify-content-center">
            <div class="col-5">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                @if($survey->id)
                    <a class="btn btn-primary btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.survey.add", ['company' => $category_company]) }}" title="{{ trans("label.add_new_survey_{$category_company}") }}"><i class="fa fa-plus"></i> {{ trans("label.add_new_survey_{$category_company}") }}</a>
                @endif
            </div>
        </div>

        <form id="formAddEditSurvey" class="row justify-content-center" data-action="{{ route("{$bkpmumkm_identifier}.backend.survey.save_update", ['company' => $category_company, 'event' => encrypt_decrypt($event)]) }}">
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ encrypt_decrypt($survey->id) }}" />
                        @if(!$survey->id OR ( $survey && !$survey->company_id) )
                            <div class="form-group">
                                <label for="company_id">{{ trans("label.index_{$category_company}") }} <i class="text-danger">*</i></label>
                                <select id="company_id" name="company_id" class="form-control" data-action="{{ route("{$bkpmumkm_identifier}.json_company", ['category' => $category_company]) }}" {{ ($survey->id ? 'readonly':'') }} required>
                                    @if ($survey->company_id)
                                        <option value="{{ $survey->company_id }}" selected>{{ $survey->{$category_company}->name }} [{{ $survey->{$category_company}->email .'|' }}{{ $survey->{$category_company}->nib .'|' }}{{ $survey->{$category_company}->provinsi->nama_provinsi }}]</option>
                                    @endif
                                </select>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="company_id">{{ trans("label.index_{$category_company}") }} <i class="text-danger">*</i></label>
                                <select id="company_id" class="form-control" disabled>
                                    @if ($survey->company_id)
                                        <option value="{{ $survey->company_id }}" selected>{{ $survey->{$category_company}->name }} [{{ $survey->{$category_company}->email .'|' }}{{ $survey->{$category_company}->nib .'|' }}{{ $survey->{$category_company}->provinsi->nama_provinsi }}]</option>
                                    @endif
                                </select>
                                <input type="hidden" name="company_id" value="{{ $survey->company_id }}">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="estimated_date">{{ trans('label.estimated_date') }} <i class="text-danger">*</i></label>
                            <input id="estimated_date" type="text" name="estimated_date" value="{{ ($survey && !empty($survey->estimated_date) ? \Carbon\Carbon::parse($survey->estimated_date)->format('d-m-Y') : \Carbon\Carbon::now()->addDays(30)->format('d-m-Y')) }}" class="form-control datepickerInit" required>
                        </div>
                        <div class="form-group">
                            <label for="surveyor_id">{{ trans("label.surveyor") }} <i class="text-danger">*</i></label>
                            <select id="surveyor_id" name="surveyor_id" class="form-control select2InitB4" required>
                                <option value="">{{ trans('label.select_choice') }}</option>
                                @foreach($surveyors as $surveyor)
                                    <option value="{{ encrypt_decrypt($surveyor->id) }}" {{ ($surveyor->id == $survey->surveyor_id ? 'selected':'') }}>{{ $surveyor->name }} [{{ $surveyor->email . (isset($surveyor->provinsi) && $surveyor->provinsi ? '|'.$surveyor->provinsi->nama_provinsi : '') }}]</option>
                                @endforeach
                            </select>
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
    {!! library_datepicker('js') !!}
    {!! library_select2('js') !!}
    {!! plugins_script('bkpmumkm', 'survey/backend/js/add-edit.js') !!}
@endpush
