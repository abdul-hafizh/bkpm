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

$simple_cms = config('wilayah.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.wilayah.','simple_cms'=>$simple_cms], function()
{
    Route::group(['prefix' => 'wilayah'], function()
    {
        Route::post('/get/ajax', [
                'title' => 'Wilayah: Get Ajax',
                'uses' => 'WilayahController@get_ajax'
            ])->name('get_ajax');
    });
});
