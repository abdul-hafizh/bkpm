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

$simple_cms = config('theme.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.theme.','simple_cms'=>$simple_cms], function()
{
    Route::group(['middleware' => 'permission', 'as' => 'backend.', 'prefix' => 'backend/theme'], function()
    {
        Route::get('/', [
            'title' => 'Theme: Index',
            'uses' => 'Backend\ThemeController@index'
        ])->name('index');
        Route::get('/option', [
            'title' => 'Theme: Option',
            'uses' => 'Backend\ThemeController@option'
        ])->name('option');
    });
});
