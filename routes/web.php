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

Route::get('/', 'LoginController@index')->name('home');
Route::post('/checklogin', 'LoginController@checklogin')->name('login');
Route::get('/taskmanagement', 'TaskManagementController@display')->name('taskmanagement');
Route::get('/holidaymanagement', 'HolidayManagementController@display')->name('holidaymanagement');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::get('/forgotpassword','ForgotPasswordController@reset');
Route::get('/changepassword','LoginController@ChangePass')->name('changepassword');
Route::post('/changepassword/change','LoginController@ActionChange')->name('ActionChange');
Route::post('/holidaymanagement/addholiday','HolidayManagementController@AddHoliday')->name('addHolidays');
Route::post('holidaymanagement/confirmHoliday','HolidayManagementController@ConfirmHoliday')->name('ConfirmHoliday');
Route::get('/dashboard/test', 'DashboardController@test')->name('test');
Route::post('/taskmanagement/addTask','TaskManagementController@AddTask')->name('AddTask');
Route::post('/taskmanagement/assignTask','TaskManagementController@AssignTask')->name('AssignTask');
Route::get('/membermanagement','MemberManagementController@display')->name('membermanagement');
Route::post('/taskmanagement/closetask','TaskManagementController@CloseTask')->name('closetask');
Route::post('/taskmanagement/search','TaskManagementController@Search')->name('search');
Route::post('/taskmanagement/uploadassign','TaskManagementController@Upload')->name('upload');
Route::get('/projectadmin','AdminController@display')->name('admin');
Route::post('/projectadmin/AddProject','AdminController@AddProject')->name('AddProject');
Route::post('/projectadmin/deleteProject','AdminController@DeleteProject')->name('DeleteProject');
Route::get('/memberadmin','AdminController@DisplayMember')->name('DisplayMember');
Route::post('/memberadmin/addmember','AdminController@AddMember')->name('AddMember');
Route::post('/memberadmin/deletemember','AdminController@DeleteMember')->name('DeleteMember');
Route::post('/memberadmin/export','AdminController@Export')->name('Export');
Route::post('/projectadmin/memberlist','AdminController@ListMember')->name('ListMember');
Route::post('/projectadmin/ass','AdminController@MemberAssign')->name('MemberAssign');
Route::get('/projectmanagement','TaskManagementController@ProjectReport')->name('ProjectReport');
