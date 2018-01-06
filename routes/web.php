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

Auth::routes();

//NORMAL USER SIDE
Route::get('/home', 'HomeController@index')->name('home');


//ADMIN USERS
Route::middleware('auth')->prefix('admin')->group(function () {
	//Link for your admin homepage
	Route::get('/home', 'HomeController@index');
	
	Route::resource('/users', 'UsersController');
	Route::get('/get-users', 'UsersController@all');

	Route::resource('/suppliers', 'SuppliersController');
	Route::get('/get-suppliers', 'SuppliersController@all');

	Route::resource('/services', 'ServicesController');
	Route::get('/get-services', 'ServicesController@all');

	Route::resource('/packages', 'PackagesController');
	Route::get('/get-packages', 'PackagesController@all');
});