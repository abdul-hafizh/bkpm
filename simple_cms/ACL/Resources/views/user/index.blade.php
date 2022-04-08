@extends('core::layouts.backend')
@section('title','Users')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Users"> Users</a></li>
@endsection
@push('css_stack')
    {!! library_datatables('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body pad">
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
            @if (hasRoutePermission('simple_cms.acl.backend.user.import'))
                <form id="formImportUsers" data-action="{{ route('simple_cms.acl.backend.user.import') }}" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="import_users">Import users (xls,xlsx)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="file" class="custom-file-input" id="import_users" required>
                                        <label class="custom-file-label" for="import_users">Choose file</label>
                                    </div>
                                </div>
                                <div class="progress progress-sm progress-upload d-none">
                                    <div class="progress-bar bg-info progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                        <span class="progress-upload-text">0%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! download(module_asset('acl', 'user/file/format_import_users.xlsx'), '', true) !!}
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-sm btn-primary" title="Import users"><i class="fas fa-file-import"></i> Import</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
@push('js_stack')
    {!! module_script('core', 'plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    {!! module_script('core','js/events.js') !!}
    {!! module_script('acl','user/js/import.js') !!}
@endpush
