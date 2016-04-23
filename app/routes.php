<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/*
 * load view
 */

Route::get('/hello', function()
{
	return View::make('hello');
});

Route::get('/', 'HomeController@showWelcome');
Route::get('administrator/','AdministratorController@index');

/*
 * To route to a controller
 */
Route::get('/write', 'HomeController@writeThis');

/*
 * To route to a controller and pass a variable to it
 */

Route::get('/administrator/{data}', array('uses' => 'AdministratorController@getVars'));

/*
 * To pass multiple variables
 */
Route::get('vars/{param1}&{param2}', function($param1,$param2){
    return "My name is $param1 $param2";
});

Route::get('/template' ,function(){
    return View::make('template');
});
Route::get('/createtable' ,'AdministratorController@CreateTable');
Route::get('/updatetable' ,'AdministratorController@UpdateTable');
Route::get('createuser' ,'AdministratorController@CreateUser');
Route::post('/administrator/signup' ,'AdministratorController@SignUp');
Route::get('browse' ,'AdministratorController@BrowseAll');
Route::get('administrator/deleteuser/{id}' ,'AdministratorController@DeleteUser');
Route::get('signup' ,function() {
    return View::make('signup');
});


/**
 * this section is all new for presidential car
 *
 */
//-------------------ADMIN---------------------//
Route::get('/',                     'AdminController@index');
Route::get('',                      'AdminController@index');
Route::get('/admin',                'AdminController@index');
Route::get('/admin/dashboard',      'AdminController@viewDashboard');
Route::get('/signup',               'AdminController@signUp');

Route::get('/admin/viewdrivers',    'AdminController@viewDrivers');
Route::get('/admin/viewclients',    'AdminController@viewClients');
Route::get('/admin/logout',         'AdminController@logout');
Route::get('/admin/viewtrips',      'AdminController@viewTrips');
Route::get('/admin/newtrips',       'AdminController@newTrips');
Route::get('/admin/viewcars',       'AdminController@viewCars');
Route::get('/admin/cardetails/{id}','AdminController@carDetails');
Route::get('/admin/driverdetails/{id}','AdminController@driverDetails');
Route::get('/admin/viewpayments',   'AdminController@viewPayments');

Route::post('/admin/login',         'AdminController@login');
Route::post('/admin/gettrips',      'AdminController@getTrips');
Route::post('/admin/gettripsbydriver',  'AdminController@getTripsByDriver');
Route::post('/admin/geteditedtripbyid',  'AdminController@getEditedTripById');
Route::post('/admin/saveeditedtrip',  'AdminController@saveEditedTrip');
Route::post('/admin/getdrivers',    'AdminController@getDrivers');
Route::post('/admin/getclients',    'AdminController@getClients');
Route::post('/admin/newtrip',       'AdminController@newDailyTrip');
Route::post('/admin/deletetrip', 'AdminController@deleteTrip');
Route::post('/admin/newuser',       'AdminController@createNewUser');
Route::post('/admin/getcars',       'AdminController@getCars');
Route::post('/admin/getpayments',       'AdminController@getPayments');
Route::post('/admin/createreport',      'AdminController@createReport');

Route::post('/admin/getdriverbyid', 'AdminController@getDriverById');
Route::post('/admin/savedriver',    'AdminController@saveDriver');
Route::post('/admin/savenewdriver', 'AdminController@saveNewDriver');
Route::post('/admin/deletedriver',  'AdminController@deleteDriver');

Route::post('/admin/getclientbyid', 'AdminController@getClientById');
Route::post('/admin/saveclient',    'AdminController@saveClient');
Route::post('/admin/savenewclient',    'AdminController@saveNewClient');
Route::post('/admin/deleteclient',  'AdminController@deleteClient');


Route::post('/admin/getcarbyid', 'AdminController@getCarById');
Route::post('/admin/savecar',    'AdminController@saveCar');
Route::post('/admin/savenewcar',    'AdminController@saveNewCar');
Route::post('/admin/deletecar', 'AdminController@deleteCar');

Route::post('/admin/savepayment',    'AdminController@savePayment');
//-------------------DRIVER---------------------//

Route::get('/driver/newtrip' ,'DriverController@newTrip');
Route::get('/driver/logout' ,'DriverController@logout');
Route::get('/driver/mytrips', 'DriverController@myTrips');
Route::get('/driver/myfueltank', 'DriverController@myFuelTank');
Route::get('/driver/showemailform', 'DriverController@showEmailForm');

Route::post('/driver/getlocation' ,'LocationController@getLocation');
Route::post('/driver/gettime' ,'LocationController@getTime');
Route::post('/driver/savenewtrip' ,'DriverController@saveNewTrip');
Route::post('/driver/savenewtemptrip' ,'DriverController@saveNewTempTrip');
Route::post('/driver/getavailablecars' ,'DriverController@getAvailableCars');
Route::post('/driver/replacecar', 'DriverController@replaceCar');
Route::post('/driver/gettrip', 'DriverController@getTripById');
Route::post('/driver/requestdeletion', 'DriverController@requestDeletion');
Route::post('/driver/requestrevision', 'DriverController@requestRevision');
Route::post('/driver/showmytrips', 'DriverController@showMyTrips');
Route::post('/driver/savefuelfillup', 'DriverController@saveFuelFillUp');
Route::post('/driver/sendemail' ,'DriverController@sendEmail');