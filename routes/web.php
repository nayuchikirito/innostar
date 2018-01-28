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

	Route::get('/report/test', 'ReportsController@index');
	Route::get('/report/printpdf', 'ReportsController@printPdf');

	Route::get('/report/service/yearly', 'ReportsController@yearly_service');
	Route::get('/report/service/monthly', 'ReportsController@monthly_service');
	Route::get('/report/service/overall', 'ReportsController@overall');

	Route::get('/report/package/monthly', 'ReportsController@monthly_package');
	Route::get('/report/package/yearly', 'ReportsController@yearly_package');
	Route::get('/report/package/overall', 'ReportsController@overall_package');

	Route::get('/report/reservation/monthly', 'ReportsController@monthly_reservation');
	Route::get('/report/reservation/yearly', 'ReportsController@yearly_reservation');
	Route::get('/report/reservation/overall', 'ReportsController@overall_reservation');

	Route::get('/report/user', 'ReportsController@user');

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
 	Route::get('/reservations/{reservation}/assign-suppliers', 'ReservationsController@assignSuppliers')->name('reservations.assign-suppliers');
  	Route::post('/reservations/assign-suppliers', 'AssignSuppliersController@assign');

	Route::resource('/coordinations', 'CoordinationsController');
	Route::get('/get-coordinations', 'CoordinationsController@all');

	Route::resource('/payments', 'PaymentsController');
	Route::get('/payments_walkin/{res_id}', 'PaymentsController@pay')->name('admin.payments');
	Route::get('/get-payments', 'PaymentsController@all');

	Route::resource('/clients', 'ClientsController');
	// Route::get('/choose_reservation', 'ClientsController@choose')->name('clients.choose');
	Route::get('/clients/{client}/reserve', 'ClientsController@reserve')->name('clients.reserve');
	Route::get('/get-clients', 'ClientsController@all');
});

Route::middleware('client')->prefix('client')->group(function () {
	Route::resource('/reservations', 'GuestController');
	Route::resource('/register', 'RegisterClientController');
	Route::get('/pay', 'GuestController@pay')->name('clients.pay');
	Route::get('/clients/reservations', 'GuestController@reservations')->name('clients.reservations');
	Route::get('/get-reservations', 'GuestController@all');
	Route::get('/home', 'GuestController@index')->name('clients.home');
	Route::get('/payments_bank/{res_id}', 'GuestController@pay')->name('admin.payments');
	Route::post('/payments', 'GuestController@payment');

});

Route::get('select_service/{data}', 'SelectionController@selectService')->name('select-service');
Route::get('select_package/{data}', 'SelectionController@selectPackage')->name('select-package');
Route::get('select_balance/{data}', 'SelectionController@selectBalance')->name('select-balance');

Route::middleware('admin')->prefix('gallery')->group(function () {
	Route::get('/', array('as' => 'index','uses' => 'AlbumsController@getList'));
	Route::get('/createalbum', array('as' => 'create_album_form','uses' => 'AlbumsController@getForm'));
	Route::post('/createalbum', array('as' => 'create_album','uses' => 'AlbumsController@postCreate'));
	Route::get('/deletealbum/{id}', array('as' => 'delete_album','uses' => 'AlbumsController@getDelete'));
	Route::get('/album/{id}', array('as' => 'show_album','uses' => 'AlbumsController@getAlbum'));

	Route::get('/addimage/{id}', array('as' => 'add_image','uses' => 'ImageController@getForm'));
	Route::post('/addimage', array('as' => 'add_image_to_album','uses' => 'ImageController@postAdd'));
	Route::get('/deleteimage/{id}', array('as' => 'delete_image','uses' => 'ImageController@getDelete'));

	Route::post('/moveimage', array('as' => 'move_image', 'uses' => 'ImageController@postMove'));
});

Route::middleware('admin')->prefix('reports')->group(function () {
	Route::get('/registrations', 'GenerateReportController@registration')->name('generate.registration');
	Route::get('/registrations/pdf', 'GenerateReportController@reportRegistrations')->name('pdf.registrations');

	Route::get('/services', 'GenerateReportController@services')->name('generate.services');
	Route::get('/services/pdf', 'GenerateReportController@reportServices')->name('pdf.services');

	Route::get('/packages', 'GenerateReportController@packages')->name('generate.packages');
	Route::get('/packages/pdf', 'GenerateReportController@reportPackages')->name('pdf.packages');
});

Route::prefix('supplier')->group(function(){
	Route::get('/home', 'SuppliersController@index')->name('suppliers.home');
});

Route::prefix('secretary')->group(function(){
	Route::get('/home', 'SecretaryController@index')->name('secretary.home');
});