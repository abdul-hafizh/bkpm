@extends('acl::user.user-management')
@section('title','Profile')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Profile"> Profile</a></li>
@endsection
@push('css_stack')
    {!! module_style('core','plugins/colorbox/colorbox.css') !!}
    {!! library_select2('css') !!}
@endpush
@section('partial')
    <form id="updateProfileForm" data-action="{{ route('simple_cms.acl.backend.user.update_profile') }}" data-method="PUT" class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" value="{{ auth()->user()->username }}" placeholder="Username" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input id="full_name" name="name" type="text" value="{{ auth()->user()->name }}" placeholder="Full Name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ auth()->user()->email }}" placeholder="Email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mobile_phone">No Mobile Phone</label>
                <input id="mobile_phone" type="text" name="mobile_phone" value="{{ auth()->user()->mobile_phone }}" class="form-control" placeholder="No Mobile Phone" required>
                <small class="text-info">Wajib diisi dan tidak akan ditampilkan di publik</small>
            </div>
            {!!
                template_wilayah_negara(
                    auth()->user()->id_negara,
                    auth()->user()->id_provinsi,
                    auth()->user()->id_kabupaten,
                    auth()->user()->id_kecamatan,
                    auth()->user()->id_desa
                )
            !!}
        </div>
        <div class="col-6">

            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" class="form-control" placeholder="Address" required>{{ auth()->user()->address }}</textarea>
            </div>
            <div class="form-group">
                <label for="postal_code">Postal Code</label>
                <input id="postal_code" type="text" name="postal_code" value="{{ auth()->user()->postal_code }}" class="form-control" placeholder="Postal Code">
            </div>
            <div class="form-group">
                <label for="avatar">Avatar</label>
                <br/>
                <img id="view_avatar" class="profile-user-img img-fluid img-circle"
                     src="{{ auth()->user()->getAvatar() }}"
                     alt="{{ auth()->user()->name }}">

                <div class="input-group mt-2">
                    <input id="avatar" type="text" name="avatar" class="form-control" value="{{ auth()->user()->getAvatar() }}" placeholder="Link">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-info btn-flat modalFileManager" data-inputid="avatar"><i class="fas fa-file-picture-o"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">

        </div>

        <div class="col-6">

            <div class="form-group">
                <label for="current_password">Current Password <small> [Input current password]</small></label>
                <input id="current_password" name="current_password" type="password" value="" placeholder="Current Password" class="form-control" required>
            </div>
        </div>

        <div class="col-12 text-right">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection

@push('js_stack')
    {!! library_select2('js') !!}
    {!! library_tinymce('js') !!}
    {!! module_script('core', 'plugins/jquery-validation/jquery.validate.min.js') !!}
    {!! module_script('core', 'plugins/jquery-validation/additional-methods.min.js') !!}
    {!! module_script('core','plugins/colorbox/jquery.colorbox-min.js') !!}
    {!! filemanager_standalonepopup() !!}
    {!! module_script('acl','user/js/update-profile.js') !!}
@endpush
