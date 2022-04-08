@extends('acl::user.user-management')
@section('title','Password')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Password"> Password</a></li>
@endsection

@section('partial')
    <form id="updatePasswordForm" data-action="{{ route('simple_cms.acl.backend.user.update_password') }}" data-method="PUT" class="row">
        <div class="col-6 mx-auto">
            <div class="form-group">
                <label for="current_password">Current Password<small> [Input current password]</small></label>
                <input id="current_password" name="current_password" type="password" value="" placeholder="Current Password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input id="password" name="password" type="password" value="" placeholder="New Password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">New Password Confirmation</label>
                <input id="password_confirmation" name="password_confirmation" type="password" value="" placeholder="New Password Confirmation" class="form-control" required>
            </div>
        </div>

        <div class="col-12 text-right">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection

@push('js_stack')
    {!! module_script('core', 'plugins/jquery-validation/jquery.validate.min.js') !!}
    {!! module_script('core', 'plugins/jquery-validation/additional-methods.min.js') !!}
    {!! module_script('acl','user/js/password.js') !!}
@endpush