@extends('core::layouts.backend')
@section('title','Sliders')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Sliders"> Sliders</a></li>
@endsection
@push('css_stack')

@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-primary btn-sm" href="{{ route('simple_cms.slider.backend.add') }}" title="Add New Slider" ><i class="fas fa-plus"></i> New Slider</a>
                    </div>
                    <div class="col-md-6">
                        <h4>Note!</h4>
                        <p>Anda bisa melakukan sorter dengan cara men-drag pada judul.</p>
                    </div>
                </div>
            </div>

            <form id="sortableSlider" data-action="{{ route('simple_cms.slider.backend.save_update',['sorter'=>true]) }}" class="col-md-12">
                @foreach($sliders as $slider)
                    <div class="card" data-sortable="false">
                        <div class="card-header">
                            <h4 class="card-title">{{ $slider->title }}</h4>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" onclick="window.location.href='{{ route('simple_cms.slider.backend.edit',['id'=>encrypt_decrypt($slider->id),'slug'=>\Str::slug($slider->title,'-')]) }}'" class="btn text-warning btn-tool" title="Edit {{ $slider->title }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn text-danger btn-tool forceDeleteTool" data-action="{{ route('simple_cms.slider.backend.force_delete') }}" data-value='@json(['id'=>encrypt_decrypt($slider->id)])' title="Delete Permanent {{ $slider->title }}"><i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="sorter[]" value="{{ $slider->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    @if(!empty($slider->cover))
                                        <div style="width: 100%; height: 330px;">
                                            <img src="{{ $slider->cover }}" style="object-fit: cover;width: 100%;height: 100%;border: 1px solid rgba(0,0,0,.125);" alt="{{ $slider->title }}">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title :</label>
                                        {!! view_language('title', $slider) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Content :</label>
                                        {!! shortcodes(view_language('description', $slider)) !!}
                                    </div>
                                    {{--<div class="form-group">
                                        <label>Link/Url :</label>
                                        <br/>
                                        {{ ($slider->link ? $slider->link : '-') }}
                                    </div>
                                    <div class="form-group">
                                        <label>Target Link/Url :</label>
                                        <br/>
                                        {{ ($slider->target_link == '_self' ? 'Self ( None )' : '_blank ( New Tab )') }}
                                    </div>--}}
                                    <div class="form-group">
                                        <label>Status :</label>
                                        <br/>
                                        {{ ucwords($slider->status) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('simple_cms.slider.backend.edit',['id'=>encrypt_decrypt($slider->id),'slug'=>\Str::slug($slider->title,'-')]) }}" class="btn btn-xs btn-warning" title="Edit {{ $slider->title }}"><i class="fas fa-edit"></i> Edit</a>
                            <a href="javascript:void(0);" class="btn btn-xs btn-danger forceDelete" data-action="{{ route('simple_cms.slider.backend.force_delete') }}" data-value='@json(['id'=>encrypt_decrypt($slider->id)])' title="Delete Permanent {{ $slider->title }}"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>
                @endforeach
            </form>

        </div>
    </div>
@endsection

@push('js_stack')
    {!! module_script('slider', 'backend/js/index.js') !!}
@endpush
