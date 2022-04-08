@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('simple_cms.acl.backend.group.index') }}" title="Groups"> Groups</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')

@endpush
@section('layout')
    <div class="container-fluid">
        <form id="formGroups" data-action="{{ route('simple_cms.acl.backend.group.save_update') }}">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 p-0">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <input type="hidden" name="id" value="{{ $group->id }}" />
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $group->name }}" required/>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="3" class="form-control" placeholder="Description">{{ $group->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-footer text-right">
                    <button type="button" class="btn btn-warning btn-sm" onclick="window.location.href='{{ route('simple_cms.acl.backend.group.index') }}'" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <button type="submit" class="btn btn-primary btn-sm" title="Simpan"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('js_stack')
    {!! module_script('acl','group/js/_form.js') !!}
@endpush