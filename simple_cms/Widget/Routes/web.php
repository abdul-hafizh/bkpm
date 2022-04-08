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

$simple_cms = config('widget.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.widget.','simple_cms'=>$simple_cms], function()
{
    Route::group(['middleware' => ['permission'], 'as' => 'backend.', 'prefix' => 'backend/widget'], function()
    {
        Route::get('/', [
            'title' => 'Widget: Index',
            'uses' => 'Backend\WidgetController@index'
        ])->name('index');

        Route::post('/save', [
            'title' => 'Widget: Save',
            'uses' => 'Backend\WidgetController@save'
        ])->name('save');
        Route::delete('/delete', [
            'title' => 'Widget: Delete',
            'uses' => 'Backend\WidgetController@delete'
        ])->name('delete');
    });

    Route::get('/simple-cms-widget/load-widget', [
        'title' => 'Widget: Load Widget',
        'uses' => 'WidgetController@index'
    ])->name('load');
});
