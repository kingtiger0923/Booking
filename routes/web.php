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
use Illuminate\Support\Facades\DB;
use App\Users;

Route::get('/', function () {
    $history = DB::table('sessions')->where('ip_address', '=', request()->ip())->get();
    if(count($history)) {
        $user = Users::where('id', $history[0]->user_id)->first();
        session(['email' => $user->email, 'logged_in' => true, 'username' => $user->name]);
        return redirect('/home');
    }
    if( session()->exists('logged_in') && session('logged_in') ) {
      return redirect('/home');
    }
    return view('welcome');
});

// Route::get('/', function() {
//     return view('mail.touser');
// });

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
  Route::post('/confirm-booking-step1', 'BookingController@confirm_booking_step1');

  Route::post('/save_setting', 'MainController@save_Setting');

  Route::post('/changeLogo', 'MainController@changeLogo');
});

Route::post('setTimezone', 'MainController@setTimezone');

Route::get('oauth', ['as' => 'oauthCallback', 'uses' => 'BookingController@oauth']);
Route::resource('calendar', 'BookingController');
Route::get('insertData', 'BookingController@InsertEventToCalendar');
