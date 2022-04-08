<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:09 AM ---------
 */

Menu::modify(MENU_ADMINLTE3, function($menu){

    // $menu->add([
    //     'key'           =>  'simple_cms.filemanager.backend.index',
    //     'route'         =>  'simple_cms.filemanager.backend.index',
    //     'title'         =>  'File Manager',
    //     'attributes'    =>  [
    //         'icon'      =>  'nav-icon fas fa-photo-video'
    //     ],
    //     'active'        =>  ['simple_cms.filemanager.backend.index']
    // ])->hideWhen(function(){
    //     return !hasRoutePermission([
    //         'simple_cms.filemanager.backend.index'
    //     ]);
    // })->order(96);

    /* search & get dropdown menu for Setting by key */
    $settings = $menu->findBy('key', 'simple_cms.settings.backend');

    $settings_active = [
        'simple_cms.filemanager.backend.index'
    ];

    $hideWhen = [
        'simple_cms.filemanager.backend.index'
    ];

    /* save ordering menu setting backend */
    $ordering_menu_settings = $settings->order;

    /* set/merge/append active menu setting backend */
    $settings->setActiveProperties($settings_active);

    /* add more menu child in setting backend */

    $settings->child([
        'key'           =>  'simple_cms.filemanager.backend.index',
        'route'         =>  'simple_cms.filemanager.backend.index',
        'title'         =>  'File Manager',
        'attributes'    =>  [
            'icon'      =>  'nav-icon fas fa-photo-video'
        ],
        'active'        =>  ['simple_cms.filemanager.backend.index']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.filemanager.backend.index'
        ]);
    })->order(96);

    /* set/define again ordering menu setting backend */
    $settings->hideWhen(function() use($hideWhen){
        return !hasRoutePermission($hideWhen);
    })->order = $ordering_menu_settings;

});
