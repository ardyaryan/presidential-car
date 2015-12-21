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
Route::get('/' ,'AdminController@index');
Route::get('/admin' ,'AdminController@index');
Route::get('/admin/dashboard' ,'AdminController@viewDashboard');

Route::post('/admin/login' ,'AdminController@login');
Route::get('/admin/logout' ,'AdminController@logout');
Route::get('/admin/viewtrips' ,'AdminController@viewTrips');
Route::get('/admin/newtrips' ,'AdminController@newTrips');
Route::post('/admin/gettrips' ,'AdminController@getTrips');

Route::get('/admin/viewdrivers' ,'AdminController@viewDrivers');
Route::post('/admin/getdrivers' ,'AdminController@getDrivers');

Route::get('/signup' ,'AdminController@signUp');
Route::post('/admin/newtrip' ,'AdminController@newDailyTrip');
Route::post('/admin/newuser' ,'AdminController@createNewUser');

//-------------------DRIVER---------------------//

Route::get('/driver/newtrip' ,'DriverController@newTrip');
Route::get('/driver/logout' ,'DriverController@logout');
Route::get('/driver/location' ,'DriverController@getLocation');
Route::post('/driver/getlocation' ,'LocationController@getLocation');
