<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/15/20, 11:45 PM ---------
 */


if (!function_exists('simple_cms_register_widget')) {
    /**
     * @param $widget_id
     */
    function simple_cms_register_widget($widget_id)
    {
        Widget::registerWidget($widget_id);
    }
}

if (!function_exists('simple_cms_register_group_widget')) {
    /**
     * @param $args
     */
    function simple_cms_register_group_widget($args)
    {
        WidgetGroup::setGroup($args);
    }
}

if (!function_exists('simple_cms_remove_group_widget')) {
    /**
     * @param $group
     */
    function simple_cms_remove_group_widget($group)
    {
        WidgetGroup::removeGroup($group);
    }
}

if (!function_exists('simple_cms_get_group_widget')) {
    /**
     * @param $group
     * @return mixed
     */
    function simple_cms_get_group_widget($group)
    {
        return WidgetGroup::group($group)->display();
    }
}

if (!function_exists('simple_cms_get_primary_sidebar')) {
    /**
     * @return mixed
     */
    function simple_cms_get_primary_sidebar()
    {
        return simple_cms_get_group_widget('primary_sidebar');
    }
}

if (!function_exists('simple_cms_get_primary_footer_col_1')) {
    /**
     * @return mixed
     */
    function simple_cms_get_primary_footer_col_1()
    {
        return simple_cms_get_group_widget('primary_footer_col_1');
    }
}

if (!function_exists('simple_cms_get_primary_footer_col_2')) {
    /**
     * @return mixed
     */
    function simple_cms_get_primary_footer_col_2()
    {
        return simple_cms_get_group_widget('primary_footer_col_2');
    }
}

if (!function_exists('simple_cms_get_primary_footer_col_3')) {
    /**
     * @return mixed
     */
    function simple_cms_get_primary_footer_col_3()
    {
        return simple_cms_get_group_widget('primary_footer_col_3');
    }
}

if (!function_exists('simple_cms_get_primary_footer_col_4')) {
    /**
     * @return mixed
     */
    function simple_cms_get_primary_footer_col_4()
    {
        return simple_cms_get_group_widget('primary_footer_col_4');
    }
}
