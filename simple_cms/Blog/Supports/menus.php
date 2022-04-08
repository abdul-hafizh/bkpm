<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:09 AM ---------
 */

Menu::modify(MENU_ADMINLTE3, function($menu){

    $menu->dropdown('Blog', function ($sub) {
        $sub->add([
            'key'           =>  'simple_cms.blog.backend.post.index',
            'route'         =>  'simple_cms.blog.backend.post.index',
            'title'         =>  'Posts',
            'attributes'    =>  [
                'icon'      =>  'far fa-newspaper'
            ],
            'active'        =>  ['simple_cms.blog.backend.post.index','simple_cms.blog.backend.post.add','simple_cms.blog.backend.post.edit']
        ])->hideWhen(function(){
            return !hasRoutePermission([
                'simple_cms.blog.backend.post.index'
            ]);
        })->order(0);

        $sub->add([
            'key'           =>  'simple_cms.blog.backend.page.index',
            'route'         =>  'simple_cms.blog.backend.page.index',
            'title'         =>  'Pages',
            'attributes'    =>  [
                'icon'      =>  'fas fa-newspaper'
            ],
            'active'        =>  ['simple_cms.blog.backend.page.index','simple_cms.blog.backend.page.add','simple_cms.blog.backend.page.edit']
        ])->hideWhen(function(){
            return !hasRoutePermission([
                'simple_cms.blog.backend.page.index'
            ]);
        })->order(1);
        $sub->add([
            'key'           =>  'simple_cms.blog.backend.category.index',
            'route'         =>  'simple_cms.blog.backend.category.index',
            'title'         =>  'Categories',
            'attributes'    =>  [
                'icon'      =>  'fas fa-tags'
            ],
            'active'        =>  [
                'simple_cms.blog.backend.category.index', 'simple_cms.blog.backend.category.add', 'simple_cms.blog.backend.category.edit'
            ]
        ])->hideWhen(function(){
            return !hasRoutePermission([
                'simple_cms.blog.backend.category.index'
            ]);
        })->order(2);
        $sub->add([
            'key'           =>  'simple_cms.blog.backend.tag.index',
            'route'         =>  'simple_cms.blog.backend.tag.index',
            'title'         =>  'Tags',
            'attributes'    =>  [
                'icon'      =>  'fas fa-tag'
            ],
            'active'        =>  ['simple_cms.blog.backend.tag.index']
        ])->hideWhen(function(){
            return !hasRoutePermission([
                'simple_cms.blog.backend.tag.index'
            ]);
        })->order(3);
        $sub->add([
            'key'           =>  'simple_cms.blog.backend.gallery.index',
            'route'         =>  'simple_cms.blog.backend.gallery.index',
            'title'         =>  'Gallery',
            'attributes'    =>  [
                'icon'      =>  'nav-icon far fa-images'
            ],
            'active'        =>  ['simple_cms.blog.backend.gallery.index','simple_cms.blog.backend.gallery.add','simple_cms.blog.backend.gallery.edit']
        ])->hideWhen(function(){
            return !hasRoutePermission([
                'simple_cms.blog.backend.gallery.index'
            ]);
        })->order(3);
        $sub->add([
            'key'           =>  'simple_cms.slider.backend.index',
            'route'         =>  'simple_cms.slider.backend.index',
            'title'         =>  'Slider',
            'attributes'    =>  [
                'icon'      =>  'nav-icon fas fa-file-image'
            ],
            'active'        =>  ['simple_cms.slider.backend.index','simple_cms.slider.backend.add','simple_cms.slider.backend.edit']
        ])->hideWhen(function(){
            return !hasRoutePermission([
                'simple_cms.slider.backend.index','simple_cms.slider.backend.add','simple_cms.slider.backend.edit'
            ]);
        })->order(3);
    },[
        'key'       => 'simple_cms.blog.backend',
        'icon'      => 'nav-icon fas fa-book',
        'active'    => [
            'simple_cms.blog.backend.post.index','simple_cms.blog.backend.post.add','simple_cms.blog.backend.post.edit',
            'simple_cms.blog.backend.page.index','simple_cms.blog.backend.page.add','simple_cms.blog.backend.page.edit',
            'simple_cms.blog.backend.category.index', 'simple_cms.blog.backend.category.add', 'simple_cms.blog.backend.category.edit',
            'simple_cms.blog.backend.tag.index',
            'simple_cms.blog.backend.gallery.index','simple_cms.blog.backend.gallery.add','simple_cms.blog.backend.gallery.edit',
            'simple_cms.slider.backend.index','simple_cms.slider.backend.add','simple_cms.slider.backend.edit'
        ]
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.blog.backend.post.index',
            'simple_cms.blog.backend.page.index',
            'simple_cms.blog.backend.category.index',
            'simple_cms.blog.backend.tag.index',
            'simple_cms.blog.backend.gallery.index',
            'simple_cms.slider.backend.index','simple_cms.slider.backend.add','simple_cms.slider.backend.edit'
        ]);
    })->order(2);

    /* search & get dropdown menu for Setting by key */
    $settings = $menu->findBy('key', 'simple_cms.settings.backend');

    $settings_active = [
        'simple_cms.blog.backend.setting.index'
    ];

    /* save ordering menu setting backend */
    $ordering_menu_settings = $settings->order;

    /* set/merge/append active menu setting backend */
    $settings->setActiveProperties($settings_active);

    /* add more menu child in setting backend */
    $settings->child([
        'key'           =>  'simple_cms.blog.backend.setting.index',
        'route'         =>  'simple_cms.blog.backend.setting.index',
        'title'         =>  'Blog',
        'attributes'    => [
            'icon'      =>  'nav-icon fas fa-book'
        ],
        'active'        =>  ['simple_cms.blog.backend.setting.index']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.blog.backend.setting.index'
        ]);
    })->order(1);

    /* set/define again ordering menu setting backend */
    $settings->hideWhen(function() use($settings_active){
        return !hasRoutePermission($settings_active);
    })->order = $ordering_menu_settings;

});

