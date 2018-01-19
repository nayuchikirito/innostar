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
Route::middleware('admin')->prefix('admin')->group(function () {
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

	Route::resource('/reservations', 'ReservationsController');
	Route::get('/get-reservations', 'ReservationsController@all');

	Route::resource('/coordinations', 'CoordinationsController');
	Route::get('/get-coordinations', 'CoordinationsController@all');

	Route::resource('/clients', 'ClientsController');
	// Route::get('/choose_reservation', 'ClientsController@choose')->name('clients.choose');
	Route::get('/clients/{client}/reserve', 'ClientsController@reserve')->name('clients.reserve');
	Route::get('/get-clients', 'ClientsController@all');
});

Route::middleware('client')->prefix('client')->group(function () {
	Route::resource('/reservations', 'GuestController');
	Route::get('/get-reservations', 'GuestController@all');
	Route::get('/home', 'ClientLoginController@index');	

});

Route::get('select_service/{data}', 'SelectionController@selectService')->name('select-service');
Route::get('select_package/{data}', 'SelectionController@selectPackage')->name('select-package'); 
Route::get('select_balance/{data}', 'SelectionController@selectBalance')->name('select-balance'); 