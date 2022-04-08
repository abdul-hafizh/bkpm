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

$simple_cms = config('blog.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.blog.','simple_cms'=>$simple_cms], function()
{
    Route::group(['middleware' => ['permission'], 'as' => 'backend.', 'prefix' => 'backend/blog'], function()
    {
        Route::group(['prefix' => 'setting', 'as'=>'setting.'], function() {
            Route::get('/', [
                'title' => 'Blog: Setting',
                'uses' => 'Backend\SettingController@index'
            ])->name('index');
        });

        Route::group(['prefix' => 'category', 'as'=>'category.'], function() {
            Route::get('/', [
                'title' => 'Category: Index',
                'uses' => 'Backend\CategoryController@index'
            ])->name('index');
            Route::get('/add', [
                'title' => 'Category: Add',
                'uses' => 'Backend\CategoryController@add'
            ])->name('add');
            Route::get('/edit/{id}', [
                'title' => 'Category: Edit',
                'uses' => 'Backend\CategoryController@edit'
            ])->name('edit');
            Route::post('/save-update', [
                'title' => 'Category: Save Update',
                'uses' => 'Backend\CategoryController@save_update'
            ])->name('save_update');
            Route::delete('/soft-delete', [
                'title' => 'Category: Soft Delete',
                'uses' => 'Backend\CategoryController@soft_delete'
            ])->name('soft_delete');
            Route::delete('/force-delete', [
                'title' => 'Category: Force Delete',
                'uses' => 'Backend\CategoryController@force_delete'
            ])->name('force_delete');
            Route::post('/restore', [
                'title' => 'Category: Restore',
                'uses' => 'Backend\CategoryController@restore'
            ])->name('restore');
            Route::post('/activity-log', [
                'title' => 'Category: Activity Log',
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name('activity_log');
        });

        Route::group(['prefix' => 'tag', 'as'=>'tag.'], function() {
            Route::get('/', [
                'title' => 'Tag: Index',
                'uses' => 'Backend\TagController@index'
            ])->name('index');
            Route::post('/modal/add', [
                'title' => 'Tag: Add',
                'uses' => 'Backend\TagController@modal_add_edit'
            ])->name('modal_add');
            Route::post('/modal/edit', [
                'title' => 'Tag: Edit',
                'uses' => 'Backend\TagController@modal_add_edit'
            ])->name('modal_edit');
            Route::post('/save-update', [
                'title' => 'Tag: Save Update',
                'uses' => 'Backend\TagController@save_update'
            ])->name('save_update');
            Route::delete('/soft-delete', [
                'title' => 'Tag: Soft Delete',
                'uses' => 'Backend\TagController@soft_delete'
            ])->name('soft_delete');
            Route::delete('/force-delete', [
                'title' => 'Tag: Force Delete',
                'uses' => 'Backend\TagController@force_delete'
            ])->name('force_delete');
            Route::post('/restore', [
                'title' => 'Tag: Restore',
                'uses' => 'Backend\TagController@restore'
            ])->name('restore');
            Route::post('/select2', [
                'title' => 'Tag: Select2',
                'uses' => 'Backend\TagController@select2'
            ])->name('select2');
            Route::post('/activity-log', [
                'title' => 'Tag: Activity Log',
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name('activity_log');
        });

        Route::group(['prefix' => 'post', 'as'=>'post.'], function() {
            Route::get('/', [
                'title' => 'Post: Index',
                'uses' => 'Backend\PostController@index'
            ])->name('index');
            Route::get('/add', [
                'title' => 'Post: Add',
                'uses' => 'Backend\PostController@add_edit'
            ])->name('add');
            Route::get('/edit/{post_slug}', [
                'title' => 'Post: Edit',
                'uses' => 'Backend\PostController@add_edit'
            ])->name('edit');
            Route::get('/preview/{post_slug?}', [
                'title' => 'Post: Preview',
                'uses' => 'Backend\PostController@preview'
            ])->name('preview');
            Route::post('/save-update', [
                'title' => 'Post: Save Update',
                'uses' => 'Backend\PostController@save_update'
            ])->name('save_update');
            Route::post('/restore', [
                'title' => 'Post: Restore Delete',
                'uses' => 'Backend\PostController@restore'
            ])->name('restore');
            Route::delete('/soft-delete', [
                'title' => 'Post: Soft Delete',
                'uses' => 'Backend\PostController@soft_delete'
            ])->name('soft_delete');
            Route::delete('/force-delete', [
                'title' => 'Post: Force Delete',
                'uses' => 'Backend\PostController@force_delete'
            ])->name('force_delete');
            Route::post('/active-inactive-comment', [
                'title' => 'Post: On/Off Comments',
                'uses' => 'Backend\PostController@active_inactive_comment'
            ])->name('active_inactive_comment');
            Route::post('/active-inactive-featured', [
                'title' => 'Post: On/Off Featured',
                'uses' => 'Backend\PostController@active_inactive_featured'
            ])->name('active_inactive_featured');
            Route::post('/activity-log', [
                'title' => 'Post: Activity Log',
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name('activity_log');
        });

        Route::group(['prefix' => 'page', 'as'=>'page.'], function() {
            Route::get('/', [
                'title' => 'Page: Index',
                'uses' => 'Backend\PageController@index'
            ])->name('index');
            Route::get('/add', [
                'title' => 'Page: Add',
                'uses' => 'Backend\PageController@add_edit'
            ])->name('add');
            Route::get('/edit/{post_slug}', [
                'title' => 'Page: Edit',
                'uses' => 'Backend\PageController@add_edit'
            ])->name('edit');
            Route::get('/preview/{post_slug?}', [
                'title' => 'Page: Preview',
                'uses' => 'Backend\PageController@preview'
            ])->name('preview');
            Route::post('/save-update', [
                'title' => 'Page: Save Update',
                'uses' => 'Backend\PageController@save_update'
            ])->name('save_update');
            Route::post('/restore', [
                'title' => 'Page: Restore Delete',
                'uses' => 'Backend\PageController@restore'
            ])->name('restore');
            Route::delete('/soft-delete', [
                'title' => 'Page: Soft Delete',
                'uses' => 'Backend\PageController@soft_delete'
            ])->name('soft_delete');
            Route::delete('/force-delete', [
                'title' => 'Page: Force Delete',
                'uses' => 'Backend\PageController@force_delete'
            ])->name('force_delete');
            Route::post('/activity-log', [
                'title' => 'Page: Activity Log',
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name('activity_log');
        });

        Route::group(['prefix' => 'gallery', 'as'=>'gallery.'], function() {
            Route::get('/', [
                'title' => 'Gallery: Index',
                'uses' => 'Backend\GalleryController@index'
            ])->name('index');
            Route::get('/add', [
                'title' => 'Gallery: Add',
                'uses' => 'Backend\GalleryController@add_edit'
            ])->name('add');
            Route::get('/edit/{post_slug}', [
                'title' => 'Gallery: Edit',
                'uses' => 'Backend\GalleryController@add_edit'
            ])->name('edit');
            Route::get('/preview/{post_slug?}', [
                'title' => 'Gallery: Preview',
                'uses' => 'Backend\GalleryController@preview'
            ])->name('preview');
            Route::post('/save-update', [
                'title' => 'Gallery: Save Update',
                'uses' => 'Backend\GalleryController@save_update'
            ])->name('save_update');
            Route::post('/restore', [
                'title' => 'Gallery: Restore Delete',
                'uses' => 'Backend\GalleryController@restore'
            ])->name('restore');
            Route::delete('/soft-delete', [
                'title' => 'Gallery: Soft Delete',
                'uses' => 'Backend\GalleryController@soft_delete'
            ])->name('soft_delete');
            Route::delete('/force-delete', [
                'title' => 'Gallery: Force Delete',
                'uses' => 'Backend\GalleryController@force_delete'
            ])->name('force_delete');
            Route::post('/activity-log', [
                'title' => 'Gallery: Activity Log',
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name('activity_log');
        });
    });

    Route::group(['middleware' => 'theme'], function(){

        Route::post('/contact-form/save', [
            'title'=>'Contact Message Save',
            'uses'=>'BlogController@contact_message_save'
        ])->name('contact_form');

        Route::get('/search/{search?}', [
            'title' => 'Post Search',
            'uses' => 'BlogController@search'
        ])->name('search');

        Route::get('/category/{post_slug}', [
            'title' => 'Post Category',
            'uses' => 'BlogController@category'
        ])->name('category');

        Route::get('/tag/{post_slug}', [
            'title' => 'Post Tag',
            'uses' => 'BlogController@tag'
        ])->name('tag');

        Route::get("/gallery", [
            'title' => 'Galleries',
            'uses' => 'BlogController@galleries'
        ])->name('galleries');

        Route::get('/archive/{year}/{month}', [
            'title' => 'Post Archive',
            'uses' => 'BlogController@archive'
        ])->name('archive')->where(['year'=> '[0-9]+', 'month' => '[0-9]+']);

        Route::get('/{year}/{month}/{post_slug}', [
            'title' => 'Post Detail Archive',
            'uses' => 'BlogController@archive'
        ])->name('post_archive')->where(['year'=> '[0-9]+', 'month' => '[0-9]+', 'post_slug' => '.*']);

        $blog_url_not_allowed = simple_cms_setting('blog_url_not_allowed');
        $blog_url_not_allowed = explode(',', $blog_url_not_allowed);
        /*$disallowed_prefix = array_merge($blog_url_not_allowed, simple_cms_setting('available_locales'));
        dd(implode('|', $disallowed_prefix));*/
        Route::get('/{post_slug}', [
            'title' => 'Post Detail',
            'post_type' => 'post',
            'uses' => 'BlogController@posts'
        ])->name('post')->where(['post_slug' => '(?!'.implode('|', $blog_url_not_allowed).')[^\/]+' ]);
    });

});
