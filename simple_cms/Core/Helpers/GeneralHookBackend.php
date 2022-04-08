<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 6:52 PM ---------
 */

/**

** Hook action constant core
 * call/load hooks action for tab & tab_content
- simple_cms_core_backend_setting_tab_hook_action
- simple_cms_core_backend_setting_tab_content_hook_action
 *
 * call/load hooks action for setting general tab_content
- simple_cms_core_backend_setting_in_general_hook_action
- simple_cms_core_backend_setting_in_general_left_hook_action
- simple_cms_core_backend_setting_in_general_right_hook_action
 *
 * call/load hooks action for homepage tab_content
- simple_cms_core_backend_setting_in_homepage_hook_action
- simple_cms_core_backend_setting_in_homepage_left_hook_action
- simple_cms_core_backend_setting_in_homepage_right_hook_action
 *
 * call/load hooks action for contact_information tab_content
- simple_cms_core_backend_setting_in_contact_information_hook_action
- simple_cms_core_backend_setting_in_contact_information_left_hook_action
- simple_cms_core_backend_setting_in_contact_information_right_hook_action
 *
 * call/load hooks action for membership tab_content
- simple_cms_core_backend_setting_in_membership_hook_action
- simple_cms_core_backend_setting_in_membership_left_hook_action
- simple_cms_core_backend_setting_in_membership_right_hook_action
 *
** Hook available **

* Hook Action
- simple_cms_core_backend_setting_tab_add_action
- simple_cms_core_backend_setting_tab_content_add_action
 *
- simple_cms_core_backend_setting_in_general_add_action
- simple_cms_core_backend_setting_in_general_left_add_action
- simple_cms_core_backend_setting_in_general_right_add_action
 *
- simple_cms_core_backend_setting_in_homepage_add_action
- simple_cms_core_backend_setting_in_homepage_left_add_action
- simple_cms_core_backend_setting_in_homepage_right_add_action
 *
- simple_cms_core_backend_setting_in_contact_information_add_action
- simple_cms_core_backend_setting_in_contact_information_left_add_action
- simple_cms_core_backend_setting_in_contact_information_right_add_action
 *
- simple_cms_core_backend_setting_in_membership_add_action
- simple_cms_core_backend_setting_in_membership_left_add_action
- simple_cms_core_backend_setting_in_membership_right_add_action

* Hook Filter

* functions

*/

/* general tabs */
if ( ! function_exists('simple_cms_core_backend_setting_tab_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_tab_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_tab_add_action');
    }
}
if ( ! function_exists('simple_cms_core_backend_setting_tab_content_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_tab_content_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_tab_content_add_action');

    }
}

/* General */
if ( ! function_exists('simple_cms_core_backend_setting_in_general_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_general_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_general_add_action');
    }
}
if ( ! function_exists('simple_cms_core_backend_setting_in_general_left_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_general_left_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_general_left_add_action');
    }
}
if ( ! function_exists('simple_cms_core_backend_setting_in_general_right_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_general_right_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_general_right_add_action');
    }
}

/* Homepage */
if ( ! function_exists('simple_cms_core_backend_setting_in_homepage_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_homepage_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_homepage_add_action');
    }
}
if ( ! function_exists('simple_cms_core_backend_setting_in_homepage_left_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_homepage_left_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_homepage_left_add_action');
    }
}
if ( ! function_exists('simple_cms_core_backend_setting_in_homepage_right_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_homepage_right_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_homepage_right_add_action');
    }
}

/* Contact Information */
if ( ! function_exists('simple_cms_core_backend_setting_in_contact_information_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_contact_information_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_contact_information_add_action');
    }
}
if ( ! function_exists('simple_cms_core_backend_setting_in_contact_information_left_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_contact_information_left_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_contact_information_left_add_action');
    }
}
if ( ! function_exists('simple_cms_core_backend_setting_in_contact_information_right_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_contact_information_right_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_contact_information_right_add_action');
    }
}

/* Membership */
if ( ! function_exists('simple_cms_core_backend_setting_in_membership_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_membership_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_membership_add_action');
    }
}
if ( ! function_exists('simple_cms_core_backend_setting_in_membership_left_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_membership_left_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_membership_left_add_action');
    }
}
if ( ! function_exists('simple_cms_core_backend_setting_in_membership_right_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_core_backend_setting_in_membership_right_hook_action()
    {
        return do_action('simple_cms_core_backend_setting_in_membership_right_add_action');
    }
}
