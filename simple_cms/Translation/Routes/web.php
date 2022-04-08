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

$simple_cms = config('translation.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.translation.','simple_cms'=>$simple_cms], function()
{
    Route::group(['middleware' => ['permission'], 'as' => 'backend.', 'prefix' => 'backend/translation'], function()
    {
        Route::get('/', [
            'title' => 'Translation: Index',
            'uses' => 'TranslationController@index'
        ])->name('index');
        Route::post('/add', [
            'title' => 'Translation: Add',
            'uses' => 'TranslationController@add_edit'
        ])->name('add');
        Route::post('/edit', [
            'title' => 'Translation: Edit',
            'uses' => 'TranslationController@add_edit'
        ])->name('edit');
        Route::post('/save-update', [
            'title' => 'Translation: Save Update',
            'uses' => 'TranslationController@save_update'
        ])->name('save_update');
        Route::delete('/delete', [
            'title' => 'Translation: Force Delete',
            'uses' => 'TranslationController@force_delete'
        ])->name('force_delete');

        Route::group(['as' => 'language.', 'prefix' => 'language'], function()
        {
            Route::post('/set-default-locale', [
                'title' => 'Language: Set Default',
                'uses' => 'TranslationController@set_default_locale'
            ])->name('set_default');
            Route::post('/add', [
                'title' => 'Language: Add',
                'uses' => 'TranslationController@language_add_edit'
            ])->name('add');
            Route::post('/edit', [
                'title' => 'Language: Edit',
                'uses' => 'TranslationController@language_add_edit'
            ])->name('edit');
            Route::post('/save-update', [
                'title' => 'Language: Save Update',
                'uses' => 'TranslationController@language_save_update'
            ])->name('save_update');
            Route::post('/restore', [
                'title' => 'Language: Restore',
                'uses' => 'TranslationController@language_restore'
            ])->name('restore');
            Route::delete('/soft-delete', [
                'title' => 'Language: Trash',
                'uses' => 'TranslationController@language_soft_delete'
            ])->name('soft_delete');
        });
    });
});
