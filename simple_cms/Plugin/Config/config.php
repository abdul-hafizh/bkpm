<?php

return [
    'name' => 'Plugin',
    'slug' => 'plugin',
    'namespace' => 'SimpleCMS\Plugin\\',
    'plugins'   => [
        'cache' => [
            'enabled'   => false,
            'key' => 'simple-cms-plugins',
            'lifetime'  => 120
        ]
    ]
];
