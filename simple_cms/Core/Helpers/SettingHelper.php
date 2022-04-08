<?php
/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 13 January 2020 11:46 ---------
 */

define('LOG_SETTING', 'LOG_SETTING');

if ( ! function_exists('clearCacheSetting'))
{
    function clearCacheSetting($wildcard)
    {
        return simple_cms_setting()->forget($wildcard);
    }
}

if ( ! function_exists('getCacheSetting'))
{
    function getCacheSetting($wildcard, $default='')
    {
        return simple_cms_setting()->getSetting($wildcard, $default);
    }
}

if( ! function_exists('simple_cms_setting'))
{
    function simple_cms_setting ($key='', $default='')
    {
        $setting = app('simple_cms_setting');

        if (!empty($key)){
            return $setting->getSetting($key,$default);
        }
        return $setting;
    }
}

if( ! function_exists('get_logo'))
{
    function get_logo()
    {
        return simple_cms_setting('site_logo', str_replace(['http://', 'https://'], '//', asset('simple-cms/core/images/logo.png')));
    }
}
if( ! function_exists('site_logo'))
{
    function site_logo()
    {
        return get_logo();
    }
}

if( ! function_exists('get_favicon'))
{
    function get_favicon()
    {
        return simple_cms_setting('site_favicon', str_replace(['http://', 'https://'], '//', asset('simple-cms/core/images/favicon.ico')));
    }
}
if( ! function_exists('site_favicon'))
{
    function site_favicon()
    {
        return get_favicon();
    }
}

if( ! function_exists('get_app_name'))
{
    function get_app_name()
    {
        return simple_cms_setting('site_name', config('app.name'));
    }
}

if( ! function_exists('site_name'))
{
    function site_name()
    {
        return get_app_name();
    }
}

if( ! function_exists('site_description'))
{
    function site_description()
    {
        return simple_cms_setting('site_description');
    }
}

if( ! function_exists('site_keyword'))
{
    function site_keyword()
    {
        return simple_cms_setting('site_keyword');
    }
}


if( ! function_exists('site_url'))
{
    function site_url()
    {
        return simple_cms_setting('site_url', url('/'));
    }
}

if( ! function_exists('home_url'))
{
    function home_url()
    {
        return site_url();
    }
}

if( ! function_exists('link_dashboard'))
{
    function link_dashboard()
    {
        return simple_cms_setting('link_dashboard', route('simple_cms.dashboard.backend.index'));
    }
}

if( ! function_exists('force_https'))
{
    function force_https()
    {
        return (bool) simple_cms_setting('force_https', 0);
    }
}
if( ! function_exists('text_footer'))
{
    function text_footer($replace=true)
    {
        $text = simple_cms_setting('text_footer', "© ".periode()." ".site_name().". All rights reserved.");
        if ($replace) {
            $text = str_replace(['%year%', '%site_name%'], [periode(), site_name()], $text);
            return shortcodes($text);
        }
        return $text;
    }
}
