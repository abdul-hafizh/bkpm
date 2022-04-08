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

$simple_cms = config('liveeditor.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.live_editor.','simple_cms'=>$simple_cms], function()
{
    Route::group(['middleware' => ['permission'],'prefix' => 'backend/live-editor', 'as'=>'backend.'], function() {
        /* ================== Code Editor ================== */
        Route::get('/', [
            'title' => 'LiveEditor: Index',
            'uses' => 'LiveEditorController@index'
        ])->name('index');
        Route::any('/get-dir', [
            'title' => 'LiveEditor: Get Dir Any',
            'uses' => 'LiveEditorController@get_dir'
        ])->name('get_dir');
        Route::post('/get-file', [
            'title' => 'LiveEditor: Get File',
            'uses' => 'LiveEditorController@get_file'
        ])->name('get_file');
        Route::post('/save-file', [
            'title' => 'LiveEditor: Save File',
            'uses' => 'LiveEditorController@save_file'
        ])->name('save_file');
    });
});
