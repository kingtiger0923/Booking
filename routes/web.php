<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Middleware\CheckLogin;

// Route::get('/', function () {
//     if( session()->exists('logged_in') && session('logged_in') ) {
//       return redirect('/home');
//     }
//     return view('welcome');
// });

Route::get('/', function() {
    return view('index');
});

Route::namespace('auth')->prefix('auth')->group(function() {
  Route::post('login', 'LoginController@checkUser');
});

Route::group(['middleware' => CheckLogin::class], function () {
  Route::get('/home'     , 'MainController@toHome');
  Route::get('/customers', 'MainController@toCustomers');
  Route::get('/vehicles' , 'MainController@toVehicle');
  Route::get('/profile'  , 'MainController@toProfile');
  Route::get('/settings' , 'MainController@toSettings');
  Route::get('/logout'   , 'auth\LoginController@Logout');

  Route::get('/addcustomer', 'CustomerController@index');
  Route::post('/customer-add', 'CustomerController@add');
  Route::post('/delete-customer', 'CustomerController@delete');
  Route::get ('/edit-customer/{slug}', 'CustomerController@edit');

  Route::get('/addvehicle', 'VehicleController@index');
  Route::post('/vehicle-add', 'VehicleController@add');
  Route::post('/delete-vehicle', 'VehicleController@delete');
  Route::get ('/edit-vehicle/{slug}', 'VehicleController@edit');

  Route::post('update-profile', 'ProfileController@update');

  Route::post('/confirm-step1', 'BookingController@confirm_step1');
});
