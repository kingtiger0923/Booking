<?php

namespace App\Http\Controllers;

use App\Mail\sendmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Customers;
use App\Vehicles;


class BookingController extends Controller
{
    function confirm_step1(Request $request)
    {
        $data = $request->all();
        //$dis = $this->getDistance($data['src-address'], $data['dst-address']);
        $data['distance'] = "11.54";
        error_log(json_encode($data));
        //Mail::to("iguaranteework@gmail.com")->send(new sendmail());
        $customer = Customers::where('id', $data['customer-name'])->first();
        $date = $data['date'].', '.$data['hour'].':'.$data['minute'].' '.$data['time-t'];

        // Calc Price
        $Calc_Price = 0;
        $vehicle = Vehicles::where('id', $data['vehicle'])->first();
        if( $data['ride'] == "Hourly" ) {
            $Calc_Price = $vehicle->Price_base + $vehicle->Price_hour * ($data['duration'] - 2);
        } else {
            $Calc_Price = $vehicle->Price_base + $vehicle->Price_mile * ($data['distance'] - $vehicle->Miles_included);
        }

        return view('booking-step1', compact('data', 'customer', 'date', 'Calc_Price'));
    }

    function DistanceRequest(Request $request)
    {
    }

    function getDistance($addressFrom, $addressTo, $unit = '') {
        // Google API key
        $apiKey = 'AIzaSyATQgdZ12KKj6Kty5bJS90dnB9BUNEYnYg';

        // Change address format
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        $formattedAddrTo     = str_replace(' ', '+', $addressTo);

        // Geocoding API request with start address
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }

        // Geocoding API request with end address
        $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
        $outputTo = json_decode($geocodeTo);
        if(!empty($outputTo->error_message)){
            return $outputTo->error_message;
        }

        // Get latitude and longitude from the geodata
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
        $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
        $longitudeTo    = $outputTo->results[0]->geometry->location->lng;

        // Calculate distance between latitude and longitude
        $theta    = $longitudeFrom - $longitudeTo;
        $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist    = acos($dist);
        $dist    = rad2deg($dist);
        $miles    = $dist * 60 * 1.1515;

        // Convert unit and return distance
        $unit = strtoupper($unit);
        if($unit == "K"){
            return round($miles * 1.609344, 2); //.' km'
        }elseif($unit == "M"){
            return round($miles * 1609.344, 2); //.' meters'
        }else{
            return round($miles, 2); //.' miles'
        }
    }
}
