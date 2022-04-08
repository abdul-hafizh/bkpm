@extends('core::layouts.backend')
@section('title',$title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('simple_cms.acl.backend.user.index') }}" title="Users"> Users</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_select2('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="card">
            <form id="saveUpdateUserForm" data-action="{{ route('simple_cms.acl.backend.user.save_update') }}">
                <div class="card-body">
                    <input type="hidden" name="id" value="{{ encrypt_decrypt($user->id) }}">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="full_name">Full Name</label>
                                <input id="full_name" name="name" type="text" value="{{ $user->name }}" placeholder="Full Name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username" name="username" type="text" value="{{ $user->username }}" placeholder="Username" class="form-control username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" value="{{ $user->email }}" placeholder="Email" class="form-control" required>
                            </div>
                            {!!
                                template_wilayah_negara(
                                    $user->id_negara,
                                    $user->id_provinsi,
                                    $user->id_kabupaten,
                                    $user->id_kecamatan,
                                    $user->id_desa
                                )
                            !!}
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="group_id">Group</label>
                                <select id="group_id" name="group_id" class="form-control" required>
                                    <option value="">--Select--</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" {{ ($group->id == $user->group_id ? 'selected':'') }}>{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role_id">Role</label>
                                <select id="role_id" name="role_id" class="form-control" required>
                                    <option value="">--Select--</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ ($role->id == $user->role_id ? 'selected':'') }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="1" {{ ($user->status ? 'selected':'') }}>Active</option>
                                    <option value="0" {{ (!$user->status ? 'selected':'') }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password {{ (!empty($user->id) ? '[Leave blank if not change]' : '') }}</label>
                                <input id="password" name="password" type="password" value="" placeholder="New Password" class="form-control" {{ (empty($user->id) ? 'required' : '') }}>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">New Password Confirmation</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" value="" placeholder="New Password Confirmation" class="form-control" {{ (empty($user->id) ? 'required' : '') }}>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" class="btn btn-warning btn-sm" onclick="window.location.href='{{ route('simple_cms.acl.backend.user.index') }}'" title="Kembali"><i class="fa fa-arrow-left"></i> Kembali</button>
                    <button type="submit" class="btn btn-primary btn-sm" title="Simpan"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js_stack')
    {!! library_select2('js') !!}
    {!! module_script('core', 'js/event-select2.js') !!}
    {!! module_script('acl','user/js/_form.js') !!}
@endpush
