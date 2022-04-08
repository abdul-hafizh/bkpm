@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! module_style('core', 'plugins/nestable/css/jquery.nestable.min.css') !!}
    <style>
        nav.category_menu {
            max-height: 300px;
            overflow: auto;
        }
        nav.category_menu ul {
            list-style: none;
            -webkit-margin-before: 0px;
            -webkit-margin-after: 0px;
            -webkit-margin-start: 0px;
            -webkit-margin-end: 0px;
            -webkit-padding-start: 20px;
        }
        nav.category_menu ul li {
            margin-left: -20px!important;
        }
        nav.category_menu ul li label input { margin-right: 5px; }
    </style>
@endpush
@section('layout')
    @php
        $default_locale = simple_cms_setting('locale');
        $translator_available_locales = simple_cms_setting('available_locales');
    @endphp
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-12">
                <a class="btn btn-warning btn-sm" href="{{ route('simple_cms.menu.backend.index') }}" title="Back"><i class="fa fa-arrow-left"></i> Back</a>
                @if($menu->id != '')
                    <a class="btn btn-primary btn-sm" href="{{ route('simple_cms.menu.backend.add') }}" title="New Menu"><i class="fa fa-plus"></i> New Menu</a>
                @endif
            </div>
        </div>
        <div class="row">

            <div class="col-md-4">

                <div id="accordion" role="tablist" class="card-accordion">
                    <div class="card card-outline card-secondary m-b-5">
                        <div class="card-header pointer-cursor" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <h3 class="card-title">Pages</h3>
                        </div>
                        <div id="collapsePages" class="collapse" data-parent="#accordion" style="">
                            <form id="formPages">
                                <div class="card-body p-10">
                                    @if($pages)
                                        <nav class="category_menu">
                                            <ul>
                                                @foreach($pages as $pgs)
                                                    @php
                                                        $label_title_translation = [];
                                                        foreach ($translator_available_locales as $local) {
                                                            $label_title_translation[$local] = trans($pgs->{'title_translation'}, [], $local);
                                                        }
                                                    @endphp
                                                    <li class="custom-control custom-checkbox">
                                                        <input id="page_{{ $pgs->slug }}" type="checkbox" class="filled-in custom-control-input" name="pages[]" value='{{ json_encode(['label'=>$label_title_translation,'title'=>$label_title_translation,'url'=>route('simple_cms.blog.post',['post_slug'=>$pgs->slug]),'icon'=>'', 'classcss' => '','target'=>'_self','type'=>'page','status'=>1]) }}'>
                                                        <label for="page_{{ $pgs->slug }}" class="pointer-cursor custom-control-label">{{ trans($pgs->title) }}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </nav>
                                    @else
                                        <small class="text-center">Empty Pages</small>
                                    @endif
                                </div>
                                <div class="card-footer text-right bg-white border-top">
                                    <button type="submit" title="Add to Menu" class="btn btn-xs btn-outline-primary"><i class="fa fa-plus"></i> Add to Menu</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{--<div class="card card-outline card-secondary m-b-5">
                        <div class="card-header pointer-cursor" data-toggle="collapse" data-target="#collapseTags" aria-expanded="false" aria-controls="collapseTags">
                            <h3 class="card-title">Tags</h3>
                        </div>
                        <div id="collapseTags" class="collapse" data-parent="#accordion" style="">
                            <form id="formTag">
                                <div class="card-body p-10">
                                    {!! $tags !!}
                                </div>
                                <div class="card-footer text-right bg-white border-top">
                                    <button type="submit" title="Add to Menu" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus"></i> Add to Menu</button>
                                </div>
                            </form>
                        </div>
                    </div>--}}

                    <div class="card card-outline card-secondary m-b-5">
                        <div class="card-header pointer-cursor" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">
                            <h3 class="card-title">Categories</h3>
                        </div>
                        <div id="collapseCategories" class="collapse show" data-parent="#accordion" style="">
                            <form id="formCategory">
                                <div class="card-body p-10">
                                    {!! $categories !!}
                                </div>
                                <div class="card-footer text-right bg-white border-top">
                                    <button type="submit" title="Add to Menu" class="btn btn-xs btn-outline-primary"><i class="fa fa-plus"></i> Add to Menu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card card-outline card-secondary m-b-5">
                        <div class="card-header pointer-cursor" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h3 class="card-title">Custom Link</h3>
                        </div>
                        <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                            <form id="formCustomLink">
                                <div class="card-body p-10">
                                    <div class="form-group">
                                        <label for="label">Label <strong class="text-danger">*</strong></label>
                                        {!! input_language('label', 'label', 'input', ['class' => 'form-control form-control-sm', 'required' => 'required', 'placeholder' => 'Label']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title Attribute</label>
                                        {!! input_language('title', 'title', 'input', ['class' => 'form-control form-control-sm', 'placeholder' => 'Title Attribute']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="url">URL <strong class="text-danger">*</strong></label>
                                        <input id="url" name="url" type="text" class="form-control form-control-sm" required placeholder="http://urldomain.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="icon">Icon (<small>Use FontAwesome icon</small>)</label>
                                        <input id="icon" name="icon" type="text" class="form-control form-control-sm" placeholder="fas fa-icon">
                                    </div>
                                    <div class="form-group">
                                        <label for="classcss">CSS Class</label>
                                        <input id="classcss" name="classcss" type="text" class="form-control form-control-sm" placeholder="CSS Class">
                                    </div>
                                    <div class="form-group">
                                        <label for="target">Target <strong class="text-danger">*</strong></label>
                                        <select id="target" name="target" class="form-control form-control-sm" required>
                                            <option value="_self">_self</option>
                                            <option value="_blank">_blank</option>
                                            <option value="_parent">_parent</option>
                                            <option value="_top">_top</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status <strong class="text-danger">*</strong></label>
                                        <select id="status" name="status" class="form-control form-control-sm" required>
                                            <option value="1">Show</option>
                                            <option value="0">Hide</option>
                                        </select>
                                    </div>
                                    <input id="type" name="type" type="hidden" value="custom">
                                </div>
                                <div class="card-footer text-right bg-white border-top">
                                    <button type="submit" title="Add to Menu" class="btn btn-xs btn-outline-primary"><i class="fa fa-plus"></i> Add to Menu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <input id="menu_id" type="hidden" name="id" value="{{ encrypt_decrypt($menu->id) }}">
                <div class="card">
                    <div class="card-header">
                        <div class="form-group m-b-0">
                            <label for="menu_name">Menu Name <strong class="text-danger">*</strong> </label>
                            <input id="menu_name" type="text" name="name" value="{{ $menu->name }}" placeholder="Menu Name" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="dd" id="nestable3" style="width: 100%;">
                                    <ol class="dd-list">

                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right bg-white border-top">
                        <button type="button" data-action="{{ route('simple_cms.menu.backend.save_update') }}" title="Save" class="btn btn-sm btn-primary btnSaveMenuNestable"><i class="fas fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_stack')
    <script>
        const resourcesNestable = @json($nestable_menu),
            defaultLocale   = "{{ $default_locale }}",
            currentLocale   = "{{ $currentLanguage->locale }}",
            translatorAvailableLocales = @json($translator_available_locales),
            templateInputLanguageLabel = '<div class="templateInputLanguage">{!! str_replace(['\r', '\n'], '', input_language('label', 'label', 'input', ['class' => 'form-control form-control-sm', 'required' => 'required', 'placeholder' => 'Label'])) !!}</div>',
            templateInputLanguageTitle = '<div class="templateInputLanguage">{!! input_language('title', 'title', 'input', ['class' => 'form-control form-control-sm', 'placeholder' => 'Title Attribute']) !!}</div>';
    </script>
    {!! module_script('core', 'plugins/nestable/js/jquery.nestable.min.js') !!}
    {!! module_script('menu', 'backend/js/index.js') !!}
@endpush
