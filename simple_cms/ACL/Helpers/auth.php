<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/18/20, 7:47 AM ---------
 */

/**
 * Call function
 * simple_cms_acl_form_login_hook_action
 * simple_cms_acl_form_login_after_hook_action
 * simple_cms_acl_form_register_hook_action
 * simple_cms_acl_form_register_after_hook_action
 * simple_cms_acl_form_reset_password_hook_action
 * simple_cms_acl_form_verify_hook_action
 * simple_cms_acl_form_confirm_password_hook_action
 *
 * Hook Action
 * simple_cms_acl_add_to_form_login_hook_action
 * simple_cms_acl_add_to_form_login_after_hook_action
 * simple_cms_acl_add_to_form_register_hook_action
 * simple_cms_acl_add_to_form_register_after_hook_action
 * simple_cms_acl_add_to_form_reset_password_hook_action
 * simple_cms_acl_add_to_form_confirm_password_hook_action
 *
 * Hook Filter
 * simple_cms_acl_add_to_validation_roles_form_login_add_filter
 * simple_cms_acl_add_to_validation_roles_form_register_add_filter
 * simple_cms_acl_add_to_validation_roles_form_reset_password_add_filter
 * simple_cms_acl_add_to_validation_roles_form_confirm_password_add_filter
 * ============================================
 * simple_cms_acl_add_to_validation_messages_form_login_add_filter
 * simple_cms_acl_add_to_validation_messages_form_register_add_filter
 * simple_cms_acl_add_to_validation_messages_form_reset_password_add_filter
 * simple_cms_acl_add_to_validation_messages_form_confirm_password_add_filter
 *
 */

if ( ! function_exists('simple_cms_acl_form_login_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_acl_form_login_hook_action()
    {
        return do_action('simple_cms_acl_add_to_form_login_hook_action');
    }
}

if ( ! function_exists('simple_cms_acl_form_login_after_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_acl_form_login_after_hook_action()
    {
        return do_action('simple_cms_acl_add_to_form_login_after_hook_action');
    }
}

if ( ! function_exists('simple_cms_acl_form_register_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_acl_form_register_hook_action()
    {
        return do_action('simple_cms_acl_add_to_form_register_hook_action');
    }
}

if ( ! function_exists('simple_cms_acl_form_register_after_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_acl_form_register_after_hook_action()
    {
        return do_action('simple_cms_acl_add_to_form_register_after_hook_action');
    }
}

if ( ! function_exists('simple_cms_acl_form_reset_password_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_acl_form_reset_password_hook_action()
    {
        return do_action('simple_cms_acl_add_to_form_reset_password_hook_action');
    }
}

if ( ! function_exists('simple_cms_acl_form_confirm_password_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_acl_form_confirm_password_hook_action()
    {
        return do_action('simple_cms_acl_add_to_form_confirm_password_hook_action');
    }
}
