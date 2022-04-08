<?php

if ( !function_exists('themeActive') )
{
    function themeActive()
    {
        $themeActive = simple_cms_setting('theme_active', 'clean_bootstrap');
        $theme = app('theme');
        if(!$theme->exists($themeActive)){
            if(!$theme->exists(env('APP_THEME'))){
                \Log::error('There is no active theme or the theme is not installed correctly');
                throw new \Exception('There is no active theme or the theme is not installed correctly.');
            }
            $themeActive = simple_cms_setting('theme_active', env('APP_THEME'));
        }
        config()->set('theme.themeDefault',$themeActive);
        return $themeActive;
    }
}

if (!function_exists('theme')){
    /**
     * Get the theme instance.
     *
     * @param  string  $themeName
     * @param  string  $layoutName
     * @return \SimpleCMS\Theme\Theme
     */
    function theme($themeName = null, $layoutName = null){
        $theme = app('theme');
        $theme->theme(themeActive());
        if ($themeName){
            $theme->theme($themeName);
        }

        if ($layoutName){
            $theme->layout($layoutName);
        }

        return $theme;
    }
}

if (! function_exists('theme_asset')) {
    /**
     * @param string $path_file
     * @param string $theme
     * @return string
     */
    function theme_asset(string $path_file, string $theme = null)
    {
        $themePath = themeActive();
        if ($theme != null OR !empty($theme)){
            $themePath = $theme;
        }
        return asset('themes/'.$themePath.'/'.$path_file);
    }
}

if (! function_exists('theme_style')) {
    /**
     * @param string $path_file
     * @param string $theme
     * @param array $attributes
     * @return string
     */
    function theme_style(string $path_file, array $attributes = [], string $theme = null)
    {
        array_merge($attributes,['rel'=>'stylesheet']);
        return Html::style(theme_asset($path_file, $theme), $attributes);
    }
}

if (! function_exists('theme_script')) {
    /**
     * @param string $path_file
     * @param string $theme
     * @param array $attributes
     * @return string
     */
    function theme_script(string $path_file, array $attributes = [], string $theme = null)
    {
        return Html::script(theme_asset($path_file, $theme), $attributes);
    }
}

if (! function_exists('theme_widget')) {
    /**
     * @param string $widget
     * @param string $theme
     * @return string
     */
    function theme_widget(string $widget, string $theme = null)
    {
        $themePath = themeActive();
        if ($theme != null OR !empty($theme)){
            $themePath = $theme;
        }
        return "themes.{$themePath}.widgets.{$widget}";
    }
}

if (!function_exists('protectEmail')){
    /**
     * Protect the Email address against bots or spiders that
     * index or harvest addresses for sending you spam.
     *
     * @param  string  $email
     * @return string
     */
    function protectEmail($email) {
        $p = str_split(trim($email));
        $new_mail = '';

        foreach ($p as $val) {
            $new_mail .= '&#'.ord($val).';';
        }

        return $new_mail;
    }
}
