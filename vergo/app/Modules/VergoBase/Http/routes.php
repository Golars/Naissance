<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(['prefix' => '/'], function() {
	Route::get('/vergo', function() {
		return view('vergo_base::info', ['module'=>'Base Module']);
	});
	Route::group(['prefix' => 'auth'], function() {
		Route::any('/signup','UserController@signup');
		Route::any('/login','UserController@login');
	});
	Route::group(['prefix' => 'vadmin', 'middleware' => ['webAdmin']], function() {
		$asPrefix = 'admin';
		Route::group(['middleware' => 'AdminAuth'], function() use ($asPrefix) {
			Route::any('login', ['as' => $asPrefix .':login',  'uses' => 'Admin\UserController@login']);
			Route::get('logout', ['as' => $asPrefix .':logout',  'uses' => 'Admin\UserController@logout']);
		});
		Route::group(['middleware' => 'AdminAuthenticate'], function() use ($asPrefix) {
			Route::get('/', ['as' => $asPrefix .':index',  'uses' => 'Admin\Controller@index']);
			Route::get('/modules', ['as' => $asPrefix .':modules',  'uses' => 'Admin\ModuleController@index']);
		});
	});
});