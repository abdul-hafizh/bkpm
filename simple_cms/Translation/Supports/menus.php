<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:09 AM ---------
 */

Menu::modify(MENU_ADMINLTE3, function($menu){

    /* search & get dropdown menu for Setting by key */
    $settings = $menu->findBy('key', 'simple_cms.settings.backend');

    $settings_active = [
        'simple_cms.translation.backend.index'
    ];

    /* save ordering menu setting backend */
    $ordering_menu_settings = $settings->order;

    /* set/merge/append active menu setting backend */
    $settings->setActiveProperties($settings_active);

    /* add more menu child in setting backend */
    $settings->child([
        'key'           =>  'simple_cms.translation.backend',
        'route'         =>  'simple_cms.translation.backend.index',
        'title'         =>  'Translation',
        'attributes'    =>  [
            'icon'      =>  'fas fa-language'
        ],
        'active'        =>  [
            'simple_cms.translation.backend.index'
        ]
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.translation.backend.index'
        ]);
    })->order(10);

    /* set/define again ordering menu setting backend */
    $settings->hideWhen(function() use($settings_active){
        return !hasRoutePermission($settings_active);
    })->order = $ordering_menu_settings;

});

