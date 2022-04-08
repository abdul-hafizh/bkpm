@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! module_style('core', 'plugins/colorbox/colorbox.css') !!}
@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3 justify-content-center">
            <div class="col-xs-12 col-md-6">
                <a class="btn btn-warning btn-sm" href="{{ route('simple_cms.blog.backend.category.index') }}" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                @if($category->id != '')
                    <a class="btn btn-primary btn-sm" href="{{ route('simple_cms.blog.backend.category.add') }}" title="New Category"><i class="fa fa-plus"></i> New Category</a>
                @endif
            </div>
        </div>

        <form id="formAddEditCategory" class="row justify-content-center" data-action="{{ route('simple_cms.blog.backend.category.save_update') }}">
            <div class="col-xs-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ encrypt_decrypt($category->id) }}" />
                        <input type="hidden" name="type" value="{{ $type }}" />
                        <div class="form-group">
                            <label for="name_category">Name <i class="text-danger">*</i></label>
                            {!! input_language('name', 'name', 'input', ['required' => 'required', 'placeholder' => 'Name'], $category) !!}
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug <i class="text-danger">*</i></label>
                            <input id="slug" name="slug" type="text" class="form-control toPrettyUrl" value="{{ $category->slug }}" required>
                        </div>
                        <div class="form-group">
                            <label for="id_parent">Parent Category</label>
                            <select id="id_parent" name="parent_id" class="form-control">
                                <option value="">None</option>
                                @foreach($categories as $ctg)
                                    <option value="{{ $ctg->id }}" {{ ($ctg->id == $category->parent_id ? 'selected':'') }}>{{ trans($ctg->name, [], 'id') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="thumb_image">Thumb Image / Cover</label>
                            <div class="input-group">
                                <input id="thumb_image" type="text" name="thumb_image" class="form-control" value="{{ $category->thumb_image }}" placeholder="Link">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-info modalFileManager" data-inputid="thumb_image"><i class="fa fa-image"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group view_thumb_image"></div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            {!! input_language('description', 'description', 'textarea', ['placeholder' => 'Description'], $category) !!}
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-warning btn-sm btnCancel" title="Cancel"><i class="fa fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm" title="Save"><i class="fa fa-save"></i> Save</button>
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

    {!! module_script('blog', 'category/backend/js/add_edit.js') !!}
@endpush
