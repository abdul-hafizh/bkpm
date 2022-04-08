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

$simple_cms = config('activitylog.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize', 'permission'], 'as'=>'simple_cms.activitylog.','simple_cms'=>$simple_cms], function()
{
    Route::group(['as' => 'backend.','prefix' => 'backend/activity-log'], function()
    {
        Route::get('/', [
                'title' => 'ActivityLog: Index',
                'uses' => 'ActivityLogController@index'
            ])->name('index');
        Route::post('/modal', [
            'title' => 'ActivityLog: Modal',
            'uses' => 'ActivityLogController@modal'
        ])->name('modal');
        Route::get('/all', [
            'title' => 'ActivityLog: All',
            'uses' => 'ActivityLogController@all'
        ])->name('all');
    });
});
