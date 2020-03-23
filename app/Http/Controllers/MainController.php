<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicles;
use App\Customers;
use App\Settings;
use App\Users;

class MainController extends Controller
{
  function index() {
    //
  }

  function toHome() {
    $vehicles = Vehicles::all();
    $customers = Customers::all();
    return view('booking-create', compact('vehicles', 'customers'));
  }

  function toVehicle() {
    $vehicles = Vehicles::all();
    return view('vehicle-browse', compact('vehicles'));
  }

  function toCustomers() {
    $customers = Customers::all();
    return view('customer-browse', compact('customers'));
  }

  function toProfile() {
    if( session()->exists('logged_in') ) {
        $profile = Users::where('email', session('email'));
        return view('profile-browse', compact('profile'));
    }
  }

  function toSettings() {
    $settings = Settings::all();
    return view('settings-browse', compact('settings'));
  }
}
