<?php

return [
    'name' => 'Shortcode',
    'slug' => 'shortcode',
    'namespace' => 'SimpleCMS\Shortcode\\',

    /*
    |--------------------------------------------------------------------------
    | Trow exeptions
    |--------------------------------------------------------------------------
    |
    | True to throw exceptions, false to render exception message in place of
    | shortcode.
    |
    */

    'throw_exceptions' => true,

    /*
    |--------------------------------------------------------------------------
    | Automatically render views
    |--------------------------------------------------------------------------
    |
    | If it should automatically render shortcodes in views.
    |
    */

    'render_views' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Debugbar integration
    |--------------------------------------------------------------------------
    |
    | If it should integrate in the Laravel Debug Bar.
    |
    */

    'debugbar' => true,
];
