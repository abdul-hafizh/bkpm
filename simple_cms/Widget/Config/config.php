<?php

return [
    'name' => 'Widget',
    'slug' => 'widget',
    'namespace' => 'SimpleCMS\Widget\\',

    'default_namespace' => 'Widgets',

    'use_jquery_for_ajax_calls' => false,

    /*
    * Set Ajax widget middleware
    */
    'route_middleware' => ['web'],

    /*
    * Relative path from the base directory to a regular widget stub.
    */
    'widget_stub'  => module_path('Widget', 'Console/stubs/widget.stub'),

    /*
    * Relative path from the base directory to a plain widget stub.
    */
    'widget_plain_stub'  => module_path('Widget', 'Console/stubs/widget_plain.stub'),
];
