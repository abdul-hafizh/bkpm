<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 02/10/17
 * Time: 3:47
 */

if (! function_exists('module_asset')) {
    function module_asset($name, $path_file = '')
    {
        return Module::asset($name.':'.$path_file);
    }
}

if (! function_exists('module_style')) {
    function module_style($name, $path_file = '', $more_attribute = [])
    {
        array_merge($more_attribute,['rel'=>'stylesheet']);
        return Html::style(module_asset($name,$path_file), $more_attribute);
    }
}

if (! function_exists('module_script')) {
    function module_script($name, $path_file = '', $more_attribute = [])
    {
        return Html::script(module_asset($name,$path_file), $more_attribute);
    }
}

if (! function_exists('module_config')) {
    function module_config($key)
    {
        if ( config()->has($key) ) {
            return config($key);
        }
        return \Module::config($key);
    }
}

if( ! function_exists('hasModule') )
{
    function hasModule($module) : string
    {
        return Module::has($module);
    }
}

if( ! function_exists('hasActiveModule') )
{
    function hasActiveModule($module) : string
    {
        return Module::has($module);
    }
}

if( ! function_exists('hasRoute') )
{
    function hasRoute($route_name) : string
    {
        return \Route::has($route_name);
    }
}

if(!function_exists('errorPage'))
{
    function errorPage($errorPageCode='404',$view='core')
    {
        if(function_exists('theme_template')){
            return theme_template('errors.'.$errorPageCode);
        }
        return $view.'::errors.'.$errorPageCode;
    }
}