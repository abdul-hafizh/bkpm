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

$simple_cms_plugin_name = config('simple_cms.plugins.reference.name');
Route::group(['middleware' => 'web', 'as'=>'simple_cms.plugins.reference.','simple_cms'=>$simple_cms_plugin_name], function()
{
    Route::group(['middleware' => ['permission'], 'as' => 'backend.', 'prefix' => 'backend/reference'], function()
        {
        Route::get('/', [
                'title' => 'Index',
                'uses' => 'ReferenceController@index'
            ])->name('index');
    });
});
