<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['domain']], function () {
    /*
    |--------------------------------------------------------------------------
    | Welcome Page
    |--------------------------------------------------------------------------
    */
    Route::get('/', 'PagesController@home');
	
	/*
    |--------------------------------------------------------------------------
    | multiple response
    |--------------------------------------------------------------------------
    */
    Route::get('multipleresponse/{survey_uuid}', 'Admin\SurveyController@MultipleResponse');

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
    Route::patch('responses/{survey_id}', 'ResponseController@updateDataSurvey')->name('responses.update-data-survey');

    Route::group([
        'middleware' => ['auth', 'auth.role'],
        'namespace' => 'Api',
        'prefix' => 'api',
    ], function () {
        /*
        |--------------------------------------------------------------------------
        | Country
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix' => 'countries'], function () {
            Route::get('', 'CountryController@index');
            Route::get('{country}', 'CountryController@states');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | get session information when switch clinic
    |--------------------------------------------------------------------------
     */
    Route::get('sessionlogin/{id}/{clinic_id}', 'Admin\UserController@setsession');

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
            Route::get('signature', 'SignatureController@edit');
            Route::get('signature/download', 'SignatureController@download');
            Route::patch('signature', 'SignatureController@update');
            Route::get('password', 'PasswordController@edit');
            Route::post('password', 'PasswordController@update');
        });

        /*
        |--------------------------------------------------------------------------
        | Client
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix' => 'clients', 'middleware' => 'requires-clinic', 'namespace' => 'Client'], function () {
            Route::get('', 'ClientController@index');
            Route::post('search', 'ClientController@search');
            Route::get('{user_id}', 'ClientController@show');

            Route::group(['middleware' => 'requires-clinic'], function () {
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

                Route::group(['prefix' => '{user_id}/attachments'], function () {
                    Route::post('', 'AttachmentController@store');
                    Route::get('create', 'AttachmentController@create');
                    Route::get('{attachment_id}/download', 'AttachmentController@download');
                    Route::get('{attachment_id}', 'AttachmentController@show');
                });

                Route::group(['prefix' => '{user_id}/communication'], function () {
                    Route::post('', 'CommunicationLogController@store');
                    Route::get('create', 'CommunicationLogController@create');
                    Route::get('{communication_log_id}', 'CommunicationLogController@show');
                });

			Route::get('{user_id}/surveys/assign', 'AssignSurveyController@assign');
			Route::post('{user_id}/surveys/assign', 'AssignSurveyController@postassign');
			Route::get('{user_id}/surveys', 'AssignSurveyController@index');

                Route::group(['prefix' => '{user_id}/receipts'], function () {
                    Route::post('', 'ReceiptController@store');
                    Route::get('create', 'ReceiptController@create');
                    Route::get('{receipt_id}/download', 'ReceiptController@download');
                });
            });
        });

        /*
        |--------------------------------------------------------------------------
        | Notes and Questionnaire for Group
        |--------------------------------------------------------------------------
        */
        Route::group(['middleware' => 'requires-clinic'], function () {
            Route::get('groups', 'Admin\GroupController@index');
            Route::post('groups/search', 'Admin\GroupController@search');
            Route::get('groups/search', 'Admin\GroupController@index');
        });

        Route::group([
            'prefix' => 'groups',
            'middleware' => 'requires-clinic',
            'namespace' => 'Group',
        ], function () {
            Route::get('{group_id}/notes', 'NoteController@index');
            Route::post('{group_id}/notes', 'NoteController@store');
            Route::post('{group_id}/notes/{note_id}/addition', 'NoteController@addAddition');
            Route::get('{group_id}/notes/create', 'NoteController@create');
            Route::get('{group_id}/notes/{note_id}', 'NoteController@show');
            Route::put('{group_id}/notes/{note_id}', 'NoteController@update');

            Route::get('{group_id}/questionnaires', 'QuestionnaireController@index');
            Route::get('{group_id}/questionnaires/create', 'QuestionnaireController@create');
            Route::get('{group_id}/questionnaires/{response_id}', 'QuestionnaireController@show');
            Route::post('{group_id}/questionnaires', 'QuestionnaireController@store');

            Route::group(['prefix' => '{group_id}/attachments'], function () {
                Route::post('', 'AttachmentController@store');
                Route::get('create', 'AttachmentController@create');
                Route::get('{attachment_id}/download', 'AttachmentController@download');
                Route::get('{attachment_id}', 'AttachmentController@show');
            });

            Route::group(['prefix' => '{group_id}/communication'], function () {
                Route::post('', 'CommunicationLogController@store');
                Route::get('create', 'CommunicationLogController@create');
                Route::get('{communication_log_id}', 'CommunicationLogController@show');
            });

            Route::group(['prefix' => '{group_id}/receipts'], function () {
                Route::post('', 'ReceiptController@store');
                Route::get('create', 'ReceiptController@create');
                Route::get('{receipt_id}/download', 'ReceiptController@download');
            });
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
            | Surveys
            |--------------------------------------------------------------------------
            */
			Route::resource('surveys', 'SurveyController', ['except' => ['show']]);
            Route::post('surveys/search', 'SurveyController@search');
            Route::get('surveys/search', 'SurveyController@index');
            /*
            |--------------------------------------------------------------------------
            | Doctors
            |--------------------------------------------------------------------------
            */
            Route::get('doctors', 'DoctorController@index');
            Route::get('doctors/create', 'DoctorController@create');
            Route::post('doctors', 'DoctorController@store');
            Route::delete('doctors/{doctor_id}', 'DoctorController@destroy');
            Route::get('doctors/{doctor_id}/edit', 'DoctorController@edit');
            Route::patch('doctors/{doctor_id}', 'DoctorController@update');
            Route::post('doctors/search', 'DoctorController@search');
            Route::get('doctors/search', 'DoctorController@index');

            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            */
            Route::get('users/search', 'UserController@index');
            Route::get('users/invite', 'UserController@getInvite');
            Route::group(['middleware' => 'requires-clinic'], function () {
                Route::get('users/add', 'UserController@getassignclinic');
                Route::post('users/assign', 'UserController@postassignclinic');
            });
            Route::get('users/inactivate/{id}', 'UserController@inactivateUser');
            Route::get('users/activate/{id}', 'UserController@activateUser');
            Route::post('users/search', 'UserController@search');
            Route::get('users/switch/{id}', 'UserController@switchToUser');
            Route::post('users/switch-clinic', 'UserController@switchToClinic');
            Route::get('users/switch-clinic-back', 'UserController@switchClinicBack');
            Route::post('users/invite', 'UserController@postInvite');
            Route::get('clients', 'UserController@index')->name('admin.clients');
            Route::get('therapists', 'UserController@index')->name('admin.therapists');
            Route::resource('users', 'UserController', ['except' => ['create']]);
            /*
            |--------------------------------------------------------------------------
            | Therapist Management
            |--------------------------------------------------------------------------
            */
            Route::group(['middleware' => 'requires-clinic'], function () {
                Route::get('users/{user_id}/therapists', 'TherapistController@index');
                Route::post('users/{user_id}/therapists', 'TherapistController@store');
                Route::delete('users/{user_id}/therapists/{therapist_id}', 'TherapistController@destroy');
            });

            /*
            |--------------------------------------------------------------------------
            | Groups Management
            |--------------------------------------------------------------------------
            */
            Route::group(['middleware' => 'requires-clinic'], function () {
                Route::get('users/{user_id}/groups', 'GroupController@index');
                Route::post('users/{user_id}/groups', 'GroupController@store');
                Route::delete('users/{user_id}/groups/{group_id}', 'GroupController@destroy');
            });

            /*
            |--------------------------------------------------------------------------
            | Clinic Management
            |--------------------------------------------------------------------------
            */
            Route::get('clinics', 'ClinicController@index');
            Route::get('clinics/create', 'ClinicController@create');
            Route::post('clinics', 'ClinicController@store');
            Route::delete('clinics/{clinic_id}', 'ClinicController@destroy');
            Route::get('clinics/{clinic_id}/edit', 'ClinicController@edit');
            Route::patch('clinics/{clinic_id}', 'ClinicController@update');
            Route::post('clinics/search', 'ClinicController@search');
            Route::get('clinics/search', 'ClinicController@index');
            Route::group(['prefix' => 'clinics'], function () {
                Route::get('{clinic_id}/assignclinic', 'UserClinicController@index');
                Route::get('{clinic_id}/assignclinic/create', 'UserClinicController@create');
                Route::post('{clinic_id}/assignRoletoClinic/{user_id}', 'UserClinicController@assignRoletoClinic');
                Route::post('{clinic_id}/assignclinic', 'UserClinicController@store');
                Route::delete('{user_id}/assignclinic', 'UserClinicController@destroy');
                Route::post('{clinic_id}/assignclinic/search', 'UserClinicController@search');
                Route::get('{clinic_id}/assignclinic/search', 'UserClinicController@index');
            });
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
            Route::group(['middleware' => 'requires-clinic'], function () {
                Route::resource('groups', 'GroupController', ['except' => ['show']]);
                Route::post('groups/search', 'GroupController@search');
                Route::get('groups/search', 'GroupController@index');
            });

            /*
            |--------------------------------------------------------------------------
            | Logs
            |--------------------------------------------------------------------------
            */
            Route::resource('logs', 'LogAuditController');
        });
    });
});
