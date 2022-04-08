<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/16/20, 9:07 PM ---------
 */

if ( ! function_exists('widget_repository') )
{
    function widget_repository()
    {
        return \SimpleCMS\Widget\Models\WidgetModel::select('id', 'widget_id', 'group', 'theme', 'position', 'settings');
    }
}

if ( ! function_exists('generate_widget_registered') )
{
    /**
     * @param array $where
     */
    function generate_widget_registered(array $where = [])
    {
        $where = array_merge(['theme' => app('simple_cms_setting')->getSetting('theme_active')], $where);
        $widgets = widget_repository()->where($where)->orderBy('position', 'ASC')->cursor();
        foreach ($widgets as $widget) {
            $widget_setting = (isJson($widget->settings) ? json_decode($widget->settings) : $widget->setttings);
            WidgetGroup::group($widget->group)->position($widget->position)->addWidget($widget->widget_id, $widget_setting);
        }
    }
}

simple_cms_register_group_widget([
    'id'            => 'primary_sidebar',
    'name'          => 'Primary Sidebar',
    'description'   => 'This is a widget for primary sidebar'
]);

simple_cms_register_group_widget([
    'id'            => 'primary_footer_col_1',
    'name'          => 'Primary Footer: Col 1',
    'description'   => 'This is a widget for primary footer col 1'
]);

simple_cms_register_group_widget([
    'id'            => 'primary_footer_col_2',
    'name'          => 'Primary Footer: Col 2',
    'description'   => 'This is a widget for primary footer col 2'
]);

simple_cms_register_group_widget([
    'id'            => 'primary_footer_col_3',
    'name'          => 'Primary Footer: Col 3',
    'description'   => 'This is a widget for primary footer col 3'
]);

simple_cms_register_group_widget([
    'id'            => 'primary_footer_col_4',
    'name'          => 'Primary Footer: Col 4',
    'description'   => 'This is a widget for primary footer col 4'
]);
