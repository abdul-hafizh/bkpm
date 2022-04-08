<?php
/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 13 January 2020 0:49 ---------
 */

define('LOG_ACCOUNT', 'LOG_ACCOUNT');

if ( ! function_exists('default_user_group'))
{
    function default_user_group()
    {
     return simple_cms_setting('default_user_group', 4);
    }
}

if ( ! function_exists('default_user_role'))
{
    function default_user_role()
    {
        /*
         *  1 = Super Admin
         *  2 = Admin
         *  3 = Staff
         *  4 = Client / User
         * */
        return simple_cms_setting('default_user_role', 4);
    }
}

if ( ! function_exists('default_user_status'))
{
    function default_user_status()
    {
        return simple_cms_setting('default_user_status', 0);
    }
}

if( ! function_exists('account_verify'))
{
    function account_verify()
    {
        return (bool) simple_cms_setting('account_verify', 0);
    }
}

if( ! function_exists('can_register'))
{
    function can_register()
    {
        return (bool) simple_cms_setting('can_register', 0);
    }
}
