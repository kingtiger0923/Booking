<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;

class CustomerController extends Controller
{
    function index() {
        return view('add-customer');
    }

    function add(Request $request)
    {
        $data = $request->all();
        $firstname = $data['firstname'];
        $lastname  = $data['lastname'];
        $email     = $data['email'];
        $phone     = $data['phonenumber'];
        $home      = $data['homeaddress'];
        $office    = $data['officeaddress'];

        $One = Customers::where('email', $email)->first();
        if( $One === null ) {
            $customer = new Customers;
            $customer->firstname = $firstname;
            $customer->lastname  = $lastname;
            $customer->email     = $email;
            $customer->phone     = $phone;
            $customer->home_address = $home == "" ? "Not Specified" : $home;
            $customer->office_address = $office == "" ? "Not Specified" : $office;
            $customer->save();
        } else {
            Customers::where('email', $email)
                ->update([
                    'firstname'      => $firstname,
                    'lastname'       => $lastname,
                    'phone'          => $phone,
                    'home_address'   => $home,
                    'office_address' => $office
                    ]);
        }
        return redirect('/customers');
    }

    function delete(Request $request) {
        $data = $request->all();
        Customers::where('id', $data['id'])->delete();
        return "Success";
    }

    function edit($id) {
        $customer = Customers::where('id', $id)->first();
        return view('add-customer', compact('customer'));
    }
}
