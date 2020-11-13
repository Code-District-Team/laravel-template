<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth.middleware', 'tenant'])->group(function() {
        
        // Tenant.
        Route::get('tenant/get', 'TenantController@get')->name('getTenant');
        
        // Users.
        Route::get('user/logout', 'UserController@logout')->name('userLogout');
});

// User
Route::post('user/login', 'UserController@login')->name('loginUser');
Route::post('user/register', 'UserController@register')->name('registerUser');
Route::post('user/send_password_reset_token', 'ResetPasswordController@sendPasswordResetToken')->name('SendPasswordResetToken');
Route::post('user/reset_password', 'ResetPasswordController@resetPassword')->name('ResetPassword');