@extends('core::layouts.setting')
@section('title','Blog Settings')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Blog Settings"> Blog Settings</a></li>
@endsection
@section('layout')
    <div class="container-fluid">
        <div class="row bg-gradient-white">
            <div class="col-5 col-sm-3 p-0">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="vert-tabs-general-tab" data-toggle="pill" href="#vert-tabs-general" role="tab" aria-controls="vert-tabs-general" aria-selected="true">General</a>
                    {!! simple_cms_blog_backend_setting_tab_hook_action() !!}
                </div>
            </div>
            <div class="col-7 col-sm-9 p-5">
                <div id="vert-tabs-tabContent" class="tab-content bg-white">
                    <div class="tab-pane text-left fade show active" id="vert-tabs-general" role="tabpanel" aria-labelledby="vert-tabs-general-tab">
                        <form class="formSettingSaveUpdate row" data-action="{{ route('simple_cms.setting.backend.save_update') }}">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="setting-thumbnail_default">Thumb / Image Default</label>
                                    <div class="input-group input-group-sm">
                                        <input id="setting-thumbnail_default" type="text" class="form-control form-control-sm inputViewImage" name="settings[thumbnail_default]" value="{{ thumb_image() }}" data-extensions="png,jpg">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-sm popup_selector" data-inputid="setting-thumbnail_default"><i class="fas fa-image"></i> </button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeViewImage('setting-thumbnail_default')"><i class="fas fa-remove"></i> </button>
                                        </span>
                                    </div>
                                    <span class="text-info">Extension .png/.jpg</span>
                                </div>
                                <div class="form-group">
                                    <div id="viewImage-setting-thumbnail_default"></div>
                                </div>

                                {!! simple_cms_blog_backend_setting_in_general_left_hook_action() !!}
                            </div>
                            <div class="col-lg-6">
                                {!! simple_cms_blog_backend_setting_in_general_right_hook_action() !!}
                            </div>

                            {!! simple_cms_blog_backend_setting_in_general_hook_action() !!}

                            <div class="col-md-12 m-t-10">
                                <div class="row">
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-sm btn-primary" title="Save"><i class="fas fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    {!! simple_cms_blog_backend_setting_tab_content_hook_action() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
