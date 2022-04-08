<?php

return [
    'name' => 'LiveEditor',
    'slug' => 'liveeditor',
    'namespace' => 'SimpleCMS\LiveEditor\\',

    'allowed_roots' => [
        '.env'
    ],
    'not_allowed_paths_or_files' => [
        '.git',
        '.idea',
        '.gitignore'
    ]
];
