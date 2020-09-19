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

Auth::routes();

 Route::group(['middleware' => 'auth'], function() {
	Route::get('/', function () {
	    return view('welcome');
	});
	Route::resource('posts','PostsController');
	Route::post('posts/search-data', array('as' => 'search_data', 'uses' => 'PostsController@searchData'));
	Route::post('posts/changeStatus', array('as' => 'changeStatus', 'uses' => 'PostsController@changeStatus'));
});

Route::get('/home', 'HomeController@index');
