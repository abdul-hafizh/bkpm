<?php

return [
    'name' => 'Menu',
    'slug' => 'menu',
    'namespace' => 'SimpleCMS\Menu\\',


    'styles' => [
        'navbar' => \SimpleCMS\Menu\Presenters\Bootstrap\NavbarPresenter::class,
        'navbar-right' => \SimpleCMS\Menu\Presenters\Bootstrap\NavbarRightPresenter::class,
        'nav-pills' => \SimpleCMS\Menu\Presenters\Bootstrap\NavPillsPresenter::class,
        'nav-tab' => \SimpleCMS\Menu\Presenters\Bootstrap\NavTabPresenter::class,
        'sidebar' => \SimpleCMS\Menu\Presenters\Bootstrap\SidebarMenuPresenter::class,
        'navmenu' => \SimpleCMS\Menu\Presenters\Bootstrap\NavMenuPresenter::class,
        'adminlte' => \SimpleCMS\Menu\Presenters\Admin\AdminltePresenter::class,
        'adminlte3' => \SimpleCMS\Menu\Presenters\Admin\Adminlte3Presenter::class,
        'zurbmenu' => \SimpleCMS\Menu\Presenters\Foundation\ZurbMenuPresenter::class,
    ],

    'ordering' => true,
];
