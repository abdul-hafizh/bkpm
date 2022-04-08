<?php

// use Opis\Closure\SerializableClosure;

return [

    'name' => 'Theme',
    'slug' => 'theme',
    'namespace' => 'SimpleCMS\Theme\\',

    /*
    |--------------------------------------------------------------------------
    | Asset url path
    |--------------------------------------------------------------------------
    |
    | The path to asset, this config can be cdn host.
    | eg. http://cdn.domain.com
    |
    */

    'assetUrl' => env('APP_ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Theme Default
    |--------------------------------------------------------------------------
    |
    | If you don't set a theme when using a "Theme" class
    | the default theme will replace automatically.
    |
    */

    'themeDefault' => env('APP_THEME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Layout Default
    |--------------------------------------------------------------------------
    |
    | If you don't set a layout when using a "Theme" class
    | the default layout will replace automatically.
    |
    */

    'layoutDefault' => 'frontend',

    /*
    |--------------------------------------------------------------------------
    | Path to lookup theme
    |--------------------------------------------------------------------------
    |
    | The root path contains themes collections.
    |
    */

    'themeDir' => 'Themes',


    /*
    |--------------------------------------------------------------------------
    | Namespaces
    |--------------------------------------------------------------------------
    |
    | Class namespace.
    |
    */

    'namespaces' => array(
        'widget' => 'SimpleCMS\Theme\Widgets'
    ),

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities this is cool
    | feature to set up a title, meta, default styles and scripts.
    |
    */

    'events' => array(
        'before' => '',
        'asset' => ''
        // Before all event, this event will effect for global.
        /*'before' => function($theme)
        {
            //$theme->setTitle('Something in global.');
        },*/

        // This event will fire as a global you can add any assets you want here.
        /*'asset' => function($asset)
        {
            // Preparing asset you need to serve after.
            $asset->cook('backbone', function($asset)
            {
                $asset->add('backbone', '//cdnjs.cloudflare.com/ajax/libs/backbone.js/1.0.0/backbone-min.js');
                $asset->add('underscorejs', '//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.4.4/underscore-min.js');
            });

            // To use cook 'backbone' you can fire with 'serve' method.
            // Theme::asset()->serve('backbone');
        }*/

    ),

];
