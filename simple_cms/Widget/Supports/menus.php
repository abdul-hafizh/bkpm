<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:09 AM ---------
 */

Menu::modify(MENU_ADMINLTE3, function($menu){

    /* search & get dropdown menu for appearances by key */
    $appearances = $menu->findBy('key', 'simple_cms.settings.backend');
    if ($appearances) {
        $appearances_active = [
            'simple_cms.widget.backend.index'
        ];

        /* save ordering menu appearances backend */
        $ordering_menu_appearances = $appearances->order;

        /* set/merge/append active menu appearances backend */
        $appearances->setActiveProperties($appearances_active);

        /* add more menu child in appearances backend */
        $appearances->child([
            'key' => 'simple_cms.widget.backend.index',
            'route' => 'simple_cms.widget.backend.index',
            'title' => 'Widgets',
            'attributes' => [
                'icon' => 'nav-icon fas fa-puzzle-piece'
            ],
            'active' => ['simple_cms.widget.backend.index']
        ])->hideWhen(function () {
            return !hasRoutePermission([
                'simple_cms.widget.backend.index'
            ]);
        })->order(1);

        /* set/define again ordering menu appearances backend */
        $appearances->hideWhen(function () use ($appearances_active) {
            return !hasRoutePermission($appearances_active);
        })->order = $ordering_menu_appearances;
    }
});
