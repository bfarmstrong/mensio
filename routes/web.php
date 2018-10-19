<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/
Route::get('/', 'PagesController@home');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

/*
|--------------------------------------------------------------------------
| Reset Password
|--------------------------------------------------------------------------
*/
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/*
|--------------------------------------------------------------------------
| Questionnaires
|--------------------------------------------------------------------------
*/
Route::get('responses/{response_id}/external', 'ResponseController@showExternal')->name('responses.show-external');
Route::patch('responses/{response_id}/data', 'ResponseController@updateData')->name('responses.update-data');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth', 'auth.role']], function () {
    /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    */
    Route::get('/users/switch-back', 'Admin\UserController@switchUserBack');

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('settings', 'SettingsController@edit');
        Route::post('settings', 'SettingsController@update');
        Route::get('password', 'PasswordController@edit');
        Route::post('password', 'PasswordController@update');
    });

    /*
    |--------------------------------------------------------------------------
    | Client
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'clients', 'namespace' => 'Client'], function () {
        Route::get('', 'ClientController@index');
        Route::post('search', 'ClientController@search');
        Route::get('{user_id}', 'ClientController@show');

        Route::get('{user_id}/notes', 'NoteController@index');
        Route::post('{user_id}/notes', 'NoteController@store');
        Route::post('{user_id}/notes/{note_id}/addition', 'NoteController@addAddition');
        Route::get('{user_id}/notes/create', 'NoteController@create');
        Route::get('{user_id}/notes/{note_id}', 'NoteController@show');
        Route::put('{user_id}/notes/{note_id}', 'NoteController@update');

        Route::get('{user_id}/questionnaires', 'QuestionnaireController@index');
        Route::get('{user_id}/questionnaires/create', 'QuestionnaireController@create');
        Route::post('{user_id}/questionnaires', 'QuestionnaireController@store');
        Route::delete('{user_id}/questionnaires/{questionnaire_id}', 'QuestionnaireController@destroy');
        Route::get('{user_id}/questionnaires/{response_id}', 'QuestionnaireController@show');
    });

    /*
    |--------------------------------------------------------------------------
    | Responses
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'responses'], function () {
        Route::get('', 'ResponseController@index');
        Route::get('{response_id}', 'ResponseController@show');
    });

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', 'PagesController@dashboard');

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
        Route::get('dashboard', 'DashboardController@index');

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */
        Route::get('users/search', 'UserController@index');
        Route::get('users/invite', 'UserController@getInvite');
        Route::post('users/search', 'UserController@search');
        Route::get('users/switch/{id}', 'UserController@switchToUser');
        Route::post('users/invite', 'UserController@postInvite');
        Route::resource('users', 'UserController', ['except' => ['create']]);

        /*
        |--------------------------------------------------------------------------
        | Therapist Management
        |--------------------------------------------------------------------------
        */
        Route::get('users/{user_id}/therapists', 'TherapistController@index');
        Route::post('users/{user_id}/therapists', 'TherapistController@store');
        Route::delete('users/{user_id}/therapists/{therapist_id}', 'TherapistController@destroy');

		/*
        |--------------------------------------------------------------------------
        | Groups Management
        |--------------------------------------------------------------------------
        */
        Route::get('users/{user_id}/groups', 'GroupController@index');
        Route::post('users/{user_id}/groups', 'GroupController@store');
        Route::delete('users/{user_id}/groups/{group_id}', 'GroupController@destroy');
		
        /*
        |--------------------------------------------------------------------------
        | Supervisor Management
        |--------------------------------------------------------------------------
        */
        Route::patch('users/{user_id}/therapists/{therapist_id}/supervisors', 'SupervisorController@update');

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */
        Route::resource('roles', 'RoleController', ['except' => ['show']]);
        Route::post('roles/search', 'RoleController@search');
        Route::get('roles/search', 'RoleController@index');
		
        /*
        |--------------------------------------------------------------------------
        | Groups
        |--------------------------------------------------------------------------
        */
        Route::resource('groups', 'GroupController', ['except' => ['show']]);
        Route::post('groups/search', 'GroupController@search');
        Route::get('groups/search', 'GroupController@index');

        /*
        |--------------------------------------------------------------------------
        | Logs
        |--------------------------------------------------------------------------
        */
        Route::resource('logs', 'LogAuditController');
    });
});
