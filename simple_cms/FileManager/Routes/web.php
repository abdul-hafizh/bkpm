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

$simple_cms = config('filemanager.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize', 'permission', 'filemanager'], 'as'=>'simple_cms.filemanager.','simple_cms'=>$simple_cms], function()
{
    Route::group(['as' => 'backend.', 'prefix' => 'backend/file-manager'], function()
    {
        Route::get('/',  [
            'title' => 'FileManager: Index',
            'uses' =>'FileManagerController@showIndex'
        ])->name('index');
        Route::any('/connector', [
            'title' => 'FileManager: Connector',
            'uses' => 'FileManagerController@showConnector'
        ])->name('connector');
        Route::get('/popup/{input_id}', [
            'title' => 'FileManager: Popup',
            'uses' => 'FileManagerController@showPopup'
        ])->name('popup');
        Route::get('/filepicker/{input_id}', [
            'title' => 'FileManager: Filepicker',
            'uses' => 'FileManagerController@showFilePicker'
        ])->name('filepicker');
        /*Route::get('tinymce', [
            'title' => 'elfinder.tinymce',
            'uses' => 'ElfinderController@showTinyMCE'
        ]);*/
        /*Route::get('tinymce4', [
            'title' => 'FileManager: Tinymce4',
            'uses' => 'ElfinderController@showTinyMCE4'
        ])->name('tinymce4');*/


        /* Dynamic tinymce version */
//        $tinymceV = config('filemanager.tinymce');
        Route::get('/tinymce', [
            'title' => 'FileManager: Tinymce',
            'uses' => 'FileManagerController@showTinyMCE'
        ])->name('tinymce');
    });
});
