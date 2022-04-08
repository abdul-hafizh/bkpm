@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('simple_cms.acl.backend.role.index') }}" title="Roles & Permission"> Roles & Permission</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')

@endpush
@section('layout')
    <div class="container-fluid">
        <form id="formRolesAndPermission" data-action="{{ route('simple_cms.acl.backend.role.save_update') }}">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 p-0">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <input type="hidden" name="id" value="{{ $role->id }}" />
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required/>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="3" class="form-control" placeholder="Description">{{ $role->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Permissions</h4>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        @php
                            $hasPermission = explode(',',$role->permissions) ?? [];
                            $reformatRoutes = [];
                        @endphp
                        @foreach(Route::getRoutes() as $as => $route)
                            @if(in_array('permission',$route->middleware()) )
                                <div class="col-4" {{ (in_array($route->getName(),config('acl.hide_routes')) && auth()->user()->role_id !=1 ? 'style=display:none;':'') }}>
                                    @php
                                        $moduleName = $route->getAction('simple_cms');
                                        if (empty($moduleName)){
                                            $parseToGetModuleName = explode('.', $route->getName());
                                            $moduleName = $parseToGetModuleName[0];
                                        }
                                        $titleRoute = ($route->getAction('title') ?? $route->uri()) .' ('. $moduleName .')';
                                    @endphp

                                    <div class="card {{ (in_array($route->getName(),$hasPermission) ? 'bg-success':'') }} pointer-cursor" title="{{ $titleRoute }}">
                                        <div class="card-body p-5 checkPermission">
                                            <h5 class="m-b-1 text-ellipsis">
                                                <input type="checkbox" name="permissions[]" class="checkedPermission d-none" value="{{ $route->getName() }}" {{ (in_array($route->getName(),$hasPermission) ? 'checked':'') }}>
                                                {{ $titleRoute }}
                                            </h5>
                                            <ul class="fa-ul f-s-13">
                                                <li><i class="fa-li fas fa-link"></i> <div class="text-ellipsis">{{ url('/').'/'.$route->uri() }}</div></li>
                                                <li><i class="fa-li fas fa-bookmark"></i> <div class="text-ellipsis">{{ $route->getName() }}</div></li>
                                                <li><i class="fa-li fas fa-send"></i> {{ $route->methods()[0] }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-footer text-right">
                    <button type="button" class="btn btn-warning btn-sm" onclick="window.location.href='{{ route('simple_cms.acl.backend.role.index') }}'" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <button type="submit" class="btn btn-primary btn-sm" title="Simpan"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('js_stack')
    {!! module_script('acl','role/js/_form.js') !!}
@endpush