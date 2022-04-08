@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! module_style('core', 'plugins/colorbox/colorbox.css') !!}
    {!! module_style('core', 'plugins/selectivity/3.1.0/css/selectivity-jquery.min.css') !!}
    {!! library_datepicker('css') !!}
    {!! library_select2('css') !!}
    {!! module_style('core', 'plugins/jquery-treeview/style.css') !!}
    <style>
        #treeViewCategory{ max-height: 250px; overflow-x: auto; }
        .treeview ul li input {
            cursor: pointer;
        }
    </style>
@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-12">
                <a class="btn btn-warning btn-sm" href="{{ route('simple_cms.blog.backend.post.index') }}" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</a>
                @if($post->id != '')
                    <a class="btn btn-primary btn-sm" href="{{ route('simple_cms.blog.backend.post.add') }}" title="New Post"><i class="fa fa-plus"></i> New Post</a>
                @endif
            </div>
        </div>
        <form id="formPostAddEdit" class="row" data-action="{{ route('simple_cms.blog.backend.post.save_update') }}">
            <div class="col-md-9">
                <div class="form-group">
                    <label>Title <strong class="text-danger">*</strong></label>
                    {!! input_language('title', 'title', 'input', ['class' => 'form-control form-control-sm ' . (empty($post->id) ? 'changeToPrettyUrl':''), 'required' => 'required', 'placeholder' => 'Title'], $post) !!}
                </div>
                <div class="form-group">
                    {{--<div style="white-space:nowrap">
                        <label style="font-weight: normal;"><strong>Permalink</strong> <strong class="text-danger">*</strong> <span class="text-blue"> {{ url('/') }}/</span></label>
                        <input id="slug" name="slug" type="text" class="form-control form-control-noborder d-inline text-blue" style="margin-left: -3px;" value="{{ $post->slug }}" required>
                    </div>--}}
                    <label for="slug"><strong>Permalink</strong> <strong class="text-danger">*</strong></label>
                    <input id="slug" name="slug" type="text" class="form-control form-control-sm toPrettyUrl" value="{{ $post->slug }}" placeholder="Permalink" required>
                </div>
                <div class="form-group">
                    <label for="description">Description <strong class="text-danger">*</strong> </label>
                    {!! input_language('description', 'description', 'textarea', ['class' => 'form-control form-control-sm', 'rows' => '3', 'required' => 'required', 'placeholder' => 'Short Description'], $post) !!}
                    <span class="on-descriptions">210</span>
                </div>

                <div class="form-group">
                    <label for="content">Content <strong class="text-danger">*</strong></label>
{{--                    <hr class="m-0"/>--}}
{{--                    <button type="button" class="btn btn-white show_modal_lg" data-action="{{ route('blogs.admin.bbcode.index',['type'=>'bbcode','modal'=>'open']) }}" data-method="GET" data-value="" title="BBCode List">BBCode List</button>--}}
                    <hr class="m-t-0"/>
                    {!! input_language('content', 'content', 'textarea', ['class' => 'form-control editor fileManagerElfinder', 'required' => 'required', 'placeholder' => 'Type Here..!!'], $post) !!}
                    {{--<textarea id="content" class="form-control editor fileManagerElfinder" name="content" placeholder="Type Here..!!" >{!! html_entity_decode($post->content) !!}</textarea>--}}
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Category <strong class="text-danger">*</strong></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-10">
                        <div id="treeViewCategory" class="treeview">
                            {!! $categories !!}
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thumb Image / Cover</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-10">
                        <div class="form-group">
                            <a href="javascript:void(0)" class="modalFileManager btn btn-primary btn-sm" data-inputid="thumb_image"><i class="fa fa-image"></i> Images</a>
                        </div>
                        <div class="form-group m-b-10">
                            <input id="thumb_image" type="text" name="thumb_image" class="form-control form-control-sm" value="{{ $post->thumb_image }}" placeholder="Link">
                            <div class="view_thumb_image">{!! ($post->thumb_image ? '<div><img src="'.$post->thumb_image.'" class="img-thumbnail" /></div><div><a href="javascript:void(0)" class="removeThumbImage btn btn-danger btn-sm" title="Remove"><i class="fa fa-trash"></i> </a></div>' : '') !!}</div>
                        </div>
                    </div>
                </div>

                {{--<div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tag</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-10">
                        <div class="form-group">
                            <select type="text" id="select2TagsPost" name="tags[]" multiple class="form-control form-control-sm select2TagsPost">
                                @if ($post->tags)
                                    @foreach($post->tags as $tag)
                                        <option value="{{ $tag->name }}" selected>{{ $tag->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>--}}

                @if(auth()->user()->id <= 2)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Author <span class="text-danger">*</span> </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-10">
                            <div class="form-group">
                                <select type="text" name="user_id" class="form-control form-control-sm select2InitB4" required>
                                    @foreach($authors as $author)
                                        @if($author->id > 1)
                                            <option value="{{ $author->id }}" {{ ($author->id == $post->user_id ? 'selected': (auth()->user()->id == $author->id ? 'selected':'') ) }}>{{ $author->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Publish</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-10">
                        <input type="hidden" name="id" value="{{ encrypt_decrypt($post->id) }}">
                        <input type="hidden" name="type" value="{{ $post_type }}">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control form-control-sm" required>
                                @if(auth()->user()->group_id <= 2)
                                    <option value="publish" {{ ($post->status == 'publish' ? 'selected' : '') }}>Publish</option>
                                    <option value="member" {{ ($post->status == 'member' ? 'selected' : '') }}>Member</option>
                                    <option value="draft" {{ ($post->status == 'draft' ? 'selected' : '') }}>Draft</option>
                                    <option value="rejected" {{ ($post->status == 'rejected' ? 'selected' : '') }}>Rejected</option>
                                @else
                                    @if($post->status == 'publish')
                                        <option value="publish" selected>Published</option>
                                    @else
                                        <option value="submission" {{ ($post->status == 'submission' ? 'selected' : '') }}>Submission</option>
                                        <option value="draft" {{ ($post->status == 'draft' ? 'selected' : '') }}>Draft</option>
                                    @endif
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="post_date">Post Date <strong class="text-danger">*</strong></label>
                            <input id="post_date" type="text" name="created_at" value="{{ ($post->created_at != '' ? date('d-m-Y H:i',strtotime($post->created_at)) : date('d-m-Y H:i')) }}" class="form-control form-control-sm datetimepicker">
                        </div>
                        {{--<div class="form-group">
                            <input id="comments" type="checkbox" name="comments" value="1" {{ ($post->comments == '1' ? 'checked':'') }}>
                            <label for="comments" class="hover">Active Comment</label>
                        </div>--}}
                        <div class="form-group">
                            <input id="full_page" type="checkbox" name="full_page" value="1" {{ ($post->full_page == '1' ? 'checked':'') }}>
                            <label for="full_page" class="hover">Full Page ( Hide Sidebar )</label>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        @if (hasRoute('simple_cms.blog.backend.post.preview') && hasRoutePermission('simple_cms.blog.backend.post.preview'))
{{--                            <button id="btnPreview" type="button" class="btn btn-secondary btn-sm" data-value='@json(['preview'=>true,'has_id'=>!empty($post->id)])' title="Preview"><i class="fa fa-eye"></i> Preview</button>--}}
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm" title="Save"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js_stack')
    <script>
        var templeteTinyMCE = "";
        var dataTreeViewCategoryChecked = @json($hasCategories);
    </script>
    {!! library_select2('js') !!}
    {!! library_datepicker('js') !!}
    {!! module_script('core', 'plugins/jquery-treeview/logger.js') !!}
    {!! module_script('core', 'plugins/jquery-treeview/treeview.js') !!}

    {!! library_tinymce('js') !!}

    {!! module_script('core', 'plugins/colorbox/jquery.colorbox-min.js') !!}
    {!! filemanager_standalonepopup() !!}

    {!! module_script('blog', 'post/backend/js/add_edit.js') !!}
@endpush
