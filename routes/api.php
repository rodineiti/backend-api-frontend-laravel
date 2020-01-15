<?php

use Illuminate\Http\Request;

/*
 * ####### GROUPO DE TODAS QUE NÃO PRECISAM DE AUTENTICAÇÃO
 */
Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {	
	Route::post('auth/register', 'Auth\RegisterController@register');
});

/*
 * ####### GROUPO DE TODAS QUE PRECISAM DE AUTENTICAÇÃO
 */
Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1', 'middleware' => ['auth:api']], function () {
	
	Route::get('profile', 'AuthController@profile');
	Route::get('logout', 'Auth\LoginController@logout');
  
  Route::put('profile/update', 'AuthController@profileUpdate');
	
	Route::get('categories', 'CategoryController@index');
	Route::get('categories/show/{id}', 'CategoryController@show');
	Route::post('categories/store', 'CategoryController@store');
	Route::put('categories/update/{id}', 'CategoryController@update');
	Route::delete('categories/destroy/{id}', 'CategoryController@destroy');

	Route::get('bill_pays', 'BillPayController@index');
	Route::get('bill_pays/show/{id}', 'BillPayController@show');
	Route::post('bill_pays/store', 'BillPayController@store');
	Route::put('bill_pays/update/{id}', 'BillPayController@update');
	Route::put('bill_pays/toggle/{id}', 'BillPayController@toggle');
	Route::delete('bill_pays/destroy/{id}', 'BillPayController@destroy');

	Route::get('bill_receives', 'BillReceiveController@index');
	Route::get('bill_receives/show/{id}', 'BillReceiveController@show');
	Route::post('bill_receives/store', 'BillReceiveController@store');
	Route::put('bill_receives/update/{id}', 'BillReceiveController@update');
	Route::put('bill_receives/toggle/{id}', 'BillReceiveController@toggle');
	Route::delete('bill_receives/destroy/{id}', 'BillReceiveController@destroy');
  
  Route::get('chartsfull', 'ReportController@sumChartsByPeriodFull');
	Route::post('charts', 'ReportController@sumChartsByPeriod');
	Route::post('statement', 'ReportController@getStatementByPeriod');
  
  Route::get('contents', 'ContentController@index');
	Route::get('contents/show/{id}', 'ContentController@show');
  Route::get('contents/page/list/{id}', 'ContentController@page');
  Route::get('contents/list/friends', 'ContentController@friends');
  Route::get('contents/list/friendspage/{id}', 'ContentController@friendspage');
  
	Route::post('contents/store', 'ContentController@store');
  Route::post('contents/user/friend', 'ContentController@friend');
  
	Route::put('contents/update/{id}', 'ContentController@update');  
  Route::put('contents/like/{id}', 'ContentController@like');
  Route::put('contents/like/page/{id}', 'ContentController@likePage');
  Route::put('contents/comment/{id}', 'ContentController@comment');
  Route::put('contents/comment/page/{id}', 'ContentController@commentPage');
  
	Route::delete('contents/destroy/{id}', 'ContentController@destroy');
});
