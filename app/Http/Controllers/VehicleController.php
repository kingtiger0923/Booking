<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicles;

class VehicleController extends Controller
{
    function index() {
        return view('add-vehicle');
    }

    function add(Request $request)
    {
        $data = $request->all();
        $id        = $data['id'];
        $typemake  = $data['typemake'];
        $typemodel = $data['typemodel'];
        $license   = $data['license'];
        $price_hour= $data['price_hour'];
        $price_mile= $data['price_mile'];
        $price_base= $data['price_base'];
        $mile_included = $data['miles_included'];

        $One = Vehicles::where('id', $id)->first();
        if( $One === null ) {
            $vehicle = new Vehicles;
            $vehicle->Type_make        = $typemake;
            $vehicle->Type_model       = $typemodel;
            $vehicle->License_plate    = $license;
            $vehicle->Price_hour       = $price_hour;
            $vehicle->Price_mile       = $price_mile;
            $vehicle->Price_base       = $price_base;
            $vehicle->Miles_included   = $mile_included;
            $vehicle->save();
        } else {
            Vehicles::where('id', $id)
                ->update([
                    'Type_make'         => $typemake,
                    'Type_model'        => $typemodel,
                    'License_plate'     => $license,
                    'Price_hour'        => $price_hour,
                    'Price_mile'        => $price_mile,
                    'Price_base'        => $price_base,
                    'Miles_included'    => $mile_included
                    ]);
        }
        return redirect('/vehicles');
    }

    function delete(Request $request) {
        $data = $request->all();
        Vehicles::where('id', $data['id'])->delete();
        return "Success";
    }

    function edit($id) {
        $vehicle = Vehicles::where('id', $id)->first();
        return view('add-vehicle', compact('vehicle', 'id'));
    }
}
