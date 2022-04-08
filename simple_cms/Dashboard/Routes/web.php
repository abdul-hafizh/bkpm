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

$simple_cms = config('dashboard.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.dashboard.','simple_cms'=>$simple_cms], function()
{
    Route::group(['middleware'=>['permission']], function()
    {
        Route::group(['prefix'=>'backend', 'as'=>'backend.'], function()
        {
            Route::get('/', [
                'title' => 'Dashboard: Index',
                'uses' => 'Backend\DashboardController@index'
            ])->name('index');
        });
    });
});
