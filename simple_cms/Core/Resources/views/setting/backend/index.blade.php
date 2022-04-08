@extends('core::layouts.setting')
@section('title','Settings')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Settings"> Settings</a></li>
@endsection
@section('layout')
    <div class="container-fluid">
        <div class="row bg-gradient-white">
            <div class="col-5 col-sm-3 p-0">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="vert-tabs-general-tab" data-toggle="pill" href="#vert-tabs-general" role="tab" aria-controls="vert-tabs-general" aria-selected="true">General</a>
                    <a class="nav-link" id="vert-tabs-homepage-tab" data-toggle="pill" href="#vert-tabs-homepage" role="tab" aria-controls="vert-tabs-homepage" aria-selected="true">Homepage</a>
                    <a class="nav-link" id="vert-tabs-contact-information-tab" data-toggle="pill" href="#vert-tabs-contact-information" role="tab" aria-controls="vert-tabs-contact-information" aria-selected="false">Contact Information</a>
                    <a class="nav-link" id="vert-tabs-membership-tab" data-toggle="pill" href="#vert-tabs-membership" role="tab" aria-controls="vert-tabs-membership" aria-selected="false">Membership</a>
                    <a class="nav-link" id="vert-tabs-backend-scripts-tab" data-toggle="pill" href="#vert-tabs-backend-scripts" role="tab" aria-controls="vert-tabs-backend-scripts" aria-selected="false">Backend Scripts</a>
                    <a class="nav-link" id="vert-tabs-frontend-scripts-tab" data-toggle="pill" href="#vert-tabs-frontend-scripts" role="tab" aria-controls="vert-tabs-frontend-scripts" aria-selected="false">Frontend Scripts</a>
                    {!! simple_cms_core_backend_setting_tab_hook_action() !!}
                    <a class="nav-link" id="vert-tabs-guide-tab" data-toggle="pill" href="#vert-tabs-guide" role="tab" aria-controls="vert-tabs-guide" aria-selected="false">{{ trans("label.guide") }}</a>
                </div>
            </div>
            <div class="col-7 col-sm-9 p-5">
                <div id="vert-tabs-tabContent" class="tab-content bg-white">
                    <div class="tab-pane text-left fade show active" id="vert-tabs-general" role="tabpanel" aria-labelledby="vert-tabs-general-tab">
                        <form class="formSettingSaveUpdate row" data-action="{{ route('simple_cms.setting.backend.save_update') }}">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="setting-site_url">Site Url <strong class="text-danger">*</strong></label>
                                    <input id="setting-site_url" type="text" name="settings[site_url]" value="{{ site_url() }}" data-counter="100" placeholder="Site Url" class="form-control form-control-sm" required>
                                </div>
                                <div class="form-group">
                                    <label for="setting-link_dashboard">Url Dashboard <strong class="text-danger">*</strong></label>
                                    <input id="setting-link_dashboard" type="text" name="settings[link_dashboard]" value="{{ link_dashboard() }}" data-counter="100" placeholder="Url Dashboard" class="form-control form-control-sm" required>
                                </div>
                                <div class="form-group">
                                    <label for="setting-site_name">Site Title <strong class="text-danger">*</strong></label>
                                    <input id="setting-site_name" type="text" name="settings[site_name]" value="{{ simple_cms_setting('site_name', config('app.name')) }}" data-counter="100" placeholder="Site Title" class="form-control form-control-sm" required>
                                </div>
                                <div class="form-group">
                                    <label for="setting-site_description">Site Description <strong class="text-danger">*</strong></label>
                                    <textarea id="setting-site_description" name="settings[site_description]" data-counter="150" placeholder="Site Description" class="form-control form-control-sm" required>{{ simple_cms_setting('site_description', 'Simple CMS - PHP platform base on Laravel Framework') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="setting-site_keyword">Site Keywords <strong class="text-danger">*</strong></label>
                                    <input id="setting-site_keyword" type="text" name="settings[site_keyword]" value="{{ simple_cms_setting('site_keyword', 'SimpleCMS,CMS,PHP platform,Laravel,Framework') }}" data-counter="120" placeholder="Site Keywords" class="form-control form-control-sm" required>
                                </div>
                                {!! simple_cms_core_backend_setting_in_general_left_hook_action() !!}
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="setting-site_logo">Site Logo <strong class="text-danger">*</strong></label>
                                    <div class="input-group input-group-sm">
                                        <input id="setting-site_logo" type="text" class="form-control form-control-sm" name="settings[site_logo]" value="{{ site_logo() }}" data-extensions="png,jpg" required>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-sm popup_selector" data-inputid="setting-site_logo"><i class="fas fa-image"></i> </button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeViewImage('setting-site_logo')"><i class="fas fa-remove"></i> </button>
                                        </span>
                                    </div>
                                    <span class="text-info">Extension .png</span>
                                </div>
                                <div class="form-group">
                                    <div id="viewImage-setting-site_logo"></div>
                                </div>
                                <div class="form-group">
                                    <label for="setting-site_favicon">Site Favicon <strong class="text-danger">*</strong></label>
                                    <div class="input-group input-group-sm">
                                        <input id="setting-site_favicon" type="text" class="form-control form-control-sm" name="settings[site_favicon]" value="{{ site_favicon() }}" data-extensions="ico,png" required>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-sm popup_selector" data-inputid="setting-site_favicon"><i class="fas fa-image"></i> </button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeViewImage('setting-site_favicon')"><i class="fas fa-remove"></i> </button>
                                        </span>
                                    </div>
                                    <span class="text-info">Extension .ico</span>
                                </div>
                                <div class="form-group">
                                    <div id="viewImage-setting-site_favicon"></div>
                                </div>
                                <div class="form-group">
                                    <label for="setting-text_footer">Text Footer <strong class="text-danger">*</strong></label>
                                    <textarea id="setting-text_footer" name="settings[text_footer]" data-counter="150" placeholder="Text footer" class="form-control form-control-sm" required>{{ text_footer(false) }}</textarea>
                                    <span>Support tag html, <code>%year%</code>, <code>%site_name%</code></span>
                                </div>

                                {!! simple_cms_core_backend_setting_in_general_right_hook_action() !!}
                            </div>

                            {!! simple_cms_core_backend_setting_in_general_hook_action() !!}

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
                    <div class="tab-pane fade" id="vert-tabs-homepage" role="tabpanel" aria-labelledby="vert-tabs-homepage-tab">
                        <form class="formSettingSaveUpdate row" data-action="{{ route('simple_cms.setting.backend.save_update') }}">
                            <div class="col-lg-6">
                                {!! simple_cms_core_backend_setting_in_homepage_left_hook_action() !!}
                            </div>
                            <div class="col-lg-6">
                                {!! simple_cms_core_backend_setting_in_homepage_right_hook_action() !!}
                            </div>
                            {!! simple_cms_core_backend_setting_in_homepage_hook_action() !!}
                            <div class="col-md-12 m-t-10">
                                <div class="row">
                                    <div class="col-lg-6">

                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-sm btn-primary" title="Save"><i class="fas fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="vert-tabs-contact-information" role="tabpanel" aria-labelledby="vert-tabs-contact-information-tab">
                        <form class="formSettingSaveUpdate row" data-action="{{ route('simple_cms.setting.backend.save_update') }}">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="setting-site_address">Address</label>
                                    <input id="setting-site_address" type="text" name="settings[site_address]" value="{{ simple_cms_setting('site_address', '') }}" data-counter="200" placeholder="Address" class="form-control form-control-sm">
                                </div>
                                <div class="form-group">
                                    <label for="setting-site_email">Email Support</label>
                                    <input id="setting-site_email" type="email" name="settings[site_email]" value="{{ simple_cms_setting('site_email', 'admin@whendy.net') }}" placeholder="Email Support" class="form-control form-control-sm">
                                </div>
                                <div class="form-group">
                                    <label for="setting-site_phone">Phone/Telephone</label>
                                    <input id="setting-site_phone" type="text" name="settings[site_phone]" value="{{ simple_cms_setting('site_phone', '') }}" placeholder="Phone/Telephone" class="form-control form-control-sm">
                                </div>
                                <div class="form-group">
                                    <label for="setting-site_fax">Fax</label>
                                    <input id="setting-site_fax" type="text" name="settings[site_fax]" value="{{ simple_cms_setting('site_fax', '') }}" placeholder="Fax" class="form-control form-control-sm">
                                </div>
                                {!! simple_cms_core_backend_setting_in_contact_information_left_hook_action() !!}
                            </div>
                            <div class="col-lg-6">
                                {!! simple_cms_core_backend_setting_in_contact_information_right_hook_action() !!}
                            </div>
                            {!! simple_cms_core_backend_setting_in_contact_information_hook_action() !!}
                            <div class="col-md-12 m-t-10">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <small><strong>Note: </strong> If empty it will not be showing.</small>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-sm btn-primary" title="Save"><i class="fas fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="vert-tabs-membership" role="tabpanel" aria-labelledby="vert-tabs-membership-tab">
                        <form class="formSettingSaveUpdate row" data-action="{{ route('simple_cms.setting.backend.save_update') }}">
                            <div class="col-lg-6">
                                {!! simple_cms_core_backend_setting_in_membership_left_hook_action() !!}
                            </div>
                            <div class="col-lg-6">
                                {!! simple_cms_core_backend_setting_in_membership_right_hook_action() !!}
                            </div>
                            {!! simple_cms_core_backend_setting_in_membership_hook_action() !!}
                            <div class="col-md-12 m-t-10">
                                <div class="row">
                                    <div class="col-lg-6">

                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-sm btn-primary" title="Save"><i class="fas fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="vert-tabs-backend-scripts" role="tabpanel" aria-labelledby="vert-tabs-backend-scripts-tab">
                        <form class="formSettingSaveUpdate row" data-action="{{ route('simple_cms.setting.backend.save_update') }}">
                            <div class="col-lg-6">
                                <fieldset class="border-5">
                                    <legend class="f-s-16">Script on Top <small>Can input stylesheet (css) or jQuery/javascript (js)</small></legend>
                                    <textarea id="setting-backend_style" name="settings[backend_style]" class="form-control font-control-sm" rows="50">{!! simple_cms_setting('backend_style', '') !!}</textarea>
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset class="border-5">
                                    <legend class="f-s-16">Script on Bottom <small>Can input stylesheet (css) or jQuery/javascript (js)</small></legend>
                                    <textarea id="setting-backend_script" name="settings[backend_script]" class="form-control font-control-sm" rows="50">{!! simple_cms_setting('backend_script', '') !!}</textarea>
                                </fieldset>
                            </div>
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
                    <div class="tab-pane fade" id="vert-tabs-frontend-scripts" role="tabpanel" aria-labelledby="vert-tabs-frontend-scripts-tab">
                        <form class="formSettingSaveUpdate row" data-action="{{ route('simple_cms.setting.backend.save_update') }}">
                            <div class="col-lg-6">
                                <fieldset class="border-5">
                                    <legend class="f-s-16">Script on Top <small>Can input stylesheet (css) or jQuery/javascript (js)</small></legend>
                                    <textarea id="setting-frontend_style" name="settings[frontend_style]" class="form-control font-control-sm" rows="50">{!! simple_cms_setting('frontend_style', '') !!}</textarea>
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset class="border-5">
                                    <legend class="f-s-16">Script on Bottom <small>Can input stylesheet (css) or jQuery/javascript (js)</small></legend>
                                    <textarea id="setting-frontend_script" name="settings[frontend_script]" class="form-control font-control-sm" rows="50">{!! simple_cms_setting('frontend_script', '') !!}</textarea>
                                </fieldset>
                            </div>
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
                    {!! simple_cms_core_backend_setting_tab_content_hook_action() !!}
                    <div class="tab-pane fade" id="vert-tabs-guide" role="tabpanel" aria-labelledby="vert-tabs-guide-tab">
                        <form class="formSettingSaveUpdate row" data-action="{{ route('simple_cms.setting.backend.save_update') }}">
                            @php
                                $groups = \SimpleCMS\ACL\Models\GroupModel::where('id', '<>', 1)->cursor();
                            @endphp
                            @foreach($groups as $group)
                                @php
                                    $key_setting    = "guide_{$group->id}";
                                    $file_guide     = simple_cms_setting($key_setting, '');
                                    $group_name = str_replace([
                                                        'Group', 'group', 'Groups', 'groups',
                                                        'Roles', 'Role', 'roles', 'role',
                                                        'Rules', 'rules', 'Rule', 'rule'
                                                    ], '', $group->name);
                                @endphp
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('label.guide') }} {{ $group_name }}</label>
                                        <div class="input-group input-group-sm">
                                            <input id="panduan_user_{{ $group->id }}" type="text" class="form-control thumbViewImage" name="settings[{{ $key_setting }}]" value="{{ $file_guide }}" data-extensions="pdf">
                                            <span class="input-group-append">
                                        <button type="button" class="btn btn-success btn-sm popup_selector" data-inputid="panduan_user_{{ $group->id }}"><i class="fas fa-image"></i> </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-flat" onclick="simple_cms.removeViewImage('panduan_user_{{ $group->id }}')"><i class="fas fa-remove"></i> </button>
                                    </span>
                                        </div>
                                        <span class="text-info">Extension .pdf</span>
                                    </div>
                                    <div class="form-group mb-1">
                                        <div id="viewImage-panduan_user_{{ $group->id }}"></div>
                                    </div>
                                </div>
                            @endforeach
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
                </div>
            </div>
        </div>
    </div>
@endsection
