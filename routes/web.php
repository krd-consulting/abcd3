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
Route::get('/groups', 'ShowHome')->where('all', '(.*)');
Route::get('/groups/{all}', 'ShowHome')->where('all', '(.*)');
Route::get('/teams', 'ShowHome')->where('all', '(.*)');
Route::get('/teams/{all}', 'ShowHome')->where('all', '(.*)');

Route::get('/preferences', 'ShowPreferences');
Route::get('/preferences/{all}', 'ShowPreferences')->where('all', '(.*)');

Route::prefix('api')
    ->middleware('auth')
    ->group( function() {
        Route::get('record-types', 'RecordTypeController@index');

        Route::get('records/create', 'RecordController@create');
        Route::get('records/edit/{record}', 'RecordController@edit');
        Route::patch('records/{record}', 'RecordController@update');
        Route::get('records/{recordType}', 'RecordTypeRecordController@index');
        Route::get('records/{recordType}/{record}', 'RecordController@show');
        Route::post('records/', 'RecordController@store');
        Route::delete('records/{record}', 'RecordController@destroy');

        Route::get('records/{recordType}/{record}/programs', 'RecordProgramsController@index');
        Route::post('records/{recordType}/{record}/programs/{program}', 'RecordProgramsController@store');
        Route::delete('records/{recordType}/{record}/programs/{program}', 'RecordProgramsController@destroy');

        Route::get('programs', 'ProgramController@index');
        Route::get('programs/create', 'ProgramController@create');
        Route::get('programs/edit/{program}', 'ProgramController@edit');
        Route::patch('programs/{record}', 'ProgramController@update');
        Route::get('programs/{program}', 'ProgramController@show');
        Route::post('programs/', 'ProgramController@store');
        Route::delete('programs/{program}', 'ProgramController@destroy');

        Route::get('programs/{program}/groups', 'ProgramGroupsController@index');

        Route::get('programs/{program}/records/{recordType}', 'ProgramRecordsController@index');
        Route::get('programs/edit/{program}/records/{recordType}/{record}', 'ProgramRecordsController@edit');
        Route::patch('programs/{program}/records/{recordType}/{record}', 'ProgramRecordsController@update');
        Route::post('programs/{program}/records/{recordType}/{record}', 'ProgramRecordsController@store');
        Route::delete('programs/{program}/records/{recordType}/{record}', 'ProgramRecordsController@destroy');

        Route::get('groups', 'GroupController@index');
        Route::get('groups/create', 'GroupController@create');
        Route::get('groups/edit/{group}', 'GroupController@edit');
        Route::patch('groups/{group}', 'GroupController@update');
        Route::get('groups/{group}', 'GroupController@show');
        Route::post('groups', 'GroupController@store');
        Route::delete('groups/{group}', 'GroupController@destroy');

        Route::get('roles', 'RoleController@index');
        Route::get('roles/create', 'RoleController@create');
        Route::post('roles', 'RoleController@store');
        Route::get('roles/edit', 'RoleController@edit');
        Route::patch('roles/{role}', 'RoleController@update');
        Route::delete('roles/{role}', 'RoleController@destroy');

        Route::post('roles/{role}/permissions/{permission}', 'RolePermissionController@store');
        Route::delete('roles/{role}/permissions/{permission}', 'RolePermissionController@destroy');
});
