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

        Route::get('records/{recordType}', 'RecordTypeRecordController@index');
        Route::get('records/{recordType}/{record}', 'RecordController@show');

        Route::resource('records', 'RecordController')->except([
            'index', 'show'
        ]);

        Route::get('records/{recordType}/{record}/programs', 'RecordProgramsController@index');
        Route::get('records/{recordType}/{record}/available-programs', 'ProgramsAvailableForRecord');   
        Route::post('records/{recordType}/{record}/programs/{program}', 'RecordProgramsController@store');
        Route::delete('records/{recordType}/{record}/programs/{program}', 'RecordProgramsController@destroy');

        Route::get('records/{recordType}/{record}/groups', 'RecordGroupsController@index');
        Route::get('records/{recordType}/{record}/available-groups', 'GroupsAvailableForRecord');
        Route::post('records/{recordType}/{record}/groups/{group}', 'RecordGroupsController@store');
        Route::delete('records/{recordType}/{record}/groups/{group}', 'RecordGroupsController@destroy');

        Route::resource('programs', 'ProgramController');

        Route::get('programs/{program}/groups', 'ProgramGroupsController@index');

        Route::get('programs/{program}/records/{recordType}', 'ProgramRecordsController@index');
        Route::get('programs/{program}/available-records/{recordType}', 'RecordsAvailableForProgram');
        Route::get('programs/edit/{program}/records/{recordType}/{record}', 'ProgramRecordsController@edit');
        Route::patch('programs/{program}/records/{recordType}/{record}', 'ProgramRecordsController@update');
        Route::post('programs/{program}/records/{recordType}/{record}', 'ProgramRecordsController@store');
        Route::delete('programs/{program}/records/{recordType}/{record}', 'ProgramRecordsController@destroy');

        Route::resource('groups', 'GroupController');

        Route::get('groups/{group}/records/{recordType}', 'GroupRecordsController@index');
        Route::get('groups/{group}/available-records/{recordType}', 'RecordsAvailableForGroup');
        Route::post('groups/{group}/records/{recordType}/{record}', 'GroupRecordsController@store');

        Route::resource('roles', 'RoleController');

        Route::post('roles/{role}/permissions/{permission}', 'RolePermissionController@store');
        Route::delete('roles/{role}/permissions/{permission}', 'RolePermissionController@destroy');
});
