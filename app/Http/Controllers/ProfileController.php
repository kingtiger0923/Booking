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
        error_log(json_encode($data));
        Users::where('email', $data['pro-email'])->update([
            'name' => $data['pro-name'],
            'phone' => $data['pro-phone'],
            'password' => $data['change-password']
        ]);
        return redirect('logout');
    }
}
