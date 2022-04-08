<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:09 AM ---------
 */

Menu::modify(MENU_ADMINLTE3, function($menu){

    /*$menu->add([
        'key'           =>  'simple_cms.acl.backend.user.index',
        'route'         =>  'simple_cms.acl.backend.user.index',
        'title'         =>  'Users',
        'attributes'    =>  [
            'icon'      =>  'nav-icon fas fa-users'
        ],
        'active'        =>  ['simple_cms.acl.backend.user.index','simple_cms.acl.backend.user.add','simple_cms.acl.backend.user.edit']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.acl.backend.user.index','simple_cms.acl.backend.user.add','simple_cms.acl.backend.user.edit'
        ]);
    })->order(98);*/

    /* search & get dropdown menu for platform_administration by key */
    $platform_administration = $menu->findBy('key', 'simple_cms.settings.backend');

    $platform_administration_active = [
        'simple_cms.acl.backend.group.index', 'simple_cms.acl.backend.group.add', 'simple_cms.acl.backend.group.edit',
        'simple_cms.acl.backend.role.index','simple_cms.acl.backend.role.add','simple_cms.acl.backend.role.edit',
        'simple_cms.acl.backend.user.index','simple_cms.acl.backend.user.add','simple_cms.acl.backend.user.edit'
    ];

    $hideWhen = [
        'simple_cms.acl.backend.user.index',
        'simple_cms.acl.backend.group.index',
        'simple_cms.acl.backend.role.index'
    ];

    /* save ordering menu setting backend */
    $ordering_menu_platform_administration = $platform_administration->order;

    /* set/merge/append active menu setting backend */
    $platform_administration->setActiveProperties($platform_administration_active);

    /* add more menu child in setting backend */
    $platform_administration->child([
        'key'           =>  'simple_cms.acl.backend.user.index',
        'route'         =>  'simple_cms.acl.backend.user.index',
        'title'         =>  'Users',
        'attributes'    =>  [
            'icon'      =>  'nav-icon fas fa-users'
        ],
        'active'        =>  ['simple_cms.acl.backend.user.index','simple_cms.acl.backend.user.add','simple_cms.acl.backend.user.edit']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.acl.backend.user.index'
        ]);
    })->order(0);
    $platform_administration->child([
        'key'           =>  'simple_cms.acl.backend.group.index',
        'route'         =>  'simple_cms.acl.backend.group.index',
        'title'         =>  'Groups',
        'attributes'    => [
            'icon'      =>  'nav-icon fas fa-users-cog'
        ],
        'active'        =>  ['simple_cms.acl.backend.group.index','simple_cms.acl.backend.group.add','simple_cms.acl.backend.group.edit']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.acl.backend.group.index'
        ]);
    })->order(1);
    $platform_administration->child([
        'key'           =>  'simple_cms.acl.backend.role.index',
        'route'         =>  'simple_cms.acl.backend.role.index',
        'title'         =>  'Roles',
        'attributes'    => [
            'icon'      =>  'nav-icon fas fa-bezier-curve'
        ],
        'active'        =>  ['simple_cms.acl.backend.role.index','simple_cms.acl.backend.role.add','simple_cms.acl.backend.role.edit']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.acl.backend.role.index'
        ]);
    })->order(2);

    /* set/define again ordering menu setting backend */
    $platform_administration->hideWhen(function() use($hideWhen){
        return !hasRoutePermission($hideWhen);
    })->order = $ordering_menu_platform_administration;
});
