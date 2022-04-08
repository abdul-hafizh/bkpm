<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists, this
    | is work with "layouts", "partials", "views" and "widgets"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities this is cool
    | feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => array(

        'before' => function($theme)
        {
            $theme->setTitle(site_name());
            $theme->setAuthor('Jonh Doe');
        },

        'asset' => function($asset)
        {
            $asset->container('head')->usePath()->add('styling', 'css/style.css');

            $asset->container('head')->usePath(false)->add('font-awesome-css', library_icons('css', 1, 'font-awesome'));
            $asset->container('head')->usePath(false)->add('sweetalert2-css', module_asset('core','plugins/sweetalert2/css/sweetalert2.min.css'));
            $asset->container('head')->usePath(false)->add('jquery-ui-css', module_asset('core','plugins/jquery-ui/jquery-ui.min.css'));

            $asset->container('head')->usePath(false)->add('jquery-js', module_asset('core','plugins/jquery/jquery.min.js'));
            $asset->container('head')->usePath(false)->add('jquery-ui-js', module_asset('core','plugins/jquery-ui/jquery-ui.min.js'));
            $asset->container('head')->usePath(false)->add('sweetalert2-js', module_asset('core','plugins/sweetalert2/js/sweetalert2.all.min.js'));
            $asset->container('head')->usePath(false)->add('smple-cms-js', module_asset('core','js/simple-cms.js'));
            $asset->container('head')->usePath(false)->add('global-js', module_asset('core','js/global.js'));


            $asset->container('footer')->usePath(false)->add('bootstap-4-js', library_bootstrap('js', true));
            $asset->container('footer')->usePath()->add('script', 'js/script.js');
            /*$asset->container('footer')->usePath()->add('core-js', 'js/core.min.js');
            $asset->container('footer')->usePath()->add('app-js', 'js/app.min.js');
            $asset->container('footer')->usePath()->add('demo-js', 'js/demo.js');
            $asset->add([
                ['style',
                    [

                        module_asset('core','icons/font-awesome/css/all.min.css'),
                        module_asset('core','icons/font-awesome-v4.7/css/font-awesome.min.css'),
                        module_asset('core','plugins/sweetalert2/css/sweetalert2.min.css'),
                        module_asset('core','plugins/jquery-ui/jquery-ui.min.css'),

                        module_asset('core','plugins/jquery/jquery.min.js'),
                        module_asset('core','plugins/jquery-ui/jquery-ui.min.js'),
                        module_asset('core','plugins/sweetalert2/js/sweetalert2.all.min.js'),
                        module_asset('core','js/simple-cms.js'),
                        module_asset('core','js/global.js'),
                    ]
                ],

            ]);*/

            // You may use elixir to concat styles and scripts.
            /*
            $asset->themePath()->add([
                                        ['styles', 'dist/css/styles.css'],
                                        ['scripts', 'dist/js/scripts.js']
                                     ]);
            */

            // Or you may use this event to set up your assets.
            /*
            $asset->themePath()->add('core', 'core.js');
            $asset->add([
                            ['jquery', 'vendor/jquery/jquery.min.js'],
                            ['jquery-ui', 'vendor/jqueryui/jquery-ui.min.js', ['jquery']]
                        ]);
            */
        },


        'beforeRenderTheme' => function($theme)
        {
            // To render partial composer
            /*
            $theme->partialComposer('header', function($view){
                $view->with('auth', Auth::user());
            });
            */

        },

        'beforeRenderLayout' => array(

            'mobile' => function($theme)
            {
                // $theme->asset()->themePath()->add('ipad', 'css/layouts/ipad.css');
            }

        )

    )

);
