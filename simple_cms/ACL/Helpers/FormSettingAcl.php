<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 10:46 AM ---------
 */

if ( ! function_exists('simple_cms_auth_backend_setting_membership_to_general') )
{
    function simple_cms_auth_backend_setting_membership_to_general()
    {
        $user_group     = default_user_group();
        $user_role      = default_user_role();
        $user_status    = default_user_status();
        $account_verify = account_verify();
        $can_register   = can_register();

        $select_user_group = '';
        foreach (\SimpleCMS\ACL\Models\GroupModel::select('id','name', 'deleted_at')->where('id', '>', 1)->orderBy('name', 'ASC')->cursor() as $group) {
            $select_user_group .= '<option value="' . $group->id . '" '. ($user_group == $group->id ? 'selected':'') .'>'. $group->name .'</option>';
        }
        $select_user_role = '';
        foreach (\SimpleCMS\ACL\Models\RoleModel::select('id','name', 'deleted_at')->where('id', '>', 1)->orderBy('name', 'ASC')->cursor() as $role) {
            $select_user_role .= '<option value="' . $role->id . '" '. ($user_role == $role->id ? 'selected':'') .'>'. $role->name .'</option>';
        }
        $select_user_status = '<option value="1" '.((int)$user_status == 1 ? 'selected':'').'>Active</option><option value="0" '.((int)$user_status == 0 ? 'selected':'').'>Inactive</option>';
        $html = '<div class="col-md-12">
                    <h4 class="border-bottom">Membership</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input checkboxDefault" type="checkbox" id="settings-acl-can_register" name="settings[can_register]" value="1" '.($can_register ? 'checked':'').'>
                                    <input type="hidden" name="settings[can_register]" value="0" disabled>
                                    <label for="settings-acl-can_register" class="custom-control-label">Anyone can register</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input checkboxDefault" type="checkbox" id="settings-acl-account_verify" name="settings[account_verify]" value="1" '.($account_verify ? 'checked':'').'>
                                    <input type="hidden" name="settings[account_verify]" value="0" disabled>
                                    <label for="settings-acl-account_verify" class="custom-control-label">Verify account when/after register</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="settings-acl-default_user_status">Default user status when register</label>
                                <select id="settings-acl-default_user_status" name="settings[default_user_status]" class="form-control form-control-sm">
                                '. $select_user_status .'
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="settings-acl-default_user_group">Default user group when register</label>
                                <select id="settings-acl-default_user_group" name="settings[default_user_group]" class="form-control form-control-sm">
                                '. $select_user_group .'
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="settings-acl-default_user_role">Default user role when register</label>
                                <select id="settings-acl-default_user_role" name="settings[default_user_role]" class="form-control form-control-sm">
                                '. $select_user_role .'
                                </select>
                            </div>
                        </div>
                    </div>
            </div>';
        echo $html;
    }
}
add_action('simple_cms_core_backend_setting_in_membership_add_action', 'simple_cms_auth_backend_setting_membership_to_general');

if ( ! function_exists('simple_cms_acl_button_login_social_media') )
{
    /*
     * @param string $type_button
     * @param string $state
     * @return string
     * */
    function simple_cms_acl_button_login_social_media($type_button='block', $state='login')
    {
        \Core::asset()->add('bootstrap-social-button-css', module_asset('core', 'css/bootstrap-social.css'));
        \Theme::asset()->usePath(false)->add('bootstrap-social-button-css', module_asset('core', 'css/bootstrap-social.css'));
        $button_socials = '';
        foreach (app('config')->get('acl.auth_social_media') as $key => $item) {
            if ($item['client_id'] && $item['client_secret'] && $item['redirect']){
                $button_socials .= '<a href="'. url("auth/{$key}/login") .'" class="btn btn-'. $type_button .' btn-social btn-'. $key .'" ><span class="'. $item['icon'] .'"></span> '. trans("core::label.{$state}_with") .' '. ucwords($key) .'</a>';
            }
        }
        echo (!empty($button_socials) ? '<p style="text-align: center;">'.trans('core::label.or').'</p>':''). $button_socials;
        return;
    }
}
function social_button_login()
{
    return simple_cms_acl_button_login_social_media('block', 'login');
}
function social_button_register()
{
    return simple_cms_acl_button_login_social_media('block', 'register');
}
add_action('simple_cms_acl_add_to_form_login_after_hook_action', "social_button_login");
add_action('simple_cms_acl_add_to_form_register_after_hook_action', "social_button_register");
