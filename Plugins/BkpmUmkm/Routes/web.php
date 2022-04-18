<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Author  : Ahmad Windi Wijayanto
| Email   : ahmadwindiwijayanto@gmail.com
|
*/

$simple_cms_plugin_name = config('simple_cms.plugins.bkpmumkm.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['web', 'localize'], 'as'=>'simple_cms.plugins.bkpmumkm.','simple_cms'=>$simple_cms_plugin_name], function()
{
    /* Get Json */
    Route::get('/get-json/company/{category}/{status?}', [
        'middleware' => ['auth'],
        'title' => 'BKPM UMKM: Json Companies',
        'uses' => 'BkpmUmkmController@json_company'
    ])->name('json_company');
    Route::get('/get-json/type-jenis-company', [
        'middleware' => ['auth'],
        'title' => 'BKPM UMKM: Json Type/Jenis Companies',
        'uses' => 'BkpmUmkmController@json_type_jenis_company'
    ])->name('json_type_jenis_company');
    Route::get('/get-json/sector', [
        'middleware' => ['auth'],
        'title' => 'BKPM UMKM: Json Business Sectors',
        'uses' => 'BkpmUmkmController@json_sector'
    ])->name('json_sector');
    Route::get('/get-json/kbli', [
        'middleware' => ['auth'],
        'title' => 'BKPM UMKM: Json KBLI',
        'uses' => 'BkpmUmkmController@json_kbli'
    ])->name('json_kbli');
    Route::get('/get-json/umkm-massive', [
        'middleware' => ['auth'],
        'title' => 'BKPM UMKM: Json Umkm Massive',
        'uses' => 'BkpmUmkmController@json_umkm_massive'
    ])->name('json_umkm_massive');
    Route::get('/get-json/sector-umkm-observasi-massive', [
        'middleware' => ['auth'],
        'title' => 'BKPM UMKM: Json Sectors Observasi Massive',
        'uses' => 'BkpmUmkmController@json_sector_umkm_observasi_massive'
    ])->name('json_sector_umkm_observasi_massive');
    Route::post('/get-json/grafik-frontend', [
        'title' => 'Grafik Frontend',
        'uses' => 'BkpmUmkmController@grafik_frontend'
    ])->name('grafik_frontend');

    Route::group(['middleware' => ['permission'], 'as' => 'backend.', 'prefix' => 'backend/bkpm-umkm'], function()
    {
        /* Setting */
        Route::get('/setting', [
            'title' => 'BKPM UMKM: Setting',
            'uses' => 'SettingController@index'
        ])->name('setting');

        /* Rekap Laporan */
        Route::get('/rekap-laporan/umkm-potensial', [
            'title' => 'Rekap Laporan: UMKM Potensial',
            'uses' => 'BkpmUmkmController@rekap_laporan_umkm_potensial'
        ])->name('rekap_laporan.umkm.potensial');

        Route::get('/rekap-laporan/tenaga-surveyor', [
            'title' => 'Rekap Laporan: Tenaga Surveyor',
            'uses' => 'BkpmUmkmController@rekap_laporan_tenaga_surveyor'
        ])->name('rekap_laporan.tenaga_surveyor');

        Route::get('/rekap-laporan/tenaga-ahli', [
            'title' => 'Rekap Laporan: Tenaga Ahli',
            'uses' => 'BkpmUmkmController@rekap_laporan_tenaga_ahli'
        ])->name('rekap_laporan.tenaga_ahli');
        Route::get('/rekap-laporan/tenaga-ahli/daftar-verified', [
            'title' => 'Rekap Laporan: Tenaga Ahli Daftar Verified',
            'uses' => 'BkpmUmkmController@rekap_laporan_tenaga_ahli_daftar_verified'
        ])->name('rekap_laporan.tenaga_ahli_daftar_verified');

        /* Companies Route */
        Route::group(['prefix' => 'perusahaan', 'as'=>'company.'], function() {
            Route::get("/", [
                'title' => "Company: Index [Backend]",
                'uses' => 'Company\Backend\CompanyController@index'
            ])->name("index");
            Route::get("/confirm-add", [
                'title' => "Company: Confirm Add [Backend]",
                'uses' => 'Company\Backend\CompanyController@confirm_add'
            ])->name("confirm_add");
            Route::get("/add", [
                'title' => "Company: Add [Backend]",
                'uses' => 'Company\Backend\CompanyController@add'
            ])->name("add");
            Route::get("/edit/{id}", [
                'title' => "Company: Edit [Backend]",
                'uses' => 'Company\Backend\CompanyController@edit'
            ])->name("edit");
            Route::get("/detail/{id}", [
                'title' => "Company: Detail [Backend]",
                'uses' => 'Company\Backend\CompanyController@detail'
            ])->name("detail");
            Route::post("/save-update", [
                'title' => "Company: Save Update [Backend]",
                'uses' => 'Company\Backend\CompanyController@save_update'
            ])->name("save_update");
            Route::delete("/soft-delete", [
                'title' => "Company: Soft Delete [Backend]",
                'uses' => 'Company\Backend\CompanyController@soft_delete'
            ])->name("soft_delete");
            Route::delete("/force-delete", [
                'title' => "Company: Force Delete [Backend]",
                'uses' => 'Company\Backend\CompanyController@force_delete'
            ])->name("force_delete");
            Route::post("/restore", [
                'title' => "Company: Restore [Backend]",
                'uses' => 'Company\Backend\CompanyController@restore'
            ])->name("restore");
            Route::post("/activity-log", [
                'title' => "Company: Activity Log [Backend]",
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name("activity_log");
            Route::post("/import", [
                'title' => "Company: Import [Backend]",
                'uses' => 'Company\Backend\CompanyController@import'
            ])->name("import");
            Route::post("/change-status", [
                'title' => "Company: Change Status [Backend]",
                'uses' => 'Company\Backend\CompanyController@change_status'
            ])->name("change_status");
        });

        /* UMKM Route */
        Route::group(['prefix' => 'umkm', 'as'=>'umkm.'], function() {
            /* UMKM Observasi */
            Route::group(['prefix' => 'observasi', 'as'=>'observasi.'], function(){
                Route::get("/", [
                    'title' => "UMKM Observasi: Index [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiController@index'
                ])->name("index");
                Route::get("/add", [
                    'title' => "UMKM Observasi: Add [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiController@add'
                ])->name("add");
                Route::get("/edit/{id}", [
                    'title' => "UMKM Observasi: Edit [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiController@edit'
                ])->name("edit");
                Route::get("/detail/{id}", [
                    'title' => "UMKM Observasi: Detail [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiController@detail'
                ])->name("detail");
                Route::post("/save-update", [
                    'title' => "UMKM Observasi: Save Update [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiController@save_update'
                ])->name("save_update");
                Route::delete("/soft-delete", [
                    'title' => "UMKM Observasi: Soft Delete [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiController@soft_delete'
                ])->name("soft_delete");
                Route::delete("/force-delete", [
                    'title' => "UMKM Observasi: Force Delete [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiController@force_delete'
                ])->name("force_delete");
                Route::post("/restore", [
                    'title' => "UMKM Observasi: Restore [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiController@restore'
                ])->name("restore");
                Route::post("/activity-log", [
                    'title' => "UMKM Observasi: Activity Log [Backend]",
                    'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
                ])->name("activity_log");
                Route::post("/import", [
                    'title' => "UMKM Observasi: Import [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiController@import'
                ])->name("import");
            });
            /* End UMKM Observasi */

            /* UMKM Potensial */
            Route::group(['prefix' => 'potensial', 'as'=>'potensial.'], function(){
                Route::get("/", [
                    'title' => "UMKM Potensial: Index [Backend]",
                    'uses' => 'Umkm\Backend\UmkmPotensialController@index'
                ])->name("index");
                Route::get("/add", [
                    'title' => "UMKM Potensial: Add [Backend]",
                    'uses' => 'Umkm\Backend\UmkmPotensialController@add'
                ])->name("add");
                Route::get("/edit/{id}", [
                    'title' => "UMKM Potensial: Edit [Backend]",
                    'uses' => 'Umkm\Backend\UmkmPotensialController@edit'
                ])->name("edit");
                Route::get("/detail/{id}", [
                    'title' => "UMKM Potensial: Detail [Backend]",
                    'uses' => 'Umkm\Backend\UmkmPotensialController@detail'
                ])->name("detail");
                Route::post("/save-update", [
                    'title' => "UMKM Potensial: Save Update [Backend]",
                    'uses' => 'Umkm\Backend\UmkmPotensialController@save_update'
                ])->name("save_update");
                Route::delete("/soft-delete", [
                    'title' => "UMKM Potensial: Soft Delete [Backend]",
                    'uses' => 'Umkm\Backend\UmkmPotensialController@soft_delete'
                ])->name("soft_delete");
                Route::delete("/force-delete", [
                    'title' => "UMKM Potensial: Force Delete [Backend]",
                    'uses' => 'Umkm\Backend\UmkmPotensialController@force_delete'
                ])->name("force_delete");
                Route::post("/restore", [
                    'title' => "UMKM Potensial: Restore [Backend]",
                    'uses' => 'Umkm\Backend\UmkmPotensialController@restore'
                ])->name("restore");
                Route::post("/activity-log", [
                    'title' => "UMKM Potensial: Activity Log [Backend]",
                    'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
                ])->name("activity_log");
                Route::post("/import", [
                    'title' => "UMKM Potensial: Import [Backend]",
                    'uses' => 'Umkm\Backend\UmkmPotensialController@import'
                ])->name("import");
            });
            /* End UMKM Potensial */

            /* UMKM Observasi Massive */
            Route::group(['prefix' => 'observasi-massive', 'as'=>'massive.'], function(){
                Route::get("/", [
                    'title' => "UMKM Observasi Massive: Index [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiMassiveController@index'
                ])->name("index");
                Route::get("/add", [
                    'title' => "UMKM Observasi Massive: Add [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiMassiveController@add'
                ])->name("add");
                Route::get("/edit/{id}", [
                    'title' => "UMKM Observasi Massive: Edit [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiMassiveController@edit'
                ])->name("edit");
                Route::get("/detail/{id}", [
                    'title' => "UMKM Observasi Massive: Detail [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiMassiveController@detail'
                ])->name("detail");
                Route::post("/save-update", [
                    'title' => "UMKM Observasi Massive: Save Update [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiMassiveController@save_update'
                ])->name("save_update");
                Route::delete("/soft-delete", [
                    'title' => "UMKM Observasi Massive: Soft Delete [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiMassiveController@soft_delete'
                ])->name("soft_delete");
                Route::delete("/force-delete", [
                    'title' => "UMKM Observasi Massive: Force Delete [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiMassiveController@force_delete'
                ])->name("force_delete");
                Route::post("/restore", [
                    'title' => "UMKM Observasi Massive: Restore [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiMassiveController@restore'
                ])->name("restore");
                Route::post("/activity-log", [
                    'title' => "UMKM Observasi Massive: Activity Log [Backend]",
                    'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
                ])->name("activity_log");
                Route::post("/import", [
                    'title' => "UMKM Observasi Massive: Import [Backend]",
                    'uses' => 'Umkm\Backend\UmkmObservasiMassiveController@import'
                ])->name("import");
            });
            /* End UMKM Observasi Massive */

            /* Survey UMKM Observasi Massive */
            Route::group(['prefix' => 'survey-observasi-massive', 'as'=>'survey_massive.'], function(){
                Route::get("/", [
                    'title' => "Survey UMKM Observasi Massive: Index [Backend]",
                    'uses' => 'Umkm\Backend\SurveyUmkmObservasiMassiveController@index'
                ])->name("index");
                Route::get("/add", [
                    'title' => "Survey UMKM Observasi Massive: Add [Backend]",
                    'uses' => 'Umkm\Backend\SurveyUmkmObservasiMassiveController@add'
                ])->name("add");
                Route::get("/edit/{id}", [
                    'title' => "Survey UMKM Observasi Massive: Edit [Backend]",
                    'uses' => 'Umkm\Backend\SurveyUmkmObservasiMassiveController@edit'
                ])->name("edit");
                Route::get("/detail/{id}", [
                    'title' => "Survey UMKM Observasi Massive: Detail [Backend]",
                    'uses' => 'Umkm\Backend\SurveyUmkmObservasiMassiveController@detail'
                ])->name("detail");
                Route::post("/save-update", [
                    'title' => "Survey UMKM Observasi Massive: Save Update [Backend]",
                    'uses' => 'Umkm\Backend\SurveyUmkmObservasiMassiveController@save_update'
                ])->name("save_update");
                Route::delete("/soft-delete", [
                    'title' => "Survey UMKM Observasi Massive: Soft Delete [Backend]",
                    'uses' => 'Umkm\Backend\SurveyUmkmObservasiMassiveController@soft_delete'
                ])->name("soft_delete");
                Route::delete("/force-delete", [
                    'title' => "Survey UMKM Observasi Massive: Force Delete [Backend]",
                    'uses' => 'Umkm\Backend\SurveyUmkmObservasiMassiveController@force_delete'
                ])->name("force_delete");
                Route::post("/restore", [
                    'title' => "Survey UMKM Observasi Massive: Restore [Backend]",
                    'uses' => 'Umkm\Backend\SurveyUmkmObservasiMassiveController@restore'
                ])->name("restore");
                Route::post("/activity-log", [
                    'title' => "Survey UMKM Observasi Massive: Activity Log [Backend]",
                    'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
                ])->name("activity_log");
                Route::post("/import", [
                    'title' => "Survey UMKM Observasi Massive: Import [Backend]",
                    'uses' => 'Umkm\Backend\SurveyUmkmObservasiMassiveController@import'
                ])->name("import");
            });
            /* End Survey UMKM Observasi Massive */
        });

        /* Business Sector Route */
        Route::group(['prefix' => 'business-sector', 'as'=>'business_sector.'], function() {
            Route::get("/", [
                'title' => "Business Sector: Index [Backend]",
                'uses' => 'BusinessSector\Backend\BusinessSectorController@index'
            ])->name("index");
            Route::get("/add", [
                'title' => "Business Sector: Add [Backend]",
                'uses' => 'BusinessSector\Backend\BusinessSectorController@add'
            ])->name("add");
            Route::get("/edit/{id}", [
                'title' => "Business Sector: Edit [Backend]",
                'uses' => 'BusinessSector\Backend\BusinessSectorController@edit'
            ])->name("edit");
            Route::post("/save-update", [
                'title' => "Business Sector: Save Update [Backend]",
                'uses' => 'BusinessSector\Backend\BusinessSectorController@save_update'
            ])->name("save_update");
            Route::delete("/soft-delete", [
                'title' => "Business Sector: Soft Delete [Backend]",
                'uses' => 'BusinessSector\Backend\BusinessSectorController@soft_delete'
            ])->name("soft_delete");
            Route::delete("/force-delete", [
                'title' => "Business Sector: Force Delete [Backend]",
                'uses' => 'BusinessSector\Backend\BusinessSectorController@force_delete'
            ])->name("force_delete");
            Route::post("/restore", [
                'title' => "Business Sector: Restore [Backend]",
                'uses' => 'BusinessSector\Backend\BusinessSectorController@restore'
            ])->name("restore");
            Route::post("/import", [
                'title' => "Business Sector: Import [Backend]",
                'uses' => 'BusinessSector\Backend\BusinessSectorController@import'
            ])->name("import");
            Route::post("/activity-log", [
                'title' => "Business Sector: Activity Log [Backend]",
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name("activity_log");
        });

        /* KBLI Route */
        Route::group(['prefix' => 'kbli', 'as'=>'kbli.'], function() {
            Route::get("/", [
                'title' => "KBLI: Index [Backend]",
                'uses' => 'Kbli\Backend\KbliController@index'
            ])->name("index");
            Route::get("/add", [
                'title' => "KBLI: Add [Backend]",
                'uses' => 'Kbli\Backend\KbliController@add'
            ])->name("add");
            Route::get("/edit/{id}", [
                'title' => "KBLI: Edit [Backend]",
                'uses' => 'Kbli\Backend\KbliController@edit'
            ])->name("edit");
            Route::post("/save-update", [
                'title' => "KBLI: Save Update [Backend]",
                'uses' => 'Kbli\Backend\KbliController@save_update'
            ])->name("save_update");
            Route::delete("/soft-delete", [
                'title' => "KBLI: Soft Delete [Backend]",
                'uses' => 'Kbli\Backend\KbliController@soft_delete'
            ])->name("soft_delete");
            Route::delete("/force-delete", [
                'title' => "KBLI: Force Delete [Backend]",
                'uses' => 'Kbli\Backend\KbliController@force_delete'
            ])->name("force_delete");
            Route::post("/restore", [
                'title' => "KBLI: Restore [Backend]",
                'uses' => 'Kbli\Backend\KbliController@restore'
            ])->name("restore");
            Route::post("/import", [
                'title' => "KBLI: Import [Backend]",
                'uses' => 'Kbli\Backend\KbliController@import'
            ])->name("import");
            Route::post("/activity-log", [
                'title' => "KBLI: Activity Log [Backend]",
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name("activity_log");
        });

        /* Surveys Route */
        Route::group(['prefix' => 'survey', 'as'=>'survey.'], function() {

            /* Survey Company */
            Route::group(['prefix' => 'perusahaan', 'as'=>'company.'], function() {
                Route::get("/", [
                    'title' => "Survey Company: Index [Backend]",
                    'uses' => 'Survey\Backend\CompanyController@index'
                ])->name("index");
            });
            /* Survey Company */
            Route::group(['prefix' => 'umkm', 'as'=>'umkm.'], function() {
                Route::get("/", [
                    'title' => "Survey UMKM: Index [Backend]",
                    'uses' => 'Survey\Backend\UmkmController@index'
                ])->name("index");
            });

            Route::post("/activity-log", [
                'title' => "Survey: Activity Log [Backend]",
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name("activity_log");

            Route::get("/{company}/add", [
                'title' => "Survey: Add New [Backend]",
                'uses' => 'Survey\Backend\SurveyController@add'
            ])->name("add");
            Route::get("/{company}/edit/{survey}", [
                'title' => "Survey: Edit [Backend]",
                'uses' => 'Survey\Backend\SurveyController@edit'
            ])->name("edit");
            Route::post("/{company}/save-update", [
                'title' => "Survey: Save Update [Backend]",
                'uses' => 'Survey\Backend\SurveyController@save_update'
            ])->name("save_update");
            Route::delete("/{company}/soft-delete", [
                'title' => "Survey: Soft Delete [Backend]",
                'uses' => 'Survey\Backend\SurveyController@soft_delete'
            ])->name("soft_delete");
            Route::delete("/{company}/force-delete", [
                'title' => "Survey: Force Delete [Backend]",
                'uses' => 'Survey\Backend\SurveyController@force_delete'
            ])->name("force_delete");
            Route::post("/{company}/restore", [
                'title' => "Survey: Restore [Backend]",
                'uses' => 'Survey\Backend\SurveyController@restore'
            ])->name("restore");

            Route::get("/{company}/export", [
                'title' => "Survey: Export [Backend]",
                'uses' => 'Survey\Backend\SurveyController@survey_export'
            ])->name("export");

            Route::get("/{company}/input/{survey}", [
                'title' => "Survey: Input Survey [Backend]",
                'uses' => 'Survey\Backend\SurveyController@input_survey'
            ])->name("input_survey");
            Route::get("/{company}/detail/{survey}", [
                'title' => "Survey: Detail Survey [Backend]",
                'uses' => 'Survey\Backend\SurveyController@detail_survey'
            ])->name("detail_survey");
            Route::post("/{company}/input/{survey}/save", [
                'title' => "Survey: Save Input Survey [Backend]",
                'uses' => 'Survey\Backend\SurveyController@input_survey_save'
            ])->name("input_survey.save");

            Route::post("/{company}/change-status-revision/{survey}", [
                'title' => "Survey: Change Status To Revision [Backend]",
                'uses' => 'Survey\Backend\SurveyController@survey_change_status_revision'
            ])->name("change_status_revision");
            Route::post("/{company}/change-status/{survey}/{status}", [
                'title' => "Survey: Change Status [Backend]",
                'uses' => 'Survey\Backend\SurveyController@survey_change_status'
            ])->name("change_status");

            Route::get("/{company}/berita-acara/{survey}", [
                'title' => "Survey: Upload Berita Acara [Backend]",
                'uses' => 'Survey\Backend\SurveyController@berita_acara'
            ])->name("berita_acara");
            Route::post("/{company}/berita-acara/{survey}", [
                'title' => "Survey: Upload Berita Acara [Backend]",
                'uses' => 'Survey\Backend\SurveyController@berita_acara_save'
            ])->name("berita_acara.save");
            Route::get("/{company}/download-berita-acara/{survey}", [
                'title' => "Survey: Download Berita Acara [Backend]",
                'uses' => 'Survey\Backend\SurveyController@download_berita_acara'
            ])->name("download_berita_acara");
            Route::get("/{company}/verified/{survey}", [
                'title' => "Survey: Verified [Backend]",
                'uses' => 'Survey\Backend\SurveyController@verified'
            ])->name("verified");
            Route::post("/{company}/verified/{survey}", [
                'title' => "Survey: Verified Saving [Backend]",
                'uses' => 'Survey\Backend\SurveyController@verified_save'
            ])->name("verified_save");

        });


        /* Company & UMKM Verified/Bersedia Route */
        /* Company */
        Route::group(['prefix' => 'perusahaan', 'as'=>'company.survey.'], function() {
            Route::get("/bersedia", [
                'title' => "Company Bersedia: Index [Backend]",
                'uses' => 'Survey\Backend\CompanyBersediaController@index'
            ])->name("bersedia.index");
        });
        /* UMKM */
        Route::group(['prefix' => 'umkm', 'as'=>'umkm.survey.'], function() {
            Route::get("/verified", [
                'title' => "UMKM Verified: Index [Backend]",
                'uses' => 'Survey\Backend\UmkmVerifiedController@index'
            ])->name("verified.index");
            Route::get("/bersedia", [
                'title' => "UMKM Bersedia: Index [Backend]",
                'uses' => 'Survey\Backend\UmkmBersediaController@index'
            ])->name("bersedia.index");
            Route::get("/scoring", [
                'title' => "UMKM Scoring: Index [Backend]",
                'uses' => 'Survey\Backend\UmkmScoringController@index'
            ])->name("scoring.index");
            Route::post("/scoring/activity-log", [
                'title' => "UMKM Scoring: Activity Log [Backend]",
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name("scoring.activity_log");
            Route::post("/scoring/{survey}", [
                'title' => "UMKM Scoring: Input Scoring [Backend]",
                'uses' => 'Survey\Backend\UmkmScoringController@save_update'
            ])->name("scoring.save_update");
        });

        Route::group(['prefix' => '{company}/{status}', 'as'=>'verified_bersedia.'], function() {
            Route::get("/detail/{survey}", [
                'title' => "Company & UMKM: Detail [Backend]",
                'uses' => 'Survey\Backend\SurveyController@detail_survey'
            ])->name("detail");
        });

        /* Cross Matching */
        Route::group(['prefix' => 'cross-matching', 'as'=>'cross_matching.'], function() {

            Route::get("/available/{company}/{company_id}", [
                'title' => "Cross Matching: Available Partial Datatable [Backend]",
                'uses' => 'CrossMatching\Backend\CrossMatchingController@datatable_available'
            ])->name("datatable_available");
            Route::get("/picked/{company}/{company_id}", [
                'title' => "Cross Matching: Picked Partial Datatable [Backend]",
                'uses' => 'CrossMatching\Backend\CrossMatchingController@datatable_picked'
            ])->name("datatable_picked");
            Route::post("/picked/{company}/{company_id}", [
                'title' => "Cross Matching: Picked [Backend]",
                'uses' => 'CrossMatching\Backend\CrossMatchingController@picked'
            ])->name("picked");
            Route::post("/picked-change-status/{company}/{company_id}", [
                'title' => "Cross Matching: Picked Change Status [Backend]",
                'uses' => 'CrossMatching\Backend\CrossMatchingController@change_status'
            ])->name("change_status");
            Route::post("/picked-force-delete/{company}/{company_id}", [
                'title' => "Cross Matching: Picked Force Delete [Backend]",
                'uses' => 'CrossMatching\Backend\CrossMatchingController@force_delete'
            ])->name("force_delete");

            Route::post("/activity-log", [
                'title' => "Cross Matching: Activity Log [Backend]",
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name("activity_log");

            Route::get("/{company}", [
                'title' => "Cross Matching: Index [Backend]",
                'uses' => 'CrossMatching\Backend\CrossMatchingController@index'
            ])->name("index");
            Route::get("/{company}/{company_id}", [
                'title' => "Cross Matching: Edit [Backend]",
                'uses' => 'CrossMatching\Backend\CrossMatchingController@edit'
            ])->name("edit");
        });

        /* Cross Matching */
        Route::group(['prefix' => 'kemitraan', 'as'=>'kemitraan.'], function() {
            Route::get("/", [
                'title' => "Kemitraan: Index [Backend]",
                'uses' => 'Kemitraan\Backend\KemitraanController@index'
            ])->name("index");
            Route::post("/activity-log", [
                'title' => "Kemitraan: Activity Log [Backend]",
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name("activity_log");
            Route::get("/{kemitraan_id}", [
                'title' => "Kemitraan: Edit [Backend]",
                'uses' => 'Kemitraan\Backend\KemitraanController@edit'
            ])->name("edit");
            Route::post("/{kemitraan_id}", [
                'title' => "Kemitraan: Save [Backend]",
                'uses' => 'Kemitraan\Backend\KemitraanController@save'
            ])->name("save");
        });

    });
});
