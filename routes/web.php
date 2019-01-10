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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['checkLogin']], function () {
    Route::get('/', 'DashboardController@index')->name('admin.index');

    Route::get('/roles/get-roles', 'RoleController@getRoles')->name('roles.get_roles');
    Route::post('/roles/update-permission-role', 'RoleController@updatePermissionRole')->name('roles.update_permission_role');
    Route::get('/roles/get-permission-role/{role_id}', 'RoleController@getPermissionRole')->name('roles.get_permission_role');
    Route::resource('roles', 'RoleController');

    Route::get('/permissions/get-permissions', 'PermissionController@getPermissions')->name('permissions.get_permissions');
    Route::resource('permissions', 'PermissionController');

    Route::post('/users/update-role-user', 'UserController@updateRoleUser')->name('users.update_role_user');
    Route::resource('users', 'UserController');
    // Route::get('register-users')->name('register.user');

    Route::get('/positions/get-positions', 'PositionController@getPositions')->name('positions.get_positions');
    Route::resource('positions', 'PositionController');

    Route::get('/programs/get-programs', 'ProgramController@getPrograms')->name('programs.get_programs');
    Route::resource('programs', 'ProgramController');

    Route::resource('workspaces', 'WorkspaceController');
    Route::resource('batches', 'BatchController');

    Route::resource('locations', 'LocationController');
    Route::put('locations/{id}/update-row-column', 'LocationController@updateRowColumn')
        ->name('locations.update_row_column');

    Route::resource('userdisables', 'UserDisableController');

    Route::group(['prefix' => 'schedule', 'as' => 'schedule.'], function () {
        Route::get('/', 'WorkingScheduleController@chooseWorkplace')->name('workplace.list');
        Route::get('/{id}', 'WorkingScheduleController@viewByWorkplace')->name('workplace.view');
        Route::get('/{id}/get', 'WorkingScheduleController@getData')->name('workplace.get_data');
        Route::get('/{id}/one', 'WorkingScheduleController@getOneDate')->name('workplace.get_one_date');
        Route::get('location/{id}', 'WorkingScheduleController@viewByLocation')->name('location.month');
        Route::get('users/{id}', 'WorkingScheduleController@viewByUser')->name('detail.location');
        Route::get('users/{id}/get', 'WorkingScheduleController@getDataUser');
        Route::get('/view-by-location/{id}', 'WorkingScheduleController@getScheduleByLocation')->name('by.location');
        Route::get('view-by-location/{id}/get-schedule', 'WorkingScheduleController@getScheduleData')->name('get.data');
    });

    Route::group(['prefix' => 'calendar', 'as' => 'calendar.'], function () {
        Route::get('/', 'SittingCalendarController@chooseWorkplace')->name('workplace.list');
        Route::get('/workplace/{id}', 'SittingCalendarController@locationList')->name('location.list');
        Route::get('location/{id}', 'SittingCalendarController@locationAnalystic')->name('location.view');
        Route::get('location/{id}/analystic', 'SittingCalendarController@getAnalysticData')->name('location.get_data');
        Route::get('location/{id}/detail/{date}', 'SittingCalendarController@detailLocation')->name('location.detail_location');
    });

    Route::post('active-user/{id}', 'ActiveUserController@activeUser');
});

Auth::routes();

Route::group(['middleware' => 'checkLogin'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/logout', 'HomeController@logout');
    Route::resource('user', 'UserController')->middleware('checkUser');
    Route::get('/workschedule-register', 'WorkScheduleController@index')->name('register.index');
    Route::post('/registerworkschedule', 'WorkScheduleController@registerWork')->name('workschedule');
    Route::get('/workschedule', 'WorkScheduleController@index');
    Route::get('schedule/users/{id}', 'Admin\WorkingScheduleController@viewByUser')->name('user.schedule');
    Route::get('schedule/users/{id}/get', 'Admin\WorkingScheduleController@getDataUser');
    Route::get('/register/trainer/{programId}', 'UserController@selectTrainer');
    Route::resource('seats', 'SeatController');
    Route::get('seats/available/{id}', 'SeatController@getAvailableSeats')->name('seats.available_seats');
    Route::get('show-diagram/{id}', 'Admin\DiagramController@showDiagram')->name('show_diagram');
});

Route::get('/register', 'UserController@index');
Route::post('/register', 'UserController@store');
Route::post('/getBatches', 'UserController@selectbatch');
Route::get('/register/trainer', 'UserController@selectTrainer')->name('get_trainer_by_program');

Route::group(['prefix' => 'workspace', 'middleware' => ['checkLogin']], function () {
    Route::get('generate/{id}', 'Admin\DiagramController@generateDiagram')->name('generate');
    Route::post('getColorLocation/{id}', 'Admin\DiagramController@getLocationColors');
    Route::post('add-locations/{id}', 'Admin\DiagramController@saveLocation')->name('save_location');
    Route::get('detail/{id}', 'Admin\DiagramController@detail')->name('detail_workspace');
    Route::post('save-ajax', 'Admin\DiagramController@saveAjaxLocation')->name('save_location_color');
    Route::post('save-info-location', 'Admin\DiagramController@saveInfoLocation')->name('save_info_location');
    Route::post('edit-info-location', 'Admin\DiagramController@editInfoLocation')->name('edit_info_location');
    Route::get('image-map/{id}', 'Admin\DiagramController@imageMap')->name('image_map');
    Route::post('save-design-diagram', 'Admin\DiagramController@saveDesignDiagram')->name('save_design_diagram');
    Route::get('list-diagram', 'Admin\DiagramController@listDiagram')->name('list_diagram');
    Route::get('diagram-detail/{id}', 'Admin\DiagramController@diagramDetail')->name('diagram_detail');
    Route::post('avatar-info/{id}', 'Admin\DiagramController@avatarInfo')->name('avatar_info');
    Route::get('avatar-info/{id}', 'Admin\DiagramController@avatarInfo')->name('avatar_info_1');
    Route::post('edit-info-user', 'Admin\DiagramController@editInfoUser')->name('edit_info_user');
    Route::post('edit-seat', 'Admin\DiagramController@editSeat')->name('edit_seat');
    Route::post('delete-seat', 'Admin\DiagramController@deleteSeat')->name('delete_seat');
    Route::get('design-without-diagram/{id}', 'Admin\DiagramController@showDesignWithoutDiagram')
        ->name('design_without_diagram');
    Route::post('design-without-diagram', 'Admin\DiagramController@saveDesignWithoutDiagram')
        ->name('save_design_without_diagram');
    Route::get('design-diagram-image/{id}', 'Admin\DiagramController@designDiagramImage')
        ->name('design_diagram_image');
    Route::get('user-report', 'ReportController@userShowReport')->name('report.user');
});

Route::get('test', 'ReportController@test');
