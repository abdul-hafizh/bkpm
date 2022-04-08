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
$allowed_social = [];
if (!app()->runningInConsole()) {
    foreach (app('config')->get('acl.auth_social_media') as $key => $item) {
        if ($item['client_id'] && $item['client_secret'] && $item['redirect']) {
            array_push($allowed_social, $key);
        }
    }
}
$allowed_social = implode('|', $allowed_social);
$simple_cms = config('acl.name');
Route::group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['localize'], 'as'=>'simple_cms.acl.','simple_cms'=>$simple_cms], function() use($allowed_social)
{
    Route::group(['prefix' => 'auth','as'=>'auth.'], function() use($allowed_social)
    {
        Route::get('/login', [
            'title' => 'Auth: Login',
            'uses' => 'Auth\LoginController@showLoginForm'
        ])->name('login');

        Route::post('/login', [
            'title' => 'Auth: Login',
            'uses' => 'Auth\LoginController@login'
        ])->name('loginPost');

        Route::post('/logout', [
            'title' => 'Auth: Logout',
            'uses' => 'Auth\LoginController@logout'
        ])->name('logout');

        /* Register */
        Route::get('/register', [
            'title' => 'Auth: Register Form',
            'uses' => 'Auth\RegisterController@showRegistrationForm'
        ])->name('register')->middleware(['guest']);
        Route::post('/register', [
            'title' => 'Auth: Register',
            'uses' => 'Auth\RegisterController@register'
        ])->name('registerPost')->middleware(['guest']);
        /* End Register */

        /* Password Reset */
        Route::get('/password/reset', [
            'title' => 'Auth: Password Reset',
            'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
        ])->name('password.request')->middleware(['guest']);
        Route::post('/password/email', [
            'title' => 'Auth: Password Reset',
            'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
        ])->name('password.email')->middleware(['guest']);
        /* ============== */
        Route::get('/password/reset/{token}', [
            'title' => 'Auth: Password Reset Form',
            'uses' => 'Auth\ResetPasswordController@showResetForm'
        ])->name('password.reset')->middleware(['guest']);

        Route::post('/password/reset', [
            'title' => 'Auth: Password Reset Update',
            'uses' => 'Auth\ResetPasswordController@reset'
        ])->name('password.update')->middleware(['guest']);
        /* End Password Reset */

        /* Confirm Password */
        Route::get('/password/confirm', [
            'title' => 'Auth: Password Confirm',
            'uses' => 'Auth\ConfirmPasswordController@showConfirmForm'
        ])->name('password.confirm')->middleware(['guest']);
        Route::post('/password/confirm', [
            'title' => 'Auth: Password Confirm',
            'uses' => 'Auth\ConfirmPasswordController@confirm'
        ])->name('password.confirm')->middleware(['guest']);
        /* End Confirm Password */

        /* Verification */
        Route::get('/email/verify', [
            'title' => 'Auth: Email Verify',
            'uses' => 'Auth\VerificationController@show'
        ])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [
            'title' => 'Auth: Email Verify',
            'uses' => 'Auth\VerificationController@verify'
        ])->name('verification.verify');
        Route::post('/email/verify-resend', [
            'title' => 'Auth: Email Verify Resend',
            'uses' => 'Auth\VerificationController@resend'
        ])->name('verification.resend');
        /* End Verification */

        /* Auth Socialite */
        if (!empty($allowed_social)) {
            Route::get('/{social}/login', [
                'title' => 'Auth Socialite Login',
                'uses' => 'Auth\LoginController@socialLogin'
            ])->name('social.login')
                ->where('social', $allowed_social)->middleware(['guest']);
            Route::get('/{social}/callback', [
                'title' => 'Auth Socialite Callback',
                'uses' => 'Auth\LoginController@handleProviderCallback'
            ])->name('social.callback')
                ->where('social', $allowed_social)->middleware(['guest']);
        }
    });

    /* BACKEND */
    Route::group(['middleware' => ['permission'], 'prefix' => 'backend', 'as'=>'backend.'], function()
    {
        Route::group(['prefix' => 'user', 'as'=>'user.'], function()
        {
            Route::get('/', [
                'title' => 'User: Index',
                'uses' => 'User\UserController@index'
            ])->name('index');

            Route::get('/add', [
                'title' => 'User: Add',
                'uses' => 'User\UserController@add'
            ])->name('add');
            Route::get('/edit/{id}', [
                'title' => 'User: Edit',
                'uses' => 'User\UserController@edit'
            ])->name('edit');
            Route::post('/save-update', [
                'title' => 'User: Save Update',
                'uses' => 'User\UserController@save_update'
            ])->name('save_update');
            Route::post('/import', [
                'title' => 'User: Import',
                'uses' => 'User\UserController@import'
            ])->name('import');

            Route::delete('/soft-delete', [
                'title' => 'User: Soft Delete',
                'uses' => 'User\UserController@soft_delete'
            ])->name('soft_delete');
            Route::delete('/force-delete', [
                'title' => 'User: Force Delete',
                'uses' => 'User\UserController@force_delete'
            ])->name('force_delete');
            Route::post('/restore', [
                'title' => 'User: Restore',
                'uses' => 'User\UserController@restore'
            ])->name('restore');
            Route::post('/activity-log', [
                'title' => 'User: Activity Log',
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name('activity_log');

            Route::get('/profile', [
                'title' => 'User: Profile',
                'uses' => 'User\UserController@profile'
            ])->name('profile');
            Route::put('/profile', [
                'title' => 'User: Update Profile',
                'uses' => 'User\UserController@update_profile'
            ])->name('update_profile');

            Route::get('/password', [
                'title' => 'User: Password',
                'uses' => 'User\UserController@password'
            ])->name('password');
            Route::put('/update-password', [
                'title' => 'User: Update Password',
                'uses' => 'User\UserController@update_password'
            ])->name('update_password');

            Route::get('/activity', [
                'title' => 'User: Activity',
                'uses' => 'User\UserController@user_activity'
            ])->name('activity');
            Route::get('/setting', [
                'title' => 'User: Setting',
                'uses' => 'User\UserController@user_setting'
            ])->name('setting');
        });

        Route::group(['prefix' => 'role', 'as'=>'role.'], function()
        {
            Route::get('/', [
                'title' => 'Role: Index',
                'uses' => 'Role\RoleController@index'
            ])->name('index');
            Route::get('/add', [
                'title' => 'Role: Add',
                'uses' => 'Role\RoleController@add'
            ])->name('add');
            Route::get('/edit/{id}', [
                'title' => 'Role: Edit',
                'uses' => 'Role\RoleController@edit'
            ])->name('edit');
            Route::post('/save-update', [
                'title' => 'Role: Save Update',
                'uses' => 'Role\RoleController@save_update'
            ])->name('save_update');

            Route::delete('/soft-delete', [
                'title' => 'Role: Soft Delete',
                'uses' => 'Role\RoleController@soft_delete'
            ])->name('soft_delete');
            /*Route::delete('/force-delete', [
                'title' => 'Force Delete Group',
                'uses' => 'Role\RoleController@force_delete'
            ])->name('force_delete');*/
            Route::post('/restore', [
                'title' => 'Role: Restore',
                'uses' => 'Role\RoleController@restore'
            ])->name('restore');
            Route::post('/activity-log', [
                'title' => 'Role: Activity Log',
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name('activity_log');

        });

        Route::group(['prefix' => 'group', 'as'=>'group.'], function()
        {
            Route::get('/', [
                'title' => 'Group: Index',
                'uses' => 'Group\GroupController@index'
            ])->name('index');
            Route::get('/add', [
                'title' => 'Group: Add',
                'uses' => 'Group\GroupController@add'
            ])->name('add');
            Route::get('/edit/{id}', [
                'title' => 'Group: Edit',
                'uses' => 'Group\GroupController@edit'
            ])->name('edit');
            Route::post('/save-update', [
                'title' => 'Group: Save Update',
                'uses' => 'Group\GroupController@save_update'
            ])->name('save_update');

            Route::delete('/soft-delete', [
                'title' => 'Group: Soft Delete',
                'uses' => 'Group\GroupController@soft_delete'
            ])->name('soft_delete');
            /*Route::delete('/force-delete', [
                'title' => 'Force Delete Group',
                'uses' => 'Group\GroupController@force_delete'
            ])->name('force_delete');*/
            Route::post('/restore', [
                'title' => 'Group: Restore',
                'uses' => 'Group\GroupController@restore'
            ])->name('restore');
            Route::post('/activity-log', [
                'title' => 'Group: Activity Log',
                'uses' => '\\SimpleCMS\ActivityLog\Http\Controllers\ActivityLogController@modal'
            ])->name('activity_log');

        });
    });
});
