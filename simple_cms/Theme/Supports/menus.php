<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:09 AM ---------
 */

Menu::modify(MENU_ADMINLTE3, function($menu){

    /*$menu->dropdown('Appearance', function ($sub) {
        $sub->add([
            'key'           =>  'simple_cms.theme.backend.index',
            'route'         =>  'simple_cms.theme.backend.index',
            'title'         =>  'Themes',
            'attributes'    => [
                'icon'      =>  'nav-icon fas fa-palette'
            ],
            'active'        =>  ['simple_cms.theme.backend.index']
        ])->hideWhen(function(){
            return !hasRoutePermission([
                'simple_cms.theme.backend.index'
            ]);
        })->order(0);
        $sub->add([
            'key'           =>  'simple_cms.menu.backend.index',
            'route'         =>  'simple_cms.menu.backend.index',
            'title'         =>  'Menu',
            'attributes'    => [
                'icon'      =>  'nav-icon fas fa-list-alt'
            ],
            'active'        =>  ['simple_cms.menu.backend.index', 'simple_cms.menu.backend.add', 'simple_cms.menu.backend.edit']
        ])->hideWhen(function(){
            return !hasRoutePermission([
                'simple_cms.menu.backend.index', 'simple_cms.menu.backend.add', 'simple_cms.menu.backend.edit'
            ]);
        })->order(10);
        $sub->add([
            'key'           =>  'simple_cms.plugin.backend.index',
            'route'         =>  'simple_cms.plugin.backend.index',
            'title'         =>  'Plugins',
            'attributes'    => [
                'icon'      =>  'nav-icon fas fa-plug'
            ],
            'active'        =>  ['simple_cms.plugin.backend.index']
        ])->hideWhen(function(){
            return !hasRoutePermission([
                'simple_cms.plugin.backend.index'
            ]);
        })->order(11);
        $sub->add([
            'key' => 'simple_cms.theme.backend.option',
            'route' => 'simple_cms.theme.backend.option',
            'title' => 'Theme Options',
            'attributes' => [
                'icon' => 'nav-icon fas fa-tools'
            ],
            'active' => ['simple_cms.theme.backend.option']
        ])->hideWhen(function(){
            return (!hasRoutePermission([
                    'simple_cms.theme.backend.option'
            ]) OR !view()->exists('theme_active::views.backend.theme_options'));
        })->order(100);
    },[
        'key'       => 'simple_cms.appearance',
        'icon'      => 'nav-icon fas fa-paint-brush',
        'active'    => [
            'simple_cms.theme.backend.index',
            'simple_cms.menu.backend.index', 'simple_cms.menu.backend.add', 'simple_cms.menu.backend.edit',
            'simple_cms.theme.backend.option',
            'simple_cms.plugin.backend.index'
        ]
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.theme.backend.index',
            'simple_cms.menu.backend.index', 'simple_cms.menu.backend.add', 'simple_cms.menu.backend.edit',
            'simple_cms.theme.backend.option',
            'simple_cms.plugin.backend.index'
        ]);
    })->order(96);*/

    /* search & get dropdown menu for Setting by key */
    $settings = $menu->findBy('key', 'simple_cms.settings.backend');

    $settings_active = [
        'simple_cms.theme.backend.index',
        'simple_cms.menu.backend.index', 'simple_cms.menu.backend.add', 'simple_cms.menu.backend.edit',
        'simple_cms.theme.backend.option',
        'simple_cms.plugin.backend.index'
    ];

    $hideWhen = [
        'simple_cms.theme.backend.index',
        'simple_cms.menu.backend.index', 'simple_cms.menu.backend.add', 'simple_cms.menu.backend.edit',
        'simple_cms.theme.backend.option',
        'simple_cms.plugin.backend.index'
    ];

    /* save ordering menu setting backend */
    $ordering_menu_settings = $settings->order;

    /* set/merge/append active menu setting backend */
    $settings->setActiveProperties($settings_active);

    /* add more menu child in setting backend */

    $settings->child([
        'key'           =>  'simple_cms.theme.backend.index',
        'route'         =>  'simple_cms.theme.backend.index',
        'title'         =>  'Themes',
        'attributes'    => [
            'icon'      =>  'nav-icon fas fa-palette'
        ],
        'active'        =>  ['simple_cms.theme.backend.index']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.theme.backend.index'
        ]);
    })->order(0);
    $settings->child([
        'key'           =>  'simple_cms.menu.backend.index',
        'route'         =>  'simple_cms.menu.backend.index',
        'title'         =>  'Menu',
        'attributes'    => [
            'icon'      =>  'nav-icon fas fa-list-alt'
        ],
        'active'        =>  ['simple_cms.menu.backend.index', 'simple_cms.menu.backend.add', 'simple_cms.menu.backend.edit']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.menu.backend.index', 'simple_cms.menu.backend.add', 'simple_cms.menu.backend.edit'
        ]);
    })->order(10);
    $settings->child([
        'key'           =>  'simple_cms.plugin.backend.index',
        'route'         =>  'simple_cms.plugin.backend.index',
        'title'         =>  'Plugins',
        'attributes'    => [
            'icon'      =>  'nav-icon fas fa-plug'
        ],
        'active'        =>  ['simple_cms.plugin.backend.index']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.plugin.backend.index'
        ]);
    })->order(11);
    $settings->child([
        'key' => 'simple_cms.theme.backend.option',
        'route' => 'simple_cms.theme.backend.option',
        'title' => 'Theme Options',
        'attributes' => [
            'icon' => 'nav-icon fas fa-tools'
        ],
        'active' => ['simple_cms.theme.backend.option']
    ])->hideWhen(function(){
        return (!hasRoutePermission([
                'simple_cms.theme.backend.option'
            ]) OR !view()->exists('theme_active::views.backend.theme_options'));
    })->order(100);

    /* set/define again ordering menu setting backend */
    $settings->hideWhen(function() use($hideWhen){
        return !hasRoutePermission($hideWhen);
    })->order = $ordering_menu_settings;

});
