<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;

class ProfileController extends Controller
{
    function index() {
        //
    }

    function update(Request $request) {
        $data = $request->all();
        if( $data['change-password'] == "" ) {
            Users::where('email', $data['pro-email'])->update([
                'name' => $data['pro-name'],
                'phone' => $data['pro-phone']
            ]);
        } else {
            Users::where('email', $data['pro-email'])->update([
                'name' => $data['pro-name'],
                'phone' => $data['pro-phone'],
                'password' => $data['change-password']
            ]);
        }
        return redirect('logout');
    }
}
