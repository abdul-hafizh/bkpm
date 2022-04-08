<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:09 AM ---------
 */

Menu::modify(MENU_ADMINLTE3, function($menu){

    // $menu->add([
    //     'key'           =>  'simple_cms.activitylog.backend.all',
    //     'route'         =>  'simple_cms.activitylog.backend.all',
    //     'title'         =>  'label.activity_log',
    //     'attributes'    =>  [
    //         'icon'      =>  'nav-icon fas fa-history'
    //     ],
    //     'active'        =>  ['simple_cms.activitylog.backend.all']
    // ])->hideWhen(function(){
    //     return !hasRoutePermission([
    //         'simple_cms.activitylog.backend.all'
    //     ]);
    // })->order(99);

    $settings = $menu->findBy('key', 'simple_cms.settings.backend');

    $settings_active = [
        'simple_cms.activitylog.backend.all'
    ];

    $hideWhen = [
        'simple_cms.activitylog.backend.all'
    ];

    /* save ordering menu setting backend */
    $ordering_menu_settings = $settings->order;

    /* set/merge/append active menu setting backend */
    $settings->setActiveProperties($settings_active);

    /* add more menu child in setting backend */

    $settings->child([
        'key'           =>  'simple_cms.activitylog.backend.all',
        'route'         =>  'simple_cms.activitylog.backend.all',
        'title'         =>  'label.activity_log',
        'attributes'    =>  [
            'icon'      =>  'nav-icon fas fa-history'
        ],
        'active'        =>  ['simple_cms.activitylog.backend.all']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.activitylog.backend.all'
        ]);
    })->order(99);

    /* set/define again ordering menu setting backend */
    $settings->hideWhen(function() use($hideWhen){
        return !hasRoutePermission($hideWhen);
    })->order = $ordering_menu_settings;
});
