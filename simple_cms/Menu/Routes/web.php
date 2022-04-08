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

$simple_cms = config('menu.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.menu.','simple_cms'=>$simple_cms], function()
{
    Route::group(['middleware' => 'permission', 'as' => 'backend.', 'prefix' => 'backend/menu'], function()
    {
        Route::get('/', [
                'title' => 'Menu',
                'uses' => 'MenuController@index'
        ])->name('index');

        Route::get('/add', [
            'title' => 'Menu: Add',
            'uses' => 'MenuController@add'
        ])->name('add');
        Route::get('/edit/{id}/{slug}', [
            'title' => 'Menu: Edit',
            'uses' => 'MenuController@edit'
        ])->name('edit');
        Route::post('/save-update', [
            'title' => 'Menu: Save Update',
            'uses' => 'MenuController@save_update'
        ])->name('save_update');

        Route::delete('/soft-delete', [
            'title' => 'Menu: Soft Delete',
            'uses' => 'MenuController@soft_delete'
        ])->name('soft_delete');
        Route::delete('/force-delete', [
            'title' => 'Menu: Force Delete',
            'uses' => 'MenuController@force_delete'
        ])->name('force_delete');
        Route::post('/restore', [
            'title' => 'Menu: Restore',
            'uses' => 'MenuController@restore'
        ])->name('restore');
        Route::post('/activity-log', [
            'title' => 'Menu: Activity Log',
            'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
        ])->name('activity_log');
    });
});
