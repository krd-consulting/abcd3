<?php
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::prefix('api')
    ->middleware('auth')
    ->group( function() {
        Route::get('record-types', 'RecordTypeController@index');
        Route::get('record-types/{recordType}', 'RecordTypeController@show');

        Route::get('records/{recordType}', 'RecordTypeRecordController@index');
        Route::get('records/{recordType}/create', 'RecordController@create');
        Route::get('records/{recordType}/{record}/edit', 'RecordController@edit');
        Route::get('records/{recordType}/{record}', 'RecordController@show');
        Route::post('records/{recordType}', 'RecordController@store');
        Route::patch('records/{recordType}/{record}', 'RecordController@update');
        Route::delete('records/{recordType}/{record}', 'RecordController@destroy');

        Route::get('records/{recordType}/{record}/programs', 'RecordProgramsController@index');
        Route::get('records/{recordType}/{record}/available-programs', 'ProgramsAvailableForRecord');
        Route::post('records/{recordType}/{record}/programs/{program}', 'RecordProgramsController@store');
        Route::delete('records/{recordType}/{record}/programs/{program}', 'RecordProgramsController@destroy');

        Route::get('records/{recordType}/{record}/groups', 'RecordGroupsController@index');
        Route::get('records/{recordType}/{record}/available-groups', 'GroupsAvailableForRecord');
        Route::post('records/{recordType}/{record}/groups/{group}', 'RecordGroupsController@store');
        Route::delete('records/{recordType}/{record}/groups/{group}', 'RecordGroupsController@destroy');

        Route::get('records/{recordType}/{record}/teams', 'RecordTeamsController@index');
        Route::get('records/{recordType}/{record}/available-teams', 'TeamsAvailableForRecord');
        Route::post('records/{recordType}/{record}/teams/{team}', 'RecordTeamsController@store');
        Route::delete('records/{recordType}/{record}/teams/{team}', 'RecordTeamsController@destroy');

        Route::get('records/{recordType}/{record}/teams', 'RecordTeamsController@index');
        Route::get('records/{recordType}/{record}/available-teams', 'TeamsAvailableForRecord');

        Route::get('records/{recordType}/{record}/collections/{collection}', 'RecordCollectionController@index');
        Route::post('records/{recordType}/{record}/collections/{collection}/{item}', 'RecordCollectionController@store');
        Route::get('records/{recordType}/{record}/collections/{collection}/available', 'RecordCollectionController@available');

        Route::get('programs/client-statuses', 'ClientStatusController@index');
        Route::get('programs/client-statuses/{status}/edit', 'ClientStatusController@edit');
        Route::post('programs/client-statuses', 'ClientStatusController@store');
        Route::patch('programs/client-statuses/{status}', 'ClientStatusController@update');
        Route::delete('programs/client-statuses/{status}', 'ClientStatusController@destroy');

        Route::resource('programs', 'ProgramController');

        Route::get('programs/{program}/groups', 'ProgramGroupsController@index');

        Route::get(
            'programs/{program}/records/{recordType}/{record}/available-cases',
            'RecordsAvailableForCaseload'
        );
        Route::get('programs/{program}/records/{recordType}/{record}/cases', 'CaseController@index');
        Route::post('programs/{program}/records/{recordType}/{record}/cases/{case}', 'CaseController@store');
        Route::delete(
            'programs/{program}/records/{recordType}/{record}/cases/{case}',
            'CaseController@destroy'
        );

        Route::get('programs/{program}/records/{recordType}', 'ProgramRecordsController@index');
        Route::get('programs/{program}/available-records/{recordType}', 'RecordsAvailableForProgram');
        Route::get('programs/{program}/records/{recordType}/{record}/edit', 'ProgramRecordsController@edit');
        Route::patch('programs/{program}/records/{recordType}/{record}', 'ProgramRecordsController@update');
        Route::post('programs/{program}/records/{recordType}/{record}', 'ProgramRecordsController@store');
        Route::delete('programs/{program}/records/{recordType}/{record}', 'ProgramRecordsController@destroy');

        Route::resource('groups', 'GroupController');

        Route::get('groups/{group}/records/{recordType}', 'GroupRecordsController@index');
        Route::get('groups/{group}/available-records/{recordType}', 'RecordsAvailableForGroup');
        Route::post('groups/{group}/records/{recordType}/{record}', 'GroupRecordsController@store');
        Route::delete('groups/{group}/records/{recordType}/{record}', 'GroupRecordsController@destroy');

        Route::resource('teams', 'TeamController');

        Route::get('teams/{team}/records/{recordType}', 'TeamRecordsController@index');
        Route::get('teams/{team}/available-records/{recordType}', 'RecordsAvailableForTeam');
        Route::post('teams/{team}/records/{recordType}/{record}', 'TeamRecordsController@store');
        Route::delete('teams/{team}/records/{recordType}/{record}', 'TeamRecordsController@destroy');

        Route::get('teams/{team}/programs', 'TeamProgramsController@index');

        Route::get('teams/{team}/groups', 'TeamGroupsController@index');
        Route::get('teams/{team}/groups/create', 'GroupController@create');

        Route::get('forms/fields/target_types', 'FormFieldTargetTypeController@index');
        Route::get('forms/fields/target_types/{targetType}', 'FormFieldTargetTypeController@show');

        Route::get('forms', 'FormController@index');
        Route::get('forms/records/{record}', 'RecordFormsController@index');
        Route::get('forms/collections/{collection}/{id}', 'CollectionFormsController@index');
        Route::get('forms/entity-types/{entityType}/{id}', 'EntityTypeFormsController@index');
        Route::get('forms/create', 'FormController@create');
        Route::get('forms/{form}', 'FormController@show');
        Route::get('forms/{form}/edit', 'FormController@edit');
        Route::get('forms/{form}/field-data/{field}', 'FormController@fieldData');
        Route::post('forms/create', 'ValidateForm');
        Route::post('forms', 'FormController@store');
        Route::patch('forms/{form}', 'FormController@update');
        Route::delete('forms/{form}', 'FormController@destroy');

        Route::get('forms/{form}/fields', 'FormFieldController@index');
        Route::get('form-fields/{field}', 'FormFieldController@show');

        Route::get('forms/{form}/entries', 'FormEntryController@index');
        Route::get('forms/{form}/entries/teams', 'FormEntryController@teams');
        Route::post('forms/{form}', 'FormEntryController@store');

        Route::get('form-fields/{field}/entries', 'FormFieldEntries');
        Route::get('form-fields/{field}/values', 'FormFieldValues');

        Route::resource('roles', 'RoleController')->except('show');

        Route::post('roles/{role}/permissions/{permission}', 'RolePermissionController@store');
        Route::delete('roles/{role}/permissions/{permission}', 'RolePermissionController@destroy');

        Route::get('attachments/{attachment}', 'AttachmentController@show');
        Route::post('attachments', 'AttachmentController@store');
        Route::delete('attachments/{attachment}', 'AttachmentController@destroy');

        Route::get('collections', 'CollectionController@index');
        Route::get('collections/{collection}', 'CollectionController@show');

        Route::get('organisation-setting', 'OrganisationSettingController@show');
        Route::post('organisation-setting', 'OrganisationSettingController@update');
});

Route::get('downloads/attachments/{attachment}', 'AttachmentController@download');

// Catch All Route
Route::get('/{all}', 'ShowHome')->where('all', '(.*)');
