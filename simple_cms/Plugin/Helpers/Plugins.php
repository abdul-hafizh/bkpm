<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 5:31 AM ---------
 */

if ( ! function_exists('plugins_asset') )
{
    /**
     * @param string $plugin_name
     * @param string $path_file
     * @return string
     */
    function plugins_asset($plugin_name, $path_file)
    {
        $plugin_name = \Str::lower($plugin_name);
        $plugin_path = public_path('plugins/'.$plugin_name);
        if (app('files')->exists($plugin_path)) {
            return asset('plugins/'.$plugin_name.'/'.$path_file);
        }
        return '';
    }
}

if ( ! function_exists('plugins_style') )
{
    /**
     * @param string $plugin_name
     * @param string $path_file
     * @return string
     */
    function plugins_style($plugin_name, $path_file)
    {
        $asset = plugins_asset($plugin_name, $path_file);
        if (!empty($asset)) {
            return \Html::style($asset);
        }
        return '';
    }
}

if ( ! function_exists('plugins_script') )
{
    /**
     * @param string $plugin_name
     * @param string $path_file
     * @return string
     */
    function plugins_script($plugin_name, $path_file)
    {
        $asset = plugins_asset($plugin_name, $path_file);
        if (!empty($asset)) {
            return \Html::script($asset);
        }
        return '';
    }
}
