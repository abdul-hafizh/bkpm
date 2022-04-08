<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:45 AM ---------
 */

\Menu::modify(MENU_ADMINLTE3, function($menu){
    $menu->add([
        'key'           =>  'simple_cms.dashboard.backend.index',
        'route'         =>  'simple_cms.dashboard.backend.index',
        'title'         =>  'Dashboard',
        'attributes'    => [
            'icon'      =>  'nav-icon fas fa-tachometer-alt'
        ],
        'active'        => ['simple_cms.dashboard.backend.index']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.dashboard.backend.index'
        ]);
    })->order(0);
});



