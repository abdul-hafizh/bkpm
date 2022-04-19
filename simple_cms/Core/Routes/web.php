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
*/

/* Settings */

Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.setting.','simple_cms'=>'Setting'], function()
{
    Route::group(['middleware' => ['permission'], 'as' => 'backend.', 'prefix' => 'backend/setting'], function()
    {
        Route::get('/', [
            'title' => 'Setting: General',
            'uses' => 'Backend\SettingController@index'
        ])->name('index');
        Route::post('/save-update', [
            'title' => 'Setting: Save Update',
            'uses' => 'Backend\SettingController@save_update'
        ])->name('save_update');
    });
});

Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.guide.','simple_cms'=>'Guide'], function()
{
    Route::group(['middleware' => ['permission'], 'as' => 'backend.', 'prefix' => 'backend/guide'], function()
    {
        Route::get('/', [
            'title' => 'Guide: index',
            'uses' => 'Backend\GuideController@index'
        ])->name('index');
    });
});

Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize', 'theme'], 'as'=>'simple_cms.blog.','simple_cms'=>'Blog'], function()
{
    Route::get('/', [
        'title'=>'Homepage',
        'uses'=>'HomepageController@index'
    ])->name('index');

    Route::get('/download/{auth}/{source}', [
        'title'=>'Download Source',
        'uses'=>'HomepageController@download'
    ])->name('download');
});
