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

Route::get('/', function () {
    return view('welcome');
});


//routes employees
	Route::get('/employee', 'EmployeeController@index')->name('employee/index');
	Route::get('/api/v1/employee', ['name' => 'api.employee.list', 'uses' => 'EmployeeController@list']);
	Route::post('/api/v1/employee', ['name' => 'api.employee.store', 'uses' => 'EmployeeController@store']);
	Route::put('/api/v1/employee/{id}', ['name' => 'api.employee.update', 'uses' => 'EmployeeController@update']);
	Route::get('/api/v1/employee/show', ['name' => 'api.employee.show', 'uses' => 'EmployeeController@show']);
	Route::get('/api/v1/employee/getdata/{id}', ['name' => 'api.employee.getdata', 'uses' => 'EmployeeController@getdata']);
	Route::get('/api/v1/employee/delete', ['name' => 'api.employee.delete', 'uses' => 'EmployeeController@delete']);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
