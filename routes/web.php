<?php
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/', 'ShowHome');
Route::get('/dashboard', 'ShowHome');
Route::get('/records', 'ShowHome')->where('all', '(.*)');
Route::get('/records/{all}', 'ShowHome')->where('all', '(.*)');
Route::get('/programs', 'ShowHome')->where('all', '(.*)');
Route::get('/programs/{all}', 'ShowHome')->where('all', '(.*)');

Route::get('/preferences', 'ShowPreferences');
Route::get('/preferences/{all}', 'ShowPreferences')->where('all', '(.*)');

Route::prefix('api')
    ->middleware('auth')
    ->group( function() {
        Route::get('records/create', 'RecordController@create');

        Route::get('records/{recordType}', 'RecordTypeRecordController@index');
        Route::get('records/{recordType}/{record}', 'RecordController@show');
        Route::get('records/{recordType}/{record}/programs', 'RecordProgramsController@index');

        Route::get('programs', 'ProgramController@index');
        Route::get('programs/{program}', 'ProgramController@show');

        Route::get('roles', 'RoleController@index');
        Route::get('roles/create', 'RoleController@create');
        Route::post('role', 'RoleController@store');
        Route::get('roles/edit', 'RoleController@edit');
        Route::patch('role/{role}', 'RoleController@update');
        Route::delete('role/{role}', 'RoleController@delete');

        Route::post('role/{role}/permission/{permission}', 'RolePermissionController@store');
        Route::delete('role/{role}/permission/{permission}', 'RolePermissionController@destroy');
});
