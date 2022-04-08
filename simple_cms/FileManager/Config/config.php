<?php

return [
    'name' => 'FileManager',
    'slug' => 'filemanager',
    'namespace' => 'SimpleCMS\FileManager\\',

    /*
    |--------------------------------------------------------------------------
    | Upload dir
    |--------------------------------------------------------------------------
    |
    | The dir where to store the images (relative from public)
    |
    */
    'tinymce' => env('TINYMCE_VERSION', '5'),


    /*
    |--------------------------------------------------------------------------
    | Upload dir
    |--------------------------------------------------------------------------
    |
    | The dir where to store the images (relative from public)
    |
    */
    'dir' => ['files'],

    /*
    |--------------------------------------------------------------------------
    | Filesystem disks (Flysytem)
    |--------------------------------------------------------------------------
    |
    | Define an array of Filesystem disks, which use Flysystem.
    | You can set extra options, example:
    |
    | 'my-disk' => [
    |        'URL' => url('to/disk'),
    |        'alias' => 'Local storage',
    |    ]
    */
    'disks' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Routes group config
    |--------------------------------------------------------------------------
    |
    | The default group settings for the elFinder routes.
    |
    */

    'route' => [
        'prefix' => 'file-manager',
        'middleware' => array('web', 'auth','permission', 'filemanager'), //Set to null to disable middleware filter
    ],

    /*
    |--------------------------------------------------------------------------
    | Access filter
    |--------------------------------------------------------------------------
    |
    | Filter callback to check the files
    |
    */

    'access' => 'SimpleCMS\FileManager\Elfinder::checkAccess',

    /*
    |--------------------------------------------------------------------------
    | Roots
    |--------------------------------------------------------------------------
    |
    | By default, the roots file is LocalFileSystem, with the above public dir.
    | If you want custom options, you can set your own roots below.
    |
    */

    'roots' => null,

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with 'roots' and passed to the Connector.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1
    |
    */

    'options' => array(),

    /*
    |--------------------------------------------------------------------------
    | Root Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with every root by default.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1#root-options
    |
    */
    'root_options' => array(
        'uploadMaxSize' => '50M',
        'uploadAllow' => array(
            /*'image/x-icon',
            'image/jpg',
            'image/jpeg',
            'image/png',
            'video/x-msvideo',
            'video/quicktime',
            'video/mp4',*/
            'image',
            'video',
            'audio',
            'application/zip',
            'application/pdf',
            'application/wps-office.docx',
            'application/wps-office.doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-word',
            'application/msword',
            'application/vnd.ms-excel',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.openxmlformats-officedocument.presentationml.template',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation')
    ),
];
