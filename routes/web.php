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
*/

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// SPA Routes
Route::get('/', 'ShowHome');
Route::get('/dashboard', 'ShowHome');
Route::get('/files', 'ShowHome')->where('all', '(.*)');
Route::get('/files/{all}', 'ShowHome')->where('all', '(.*)');
Route::get('/programs/{all}', 'ShowHome')->where('all', '(.*)');

Route::get('/preferences', 'ShowPreferences');
Route::get('/preferences/{all}', 'ShowPreferences')->where('all', '(.*)');

// Private API Routes
Route::prefix('api')
    ->middleware('auth')
    ->group( function() {
        Route::get('files/create', 'FileController@create');
        Route::get('files/{fileType}', 'FileController@index');
        Route::get('files/{fileType}/{file}', 'FileController@show');

        Route::get('programs/{program}', 'ProgramController@show');

        Route::get('roles', 'RoleController@index');
});
