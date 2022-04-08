<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/10/20, 3:16 PM ---------
 */

/*
 ** Function
 * * call/load hooks action for tab & tab_content
 * - simple_cms_blog_backend_setting_tab_hook_action
 * - simple_cms_blog_backend_setting_tab_content_hook_action
 *
 * * call/load hooks action for setting general tab_content
 * - simple_cms_blog_backend_setting_in_general_hook_action
 * - simple_cms_blog_backend_setting_in_general_left_hook_action
 * - simple_cms_blog_backend_setting_in_general_right_hook_action
 *
 * ** Hook available **
 * Hook Action
 * - simple_cms_blog_backend_setting_tab_add_action
 * - simple_cms_blog_backend_setting_tab_content_add_action
 *
 * - simple_cms_blog_backend_setting_in_general_add_action
 * - simple_cms_blog_backend_setting_in_general_left_add_action
 * - simple_cms_blog_backend_setting_in_general_right_add_action
 * */

/* Tab & Tab Content */
if ( ! function_exists('simple_cms_blog_backend_setting_tab_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_blog_backend_setting_tab_hook_action()
    {
        return do_action('simple_cms_blog_backend_setting_tab_add_action');
    }
}
if ( ! function_exists('simple_cms_blog_backend_setting_tab_content_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_blog_backend_setting_tab_content_hook_action()
    {
        return do_action('simple_cms_blog_backend_setting_tab_content_add_action');

    }
}

/* General */
if ( ! function_exists('simple_cms_blog_backend_setting_in_general_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_blog_backend_setting_in_general_hook_action()
    {
        return do_action('simple_cms_blog_backend_setting_in_general_add_action');
    }
}
if ( ! function_exists('simple_cms_blog_backend_setting_in_general_left_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_blog_backend_setting_in_general_left_hook_action()
    {
        return do_action('simple_cms_blog_backend_setting_in_general_left_add_action');
    }
}
if ( ! function_exists('simple_cms_blog_backend_setting_in_general_right_hook_action') )
{
    /**
     * @return mixed
     */
    function simple_cms_blog_backend_setting_in_general_right_hook_action()
    {
        return do_action('simple_cms_blog_backend_setting_in_general_right_add_action');
    }
}
