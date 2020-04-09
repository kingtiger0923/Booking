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
    $vehicles = Vehicles::orderBy('used', 'desc')->get();
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
        $profile = Users::where('email', session('email'))->first();
        return view('profile-browse', compact('profile'));
    }
  }

  function toSettings() {
    $settings = Settings::where('id', '1')->first();
    return view('settings-browse', compact('settings'));
  }

  function save_Setting(Request $request) {
      $data = $request->all();
      Settings::where('id', '1')->update([
          'SMTP_host' => $data['smtphost'],
          'email_address' => $data['email_addr'],
          'SMTP_username' => $data['smtp_user'],
          'SMTP_password' => $data['smtp_pass']
      ]);
      return "Success";
  }
}
