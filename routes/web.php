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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['checkLogin', 'CheckAdmin']], function () {
    Route::get('/', 'DashboardController@index')->name('admin.index');

    Route::get('/roles/get-roles', 'RoleController@getRoles')->name('roles.get_roles');
    Route::post('/roles/update-permission-role', 'RoleController@updatePermissionRole')->name('roles.update_permission_role');
    Route::get('/roles/get-permission-role/{role_id}', 'RoleController@getPermissionRole')->name('roles.get_permission_role');
    Route::resource('roles', 'RoleController');

    Route::post('/users/update-role-user', 'UserController@updateRoleUser')->name('users.update_role_user');
    Route::resource('users', 'UserController');

    Route::resource('positions', 'PositionController');
    Route::resource('workspaces', 'WorkspaceController');
    Route::resource('programs', 'ProgramController');
    Route::resource('locations', 'LocationController');
    Route::resource('userdisables', 'UserDisableController');
    Route::get('/traineelists/{id}', 'UserController@getListTrainee');

    Route::group(['prefix' => 'schedule', 'as' => 'schedule.'], function () {
        Route::get('/', 'WorkingScheduleController@chooseWorkplace')->name('workplace.list');
        Route::get('/{id}', 'WorkingScheduleController@viewByWorkplace')->name('workplace.view');
        Route::get('/{id}/get', 'WorkingScheduleController@getData')->name('workplace.get_data');
        Route::get('/{id}/one', 'WorkingScheduleController@getOneDate')->name('workplace.get_one_date');
        Route::get('location/{id}', 'WorkingScheduleController@viewByLocation')->name('location.month');
        Route::get('users/{id}', 'WorkingScheduleController@viewByUser');
        Route::get('users/{id}/get', 'WorkingScheduleController@getDataUser');
    });

    Route::group(['prefix' => 'calendar', 'as' => 'calendar.'], function () {
        Route::get('/', 'SittingCalendarController@chooseWorkplace')->name('workplace.list');
        Route::get('/workplace/{id}', 'SittingCalendarController@locationList')->name('location.list');
        Route::get('location/{id}', 'SittingCalendarController@locationAnalystic')->name('location.view');
        Route::get('location/{id}/analystic', 'SittingCalendarController@getAnalysticData')->name('location.get_data');
        Route::get('location/{id}/detail/{date}', 'SittingCalendarController@detailLocation')->name('location.detail_location');
    });
});

Auth::routes();

Route::group(['middleware' => 'checkLogin'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/logout', 'HomeController@logout');
    Route::resource('user', 'UserController')->middleware('checkUser');
    Route::get('/workschedule-register', 'WorkScheduleController@index');
    Route::post('/registerworkschedule', 'WorkScheduleController@registerWork')->name('workschedule');
    Route::get('/workschedule', 'WorkScheduleController@index');
    Route::get('schedule/users/{id}', 'Admin\WorkingScheduleController@viewByUser')->name('user.schedule');
    Route::get('schedule/users/{id}/get', 'Admin\WorkingScheduleController@getDataUser');
    Route::get('/register/trainer/{programId}', 'UserController@selectTrainer');
    Route::post('/get-seat', 'WorkScheduleController@getSeat');
    Route::post('/get-seat-by-day', 'WorkScheduleController@getSeatByDay');
});
Route::get('/register', 'UserController@index');
Route::post('/register', 'UserController@store');
Route::get('/register/trainer', 'UserController@selectTrainer')->name('get_trainer_by_program');

Route::group(['prefix' => 'workspace'], function () {
    Route::get('create', 'Admin\DiagramController@typeWorkspaceInformation')->name('create_workspace');
    Route::post('save', 'Admin\DiagramController@saveWorkspace')->name('test.save');
    Route::get('edit-locations/{id}', 'Admin\DiagramController@generateDiagram')->name('generate');
    Route::post('add-locations/{id}', 'Admin\DiagramController@saveLocation')->name('save_location');
    Route::get('list', 'Admin\DiagramController@list')->name('list_workspace');
    Route::get('detail/{id}', 'Admin\DiagramController@detail')->name('detail_workspace');
    Route::post('save-ajax', 'Admin\DiagramController@saveAjaxLocation')->name('save_location_color');
    Route::post('save-info-location', 'Admin\DiagramController@saveInfoLocation')->name('save_info_location');
});
