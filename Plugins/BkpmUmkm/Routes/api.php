<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$simple_cms_plugin_name = config('simple_cms.plugins.bkpmumkm.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['web', 'localize'], 'as'=>'simple_cms.plugins.bkpmumkm.api.','simple_cms'=>$simple_cms_plugin_name], function()
{
    Route::get('/api/bkpm-umkm/kemitraan', [
        'title' => 'BKPM UMKM: Kemitraan',
        'uses' => 'Kemitraan\Backend\KemitraanController@front'
    ])->name('kemitraan');
});
