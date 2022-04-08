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

$simple_cms = config('slider.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.slider.','simple_cms'=>$simple_cms], function()
{
    Route::group(['middleware' => ['permission'], 'as' => 'backend.', 'prefix' => 'backend/slider'], function()
    {
        Route::get('/', [
            'title' => 'Slider: List',
            'uses' => 'Backend\SliderController@index'
        ])->name('index');
        Route::get('/add', [
            'title' => 'Slider: Add/New',
            'uses' => 'Backend\SliderController@add'
        ])->name('add');
        Route::get('/edit/{id}/{slug}', [
            'title' => 'Slider: Edit',
            'uses' => 'Backend\SliderController@edit'
        ])->name('edit');
        Route::post('/save-update', [
            'title' => 'Slider: Save Update',
            'uses' => 'Backend\SliderController@save_update'
        ])->name('save_update');
        /*Route::post('/restore', [
            'title' => 'Slider: Restore Delete',
            'uses' => 'Backend\SliderController@restore'
        ])->name('restore');
        Route::delete('/soft-delete', [
            'title' => 'Slider: Soft Delete',
            'uses' => 'Backend\SliderController@soft_delete'
        ])->name('soft_delete');*/
        Route::delete('/force-delete', [
            'title' => 'Slider: Force Delete',
            'uses' => 'Backend\SliderController@force_delete'
        ])->name('force_delete');
    });
});
