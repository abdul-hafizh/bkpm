<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:09 AM ---------
 */

$identifier = app('config')->get('simple_cms.plugins.bkpmumkm.identifier');
Menu::modify(MENU_ADMINLTE3, function($menu) use($identifier) {
    /* Menu Rekap Laporan */
    $menu->dropdown('label.rekap_laporan', function ($sub) use($identifier) {
        $sub->add([
            'key'           =>  "{$identifier}.backend.rekap_laporan.umkm.potensial",
            'route'         =>  "{$identifier}.backend.rekap_laporan.umkm.potensial",
            'title'         =>  'label.rekap_laporan_umkm_potensial',
            'attributes'    =>  [
                'icon'      =>  'nav-icon fas fa-arrow-right'
            ],
            'active'        =>  [
                "{$identifier}.backend.rekap_laporan.umkm.potensial"
            ]
        ])->hideWhen(function() use ($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.rekap_laporan.umkm.potensial"
            ]);
        })->order(1);
        $sub->add([
            'key'           =>  "{$identifier}.backend.rekap_laporan.tenaga_surveyor",
            'route'         =>  "{$identifier}.backend.rekap_laporan.tenaga_surveyor",
            'title'         =>  'label.rekap_laporan_tenaga_surveyor',
            'attributes'    =>  [
                'icon'      =>  'nav-icon fas fa-arrow-right'
            ],
            'active'        =>  [
                "{$identifier}.backend.rekap_laporan.tenaga_surveyor"
            ]
        ])->hideWhen(function() use ($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.rekap_laporan.tenaga_surveyor"
            ]);
        })->order(2);
        $sub->add([
            'key'           =>  "{$identifier}.backend.rekap_laporan.tenaga_ahli",
            'route'         =>  "{$identifier}.backend.rekap_laporan.tenaga_ahli",
            'title'         =>  'label.rekap_laporan_tenaga_ahli',
            'attributes'    =>  [
                'icon'      =>  'nav-icon fas fa-arrow-right'
            ],
            'active'        =>  [
                "{$identifier}.backend.rekap_laporan.tenaga_ahli"
            ]
        ])->hideWhen(function() use ($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.rekap_laporan.tenaga_ahli"
            ]);
        })->order(2);
    },[
        'key'       => "{$identifier}.backend.rekap_laporan",
        'icon'      => 'nav-icon fas fa-poll',
        'active'    => [
            "{$identifier}.backend.rekap_laporan.umkm.potensial",
            "{$identifier}.backend.rekap_laporan.tenaga_surveyor",
            "{$identifier}.backend.rekap_laporan.tenaga_ahli"
        ]
    ])->hideWhen(function() use($identifier) {
        return !hasRoutePermission([
            "{$identifier}.backend.rekap_laporan.umkm.potensial",
            "{$identifier}.backend.rekap_laporan.tenaga_surveyor",
            "{$identifier}.backend.rekap_laporan.tenaga_ahli"
        ]);
    })->order(1);

    $menu->dropdown('label.master_references', function ($sub) use($identifier) {
        $sub->add([
            'key'           =>  "{$identifier}.backend.business_sector",
            'route'         =>  "{$identifier}.backend.business_sector.index",
            'title'         =>  'label.index_business_sector',
            'attributes'    =>  [
                'icon'      =>  'fab fa-staylinked'
            ],
            'active'        =>  [
                "{$identifier}.backend.business_sector.index",
                "{$identifier}.backend.business_sector.add",
                "{$identifier}.backend.business_sector.edit"
            ]
        ])->hideWhen(function() use($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.business_sector.index"
            ]);
        })->order(0);

        $sub->add([
            'key'           =>  "{$identifier}.backend.kbli",
            'route'         =>  "{$identifier}.backend.kbli.index",
            'title'         =>  'label.index_kbli',
            'attributes'    =>  [
                'icon'      =>  'fab fa-staylinked'
            ],
            'active'        =>  [
                "{$identifier}.backend.kbli.index",
                "{$identifier}.backend.kbli.add",
                "{$identifier}.backend.kbli.edit"
            ]
        ])->hideWhen(function() use($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.kbli.index"
            ]);
        })->order(1);

    },[
        'key'       => "{$identifier}.backend.references",
        'icon'      => 'nav-icon fas fa-coins',
        'active'    => [
            "{$identifier}.backend.business_sector.index",
            "{$identifier}.backend.business_sector.add",
            "{$identifier}.backend.business_sector.edit",
            "{$identifier}.backend.kbli.index",
            "{$identifier}.backend.kbli.add",
            "{$identifier}.backend.kbli.edit"
        ]
    ])->hideWhen(function() use($identifier) {
        return !hasRoutePermission([
            "{$identifier}.backend.business_sector.index",
            "{$identifier}.backend.kbli.index"
        ]);
    })->order(2);

    /* Menu Usaha Besar */
    $menu->dropdown('label.master_data_usaha_besar', function ($sub) use($identifier) {
        $sub->add([
            'key'           =>  "{$identifier}.backend.company",
            'route'         =>  "{$identifier}.backend.company.index",
            'title'         =>  'label.index_company',
            'attributes'    =>  [
                'icon'      =>  'far fa-building'
            ],
            'active'        =>  [
                "{$identifier}.backend.company.index",
                "{$identifier}.backend.company.add",
                "{$identifier}.backend.company.edit",
                "{$identifier}.backend.company.detail"
            ]
        ])->hideWhen(function() use ($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.company.index"
            ]);
        })->order(0);

        /* Usaha Besar Bersedia */
        $sub->add([
            'key'           =>  "{$identifier}.backend.company.survey.bersedia.index",
            'route'         =>  "{$identifier}.backend.company.survey.bersedia.index",
            'title'         =>  'label.index_company_bersedia',
            'attributes'    =>  [
                'icon'      =>  'fas fa-check-circle'
            ],
            'active'        =>  [
                "{$identifier}.backend.company.survey.bersedia.index"
            ]
        ])->hideWhen(function() use ($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.company.survey.bersedia.index"
            ]);
        })->order(1);

        $sub->add([
            'key'           =>  "{$identifier}.backend.survey.company.index",
            'route'         =>  "{$identifier}.backend.survey.company.index",
            'title'         =>  'label.survey_company',
            'attributes'    =>  [
                'icon'      =>  'far fa-building'
            ],
            'active'        =>  [
                "{$identifier}.backend.survey.company.index"
            ]
        ])->hideWhen(function() use($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.survey.company.index"
            ]);
        })->order(2);


    },[
        'key'       => "{$identifier}.backend",
        'icon'      => 'nav-icon fas fa-database',
        'active'    => [
            "{$identifier}.backend.company.index",
            "{$identifier}.backend.company.add",
            "{$identifier}.backend.company.edit",
            "{$identifier}.backend.company.detail",
            "{$identifier}.backend.company.survey.bersedia.index",
            "{$identifier}.backend.survey.company.index"
        ]
    ])->hideWhen(function() use($identifier) {
        return !hasRoutePermission([
            "{$identifier}.backend.company.index",
            "{$identifier}.backend.company.survey.bersedia.index",
            "{$identifier}.backend.survey.company.index"
        ]);
    })->order(4);

    /* Menu Master Data UMKM */
    $menu->dropdown('label.master_data_umkm', function ($sub) use($identifier) {
        $sub->add([
            'key'           =>  "{$identifier}.backend.umkm.observasi",
            'route'         =>  "{$identifier}.backend.umkm.observasi.index",
            'title'         =>  'label.umkm_observasi',
            'attributes'    =>  [
                'icon'      =>  'fas fa-users'
            ],
            'active'        =>  [
                "{$identifier}.backend.umkm.observasi.index",
                "{$identifier}.backend.umkm.observasi.add",
                "{$identifier}.backend.umkm.observasi.edit",
                "{$identifier}.backend.umkm.observasi.detail"
            ]
        ])->hideWhen(function() use($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.umkm.observasi.index"
            ]);
        })->order(0);

        $sub->add([
            'key'           =>  "{$identifier}.backend.umkm.massive.index",
            'route'         =>  "{$identifier}.backend.umkm.massive.index",
            'title'         =>  'label.umkm_observasi_massive',
            'attributes'    =>  [
                'icon'      =>  'fas fa-users'
            ],
            'active'        =>  [
                "{$identifier}.backend.umkm.massive.index",
                "{$identifier}.backend.umkm.massive.add",
                "{$identifier}.backend.umkm.massive.edit",
                "{$identifier}.backend.umkm.massive.detail"
            ]
        ])->hideWhen(function() use ($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.umkm.massive.index"
            ]);
        })->order(5);

        $sub->add([
            'key'           =>  "{$identifier}.backend.umkm.survey_massive.index",
            'route'         =>  "{$identifier}.backend.umkm.survey_massive.index",
            'title'         =>  'label.survey_umkm_observasi_massive',
            'attributes'    =>  [
                'icon'      =>  'fas fa-poll'
            ],
            'active'        =>  [
                "{$identifier}.backend.umkm.survey_massive.index",
                "{$identifier}.backend.umkm.survey_massive.add",
                "{$identifier}.backend.umkm.survey_massive.edit",
                "{$identifier}.backend.umkm.survey_massive.detail"
            ]
        ])->hideWhen(function() use ($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.umkm.survey_massive.index"
            ]);
        })->order(6);

        $sub->add([
            'key'           =>  "{$identifier}.backend.umkm.potensial",
            'route'         =>  "{$identifier}.backend.umkm.potensial.index",
            'title'         =>  'label.umkm_potensial',
            'attributes'    =>  [
                'icon'      =>  'fas fa-users'
            ],
            'active'        =>  [
                "{$identifier}.backend.umkm.potensial.index",
                "{$identifier}.backend.umkm.potensial.add",
                "{$identifier}.backend.umkm.potensial.edit",
                "{$identifier}.backend.umkm.potensial.detail"
            ]
        ])->hideWhen(function() use($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.umkm.potensial.index"
            ]);
        })->order(7);

        $sub->add([
            'key'           =>  "{$identifier}.backend.survey.umkm.index",
            'route'         =>  "{$identifier}.backend.survey.umkm.index",
            'title'         =>  'label.survey_umkm',
            'attributes'    =>  [
                'icon'      =>  'fas fa-users'
            ],
            'active'        =>  [
                "{$identifier}.backend.survey.umkm.index"
            ]
        ])->hideWhen(function() use($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.survey.umkm.index"
            ]);
        })->order(8);

        /* UMKM Verified */
        $sub->add([
            'key'           =>  "{$identifier}.backend.umkm.survey.verified.index",
            'route'         =>  "{$identifier}.backend.umkm.survey.verified.index",
            'title'         =>  'label.index_umkm_verified',
            'attributes'    =>  [
                'icon'      =>  'fas fa-check-square'
            ],
            'active'        =>  [
                "{$identifier}.backend.umkm.survey.verified.index"
            ]
        ])->hideWhen(function() use ($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.umkm.survey.verified.index"
            ]);
        })->order(9);
        /* UMKM Scoring */
        $sub->add([
            'key'           =>  "{$identifier}.backend.umkm.survey.scoring.index",
            'route'         =>  "{$identifier}.backend.umkm.survey.scoring.index",
            'title'         =>  'label.umkm_scoring',
            'attributes'    =>  [
                'icon'      =>  'fas fa-check-square'
            ],
            'active'        =>  [
                "{$identifier}.backend.umkm.survey.scoring.index"
            ]
        ])->hideWhen(function() use ($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.umkm.survey.scoring.index"
            ]);
        })->order(10);
        /* UMKM Bersedia */
        $sub->add([
            'key'           =>  "{$identifier}.backend.umkm.survey.bersedia.index",
            'route'         =>  "{$identifier}.backend.umkm.survey.bersedia.index",
            'title'         =>  'label.index_umkm_bersedia',
            'attributes'    =>  [
                'icon'      =>  'fas fa-check-circle'
            ],
            'active'        =>  [
                "{$identifier}.backend.umkm.survey.bersedia.index"
            ]
        ])->hideWhen(function() use ($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.umkm.survey.bersedia.index"
            ]);
        })->order(11);

    },[
        'key'       => "{$identifier}.backend",
        'icon'      => 'nav-icon fas fa-database',
        'active'    => [
            "{$identifier}.backend.umkm.observasi.index",
            "{$identifier}.backend.umkm.observasi.add",
            "{$identifier}.backend.umkm.observasi.edit",
            "{$identifier}.backend.umkm.observasi.detail",
            "{$identifier}.backend.umkm.massive.index",
            "{$identifier}.backend.umkm.massive.add",
            "{$identifier}.backend.umkm.massive.edit",
            "{$identifier}.backend.umkm.massive.detail",
            "{$identifier}.backend.umkm.survey_massive.index",
            "{$identifier}.backend.umkm.survey_massive.add",
            "{$identifier}.backend.umkm.survey_massive.edit",
            "{$identifier}.backend.umkm.survey_massive.detail",
            "{$identifier}.backend.umkm.potensial.index",
            "{$identifier}.backend.umkm.potensial.add",
            "{$identifier}.backend.umkm.potensial.edit",
            "{$identifier}.backend.umkm.potensial.detail",
            "{$identifier}.backend.survey.umkm.index",
            "{$identifier}.backend.survey.umkm.index",
            "{$identifier}.backend.umkm.survey.verified.index",
            "{$identifier}.backend.umkm.survey.scoring.index",
            "{$identifier}.backend.umkm.survey.bersedia.index"
        ]
    ])->hideWhen(function() use($identifier) {
        return !hasRoutePermission([
            "{$identifier}.backend.umkm.observasi.index",
            "{$identifier}.backend.umkm.massive.index",
            "{$identifier}.backend.umkm.survey_massive.index",
            "{$identifier}.backend.umkm.potensial.index",
            "{$identifier}.backend.survey.umkm.index",
            "{$identifier}.backend.survey.umkm.index",
            "{$identifier}.backend.umkm.survey.verified.index",
            "{$identifier}.backend.umkm.survey.scoring.index",
            "{$identifier}.backend.umkm.survey.bersedia.index"
        ]);
    })->order(5);

    /* Menu UMKM Observasi Massive */
    /*$menu->dropdown('label.index_umkm_observasi_massive', function ($sub) use($identifier) {
        
    },[
        'key'       => "{$identifier}.backend.umkm.massive",
        'icon'      => 'nav-icon fas fa-database',
        'active'    => [
            
        ]
    ])->hideWhen(function() use($identifier) {
        return !hasRoutePermission([
            
        ]);
    })->order(6);*/

    /*$menu->dropdown('label.survey', function ($sub) use($identifier) {
        $sub->add([
            'key'           =>  "{$identifier}.backend.survey.company.index",
            'route'         =>  "{$identifier}.backend.survey.company.index",
            'title'         =>  'label.survey_company',
            'attributes'    =>  [
                'icon'      =>  'far fa-building'
            ],
            'active'        =>  [
                "{$identifier}.backend.survey.company.index"
            ]
        ])->hideWhen(function() use($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.survey.company.index"
            ]);
        })->order(0);

        $sub->add([
            'key'           =>  "{$identifier}.backend.survey.umkm.index",
            'route'         =>  "{$identifier}.backend.survey.umkm.index",
            'title'         =>  'label.survey_umkm',
            'attributes'    =>  [
                'icon'      =>  'fas fa-users'
            ],
            'active'        =>  [
                "{$identifier}.backend.survey.umkm.index"
            ]
        ])->hideWhen(function() use($identifier) {
            return !hasRoutePermission([
                "{$identifier}.backend.survey.umkm.index"
            ]);
        })->order(1);

    },[
        'key'       => "{$identifier}.backend.surveys",
        'icon'      => 'nav-icon fas fa-poll',
        'active'    => [
            "{$identifier}.backend.survey.company.index",
            "{$identifier}.backend.survey.umkm.index",
            "{$identifier}.backend.survey.add",
            "{$identifier}.backend.survey.edit",
            "{$identifier}.backend.survey.input_survey",
            "{$identifier}.backend.survey.detail_survey",
            "{$identifier}.backend.survey.berita_acara",
            "{$identifier}.backend.survey.verified"
        ]
    ])->hideWhen(function() use($identifier) {
        return !hasRoutePermission([
            "{$identifier}.backend.survey.company.index",
            "{$identifier}.backend.survey.umkm.index"
        ]);
    })->order(7);*/

    /* Cross Matching */
    $menu->add([
        'key'           =>  "{$identifier}.backend.cross_matching.index",
        'route'         =>  ["{$identifier}.backend.cross_matching.index", ['company' => CATEGORY_COMPANY] ],
        'title'         =>  'label.index_cross_matching_' . CATEGORY_COMPANY,
        'attributes'    =>  [
            'icon'      =>  'nav-icon fas fa-exchange-alt'
        ],
        'active'        =>  [
            "{$identifier}.backend.cross_matching.index",
            "{$identifier}.backend.cross_matching.edit"
        ]
    ])->hideWhen(function() use ($identifier) {
        return !hasRoutePermission([
            "{$identifier}.backend.cross_matching.index"
        ]);
    })->order(12);
    /* Kemitraan */
    $menu->add([
        'key'           =>  "{$identifier}.backend.kemitraan.index",
        'route'         =>  "{$identifier}.backend.kemitraan.index",
        'title'         =>  'label.index_kemitraan',
        'attributes'    =>  [
            'icon'      =>  'nav-icon fas fa-handshake'
        ],
        'active'        =>  [
            "{$identifier}.backend.kemitraan.index",
            "{$identifier}.backend.kemitraan.edit"
        ]
    ])->hideWhen(function() use ($identifier) {
        return !hasRoutePermission([
            "{$identifier}.backend.kemitraan.index"
        ]);
    })->order(13);

    /* search & get dropdown menu for Setting by key */
    $settings = $menu->findBy('key', 'simple_cms.settings.backend');

    $settings_active = [
        'simple_cms.plugins.bkpmumkm.backend.setting'
    ];

    /* save ordering menu setting backend */
    $ordering_menu_settings = $settings->order;

    /* set/merge/append active menu setting backend */
    $settings->setActiveProperties($settings_active);

    /* add more menu child in setting backend */
    $settings->child([
        'key'           =>  'simple_cms.plugins.bkpmumkm.backend.setting',
        'route'         =>  'simple_cms.plugins.bkpmumkm.backend.setting',
        'title'         =>  'label.bkpmumkm_setting',
        'attributes'    => [
            'icon'      =>  'nav-icon fas fa-cog'
        ],
        'active'        =>  ['simple_cms.plugins.bkpmumkm.backend.setting']
    ])->hideWhen(function(){
        return !hasRoutePermission([
            'simple_cms.plugins.bkpmumkm.backend.setting'
        ]);
    })->order(1);

    /* set/define again ordering menu setting backend */
    $settings->hideWhen(function() use($settings_active){
        return !hasRoutePermission($settings_active);
    })->order = $ordering_menu_settings;

});
