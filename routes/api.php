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

// Route::group(['prefix' => 'auth'], function () {
//     Route::post('login', 'AuthController@login')->name('login');
// });
Route::group([
    'middleware' => [
        'auth'
    ],
    'as' => 'api.',
], function () {
//     Route::post('signup', 'AuthController@signup');
//     Route::get('logout', 'AuthController@logout');
//     Route::get('current-user', 'AuthController@currentUser');
//     Route::patch('update-role-user/{id}', 'UserController@updateRole');
//     Route::get('/profile', 'UserController@profile');
//     Route::patch('/profile', 'UserController@update');
//     Route::post('/profile/avatar', 'UserController@updateAvatar');
//     Route::patch('/password', 'UserController@password');
    Route::resource('/workspaces', 'Api\WorkspaceApi');
//     Route::resource('/teams', 'TeamController');
//     Route::resource('/types', 'TypeController');
    Route::resource('/batches', 'Api\BatchApi');
    Route::resource('/subjects', 'Api\SubjectApi');
    Route::resource('/reviews', 'Api\ReviewApi');
    Route::put('/reviews', 'ReviewController@update');
    Route::resource('/reports', 'ReportController');
    Route::get('/reports/batch/{id}', 'ReportController@getReportsGroupBySubject');
    Route::get('/reports/trainee/{id}', 'ReportController@getReportsByTrainee');
    Route::get('/reports/by/{subject_id}/', 'ReportController@getReportsBySubject');
    Route::resource('/trainees', 'Api\TraineeApi');
    Route::get('/trainees/batch/{id}', 'Api\TraineeApi@getTraineeByBatch');
//     Route::resource('/schedules', 'ScheduleController');
//     Route::get('/schedules/user/{id}', 'ScheduleController@getUserSchedule');
//     Route::get('/schedules/user/{id}/byweek', 'ScheduleController@getUserScheduleByWeek');
//     Route::get('/schedules/batch/{id}', 'ScheduleController@getBatchSchedule');
//     Route::put('/schedules', 'ScheduleController@update');
//     Route::resource('/roles', 'RoleController');
//     Route::resource('users', 'UserController');
    Route::get('design_diagram/{id}', 'Api\DesignDiagramApi@getDesignWithoutDiagram')
        ->name('get_design_without_diagram');
});
