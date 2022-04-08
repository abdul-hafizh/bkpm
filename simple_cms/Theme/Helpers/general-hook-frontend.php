<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 6:52 PM ---------
 */

/*
** Hook available **

* Hook Action
do_action('simple_cms_theme_meta_tag'); or @hookAction('simple_cms_theme_meta_tag')
do_action('simple_cms_theme_head_script'); or @hookAction('simple_cms_theme_head_script')
do_action('simple_cms_theme_footer_script'); or @hookAction('simple_cms_theme_footer_script')
do_action('simple_cms_theme_header'); or @hookAction('simple_cms_theme_header')
do_action('simple_cms_theme_footer'); or @hookAction('simple_cms_theme_footer')
do_action(''); or @hookAction('')

* Hook Filter
do_filter('simple_cms_theme_copy_right'); or @hookFilter('simple_cms_theme_copy_right')
do_filter('simple_cms_theme_title'); or @hookFilter('simple_cms_theme_title')

* functions

@param string|array $script
@return string
add_theme_footer_script($script);

@param string $menu_slug
@return \Illuminate\Support\Collection
simple_cms_theme_menu_collection($menu_slug)

@param string $menu_slug
@param \SimpleCMS\Menu\Presenters\Presenter $presenter || class menu presenter of theme
@return string
simple_cms_theme_menu($menu_slug, $presenter)

*/

if ( ! function_exists('simple_cms_theme_seo') )
{
    /**
     * @return mixed
     */
    function simple_cms_theme_seo()
    {
        return seo_helper()->render();
    }
}

if ( ! function_exists('simple_cms_theme_head_script') )
{
    /**
     * @return mixed
     */
    function simple_cms_theme_head_script()
    {
        return do_action('simple_cms_theme_head_script');
    }
}

if ( ! function_exists('frontend_style') )
{
    /**
     * @return mixed
     */
    function frontend_style()
    {
        echo simple_cms_setting('frontend_style');
        return;
    }
}
add_action('simple_cms_theme_head_script', 'frontend_style');


if ( ! function_exists('simple_cms_theme_footer_script') )
{
    /**
     * @return mixed
     */
    function simple_cms_theme_footer_script()
    {
        return do_action('simple_cms_theme_footer_script');
    }
}
if ( ! function_exists('frontend_script') )
{
    /**
     * @return mixed
     */
    function frontend_script()
    {
        echo simple_cms_setting('frontend_script');
        return;
    }
}
add_action('simple_cms_theme_footer_script', 'frontend_script');

if ( ! function_exists('simple_cms_theme_copy_right') )
{
    /**
     * @return string
     */
    function simple_cms_theme_copy_right()
    {
        $copy_right = simple_cms_setting('theme:copy_right', 'Copyright © 2019');
        $copy_right = '<p>'.$copy_right.'</p>';
        return apply_filter('simple_cms_theme_copy_right', $copy_right);
    }
}


if ( ! function_exists('simple_cms_theme_menu_collection') )
{
    /**
     * @param string $menu_slug
     *
     * @return \Illuminate\Support\Collection
     */
    function simple_cms_theme_menu_collection($menu_slug)
    {
        return getCacheMenu($menu_slug);
    }
}

if ( ! function_exists('simple_cms_theme_menu') )
{
    /**
     * @param string $menu_slug
     * @param \SimpleCMS\Menu\Presenters\Presenter $presenter
     * @return string
     */
    function simple_cms_theme_menu($menu_slug, $presenter)
    {
        $build_menu_presenter = build_menu_presenter($menu_slug);
        return \Menu::render(MENU_FRONTEND, $presenter);
    }
}
