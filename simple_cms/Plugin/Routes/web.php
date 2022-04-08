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

$simple_cms = config('plugin.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.plugin.','simple_cms'=>$simple_cms], function()
{
    Route::group(['middleware' => ['permission'], 'prefix' => 'backend/plugins', 'as' => 'backend.'], function()
    {
        Route::get('/', [
            'title' => 'Plugin: Index',
            'uses' => 'Backend\PluginController@index'
        ])->name('index');
        Route::post('/{slug}/change/{status}', [
            'title' => 'Plugin: Change Status',
            'uses' => 'Backend\PluginController@change_status'
        ])->name('change_status');
        Route::get('/{slug}/setting', [
            'title' => 'Plugin: Setting',
            'uses' => 'Backend\PluginController@setting'
        ])->name('setting');
    });
});
