<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/5/20, 3:45 AM ---------
 */

Menu::modify(MENU_ADMINLTE3, function($menu){

    $menu->add([
        'key'           =>  'simple_cms.guide.backend.index',
        'route'         =>  'simple_cms.guide.backend.index',
        'title'         =>  'label.guide',
        'attributes'    =>  [
            'icon'      =>  'nav-icon fas fa-book'
        ],
        'active'        =>  ['simple_cms.guide.backend.index']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.guide.backend.index'
        ]);
    })->order(199);

    $menu->dropdown('Settings', function ($sub) {
        $sub->add([
            'key'           =>  'simple_cms.setting.backend.index',
            'route'         =>  'simple_cms.setting.backend.index',
            'title'         =>  'General',
            'attributes'    =>  [
                'icon'      =>  'fas fa-tag'
            ],
            'active'        =>  ['simple_cms.setting.backend.index']
        ])->hideWhen(function(){
            return !hasRoutePermission([
                'simple_cms.setting.backend.index'
            ]);
        })->order(0);
    },[
        'key'       => 'simple_cms.settings.backend',
        'icon'      => 'nav-icon fas fa-cogs',
        'active'    => [
            'simple_cms.setting.backend.index'
        ]
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.setting.backend.index'
        ]);
    })->order(99);
    /*$menu->dropdown('Platform Administration', function ($sub) {},[
        'key'       => 'simple_cms.platform_administration.backend',
        'icon'      => 'nav-icon fas fa-shield-alt',
        'active'    => []
    ])->order(100);*/
});



