<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:09 AM ---------
 */

Menu::modify(MENU_ADMINLTE3, function($menu){

    $menu->add([
        'key'           =>  'simple_cms.live_editor.backend.index',
        'route'         =>  'simple_cms.live_editor.backend.index',
        'title'         =>  'Live Editor',
        'attributes'    =>  [
            'icon'      =>  'nav-icon fas fa-code'
        ],
        'active'        =>  ['simple_cms.live_editor.backend.index']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.live_editor.backend.index'
        ]);
    })->order(101);
});
