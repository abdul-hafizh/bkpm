@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! module_style('core', 'plugins/colorbox/colorbox.css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-md-6">
                <a class="btn btn-warning btn-sm" href="{{ route('simple_cms.slider.backend.index') }}" title="Back"><i class="fas fa-arrow-left"></i> Back</a>
                @if($sliders && $sliders->id)
                    <a class="btn btn-primary btn-sm" href="{{ route('simple_cms.slider.backend.add') }}" title="Add New Slider" ><i class="fas fa-plus"></i> New Slider</a>
                @endif
            </div>
            <div class="col-md-6">

            </div>
        </div>

        <form id="formSlidersAddEdit" data-action="{{ route('simple_cms.slider.backend.save_update') }}" class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="slider_title">Title <strong class="text-danger">*</strong></label>
                                    {!! input_language('title', 'title', 'input', ['class' => 'form-control form-control-sm', 'required' => 'required', 'placeholder' => 'Title'], $sliders) !!}
                                    <input type="hidden" name="id" value="{{ encrypt_decrypt($sliders->id) }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="slider_description">Content</label>
                                    {!! input_language('description', 'description', 'textarea', ['class' => 'form-control editor', 'required' => 'required', 'placeholder' => 'Type Here..!!'], $sliders) !!}
                                </div>
                            </div>
                            {{--<div class="col-md-12">
                                <div class="form-group">
                                    <label for="slider_link">Link/Url</label>
                                    <input id="slider_link" type="text" name="link" class="form-control form-control-sm" placeholder="eg: http://|https://|//:url" value="{{ $sliders->link }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slider_target_link">Target Link/Url</label>
                                    <select id="slider_target_link" name="target_link" class="form-control form-control-sm">
                                        <option value="_self" {{ ($sliders->target_link == '_self' ? 'selected': '') }}>Self ( None )</option>
                                        <option value="_blank" {{ ($sliders->target_link == '_blank' ? 'selected': '') }}>Blank ( New Tab )</option>
                                    </select>
                                </div>
                            </div>--}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slider_status">Status <strong class="text-danger">*</strong></label>
                                    <select id="slider_status" name="status" class="form-control form-control-sm" required>
                                        <option value="">-Select-</option>
                                        <option value="publish" {{ ($sliders->status == 'publish' ? 'selected' : '') }}>Publish</option>
                                        <option value="draft" {{ ($sliders->status == 'draft' ? 'selected' : '') }}>Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cover">Cover</label>
                                    <div class="input-group input-group-sm">
                                        <input id="cover" type="text" class="form-control form-control-sm" name="cover" value="{{ $sliders->cover }}" data-extensions="png,jpg">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-sm popup_selector" data-inputid="cover"><i class="fas fa-image"></i> </button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeViewImage('cover')"><i class="fas fa-remove"></i> </button>
                                        </span>
                                    </div>
                                    <span class="text-info">Extension .png, .jpg</span>
                                </div>
                                <div class="form-group">
                                    <div id="viewImage-cover"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary" title="Save"><i class="fas fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@push('js_stack')
    {!! library_tinymce('js') !!}
    {!! module_script('core', 'plugins/colorbox/jquery.colorbox-min.js') !!}
    {!! filemanager_standalonepopup() !!}
    {!! module_script('slider', 'backend/js/add_edit.js') !!}
@endpush
