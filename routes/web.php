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
	//dd(bcrypt('secretadmin'));
    return redirect()->route('login');
});

Route::get('/confirmation/{token}', 'Auth\RegisterController@confirmation')->name('confirmation');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/charts', 'ReportController@charts')->name('charts');
Route::get('/statement', 'ReportController@statement')->name('statement');

Route::post('/charts', 'ReportController@sumChartsByPeriod')->name('post.charts');
Route::post('/statement', 'ReportController@getStatementByPeriod')->name('post.statement');

Route::resource('categories', 'CategoryController', ['except' => ['show']]);
Route::resource('bill_receives', 'BillReceiveController', ['except' => ['show']]);
Route::resource('bill_pays', 'BillPayController', ['except' => ['show']]);

Route::resource('users', 'UsersController', ['except' => ['show']]);
Route::post('users/toggle', 'UsersController@toggle')->name('users.toggle');
