<?php

namespace App\Http\Controllers;

use App\Mail\sendmail;
use App\Mail\sendToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Customers;
use App\Vehicles;
use App\Settings;
use App\Exceptions;
use DateTime;
use Exception;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class BookingController extends Controller
{
    protected $client;

    function confirm_step1(Request $request)
    {
        $data = $request->all();
        try{
            $dis = $this->getDistance($data['src-address'], $data['dst-address']);
            $data['distance'] = $dis;
        } catch(Exception $e) {
            $data['distance'] = 0;
        }
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

    function confirm_booking_step1(Request $request) {
        $data = $request->all();

        error_log(json_encode($data));
        $mail = Settings::where('id', '1')->first();

        $sendOkay = true;
        try {
            if( $data['sendemail'] == "on" ) {
                Mail::to($data['customer-email'])->send(new sendmail($data));
            }
            $vehicle = Vehicles::where('id', $data['vehicle'])->first();

            Mail::to(session('email'))->send(new sendToUser($data, $vehicle));
        } catch(Exception $e) {
            $sendOkay = false;
        }
        if( Mail::failures() ) {
            $sendOkay = false;
        }

        // Insert Into Google Calendar
        $event = $this->InsertEventToCalendar($data);
        if( $event == "Need Auth" ) {
            session(['data' => $data, 'sendOkay' => $sendOkay]);
            return redirect()->route('oauthCallback');
        }
        // End of Inserting To Google Calendar

        return view('booking-confirmation', compact('data', 'sendOkay', 'event'));
    }

    function DistanceRequest(Request $request)
    {
    }

    function __construct()
    {
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__.'/../../../public/client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);

        // $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
        // $client->setHttpClient($guzzleClient);
        $this->client = $client;
    }

    public function oauth()
    {
        if(!isset($_SESSION)) {
            session_start();
        }

        $rurl = action('BookingController@oauth');
        $this->client->setRedirectUri($rurl);
        if (!isset($_GET['code'])) {
            $auth_url = $this->client->createAuthUrl();
            $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
            return redirect($filtered_url);
        } else {
            $this->client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->client->getAccessToken();

            $data = session('data');
            $sendOkay = session('sendOkay');
            $event = $this->InsertEventToCalendar($data);
            error_log(json_encode($data));
            return view('booking-confirmation', compact('data', 'sendOkay', 'event'));
        }
    }

    function InsertEventToCalendar($data) {

        if(!isset($_SESSION)) {
            session_start();
        }
        error_log(json_encode($data));
        if( isset($_SESSION['access_token']) && $_SESSION['access_token'] ) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);

            $description = "Event Description".PHP_EOL;
            $description .= "Customer-Name  : ".$data['customer'].PHP_EOL;
            $description .= "Customer-Email : ".$data['customer-email'].PHP_EOL;
            $description .= "From : ".$data['src-address'].PHP_EOL;
            $description .= "   To  : ".$data['dst-address'].PHP_EOL;
            $description .= "Date : ".$data['date'].PHP_EOL;
            $description .= "Passenger (".$data['passenger-count'].")".PHP_EOL;
            $description .= "  - Name  : ".$data['passenger-name'].PHP_EOL;
            $description .= "  - Phone : ".$data['passenger-phone'].PHP_EOL;
            $description .= "Price : $";
            if( $data['price_t'] == 'Calc' ) {
                $description .= $data['calc_price'].PHP_EOL;
            } else {
                $description .= $data['manu_price'].PHP_EOL;
            }
            $dateArr = array_filter(explode(',', $data['date']), 'strlen');
            $dateString = "";
            if( count($dateArr) == 2 ) {
                $dateString .= $dateArr[0];
                $dateString .= "T";
                $split = array_filter(explode(' ', $dateArr[1]), 'strlen');
                if( $split['2'] == 'am' ) {
                    $split1 = array_filter(explode(':', $split['1']), 'strlen');
                    $dateString .= ($split1[0] + 12);
                    $dateString .= ':';
                    $dateString .= $split1[1];
                    $dateString .= ':00';
                } else {
                    $split1 = array_filter(explode(':', $split['1']), 'strlen');
                    $dateString .= $split1[0];
                    $dateString .= ':';
                    $dateString .= $split1[1];
                    $dateString .= ':00';
                }
            } else {
                $Month = ltrim($dateArr[1]);
                $monthstr = [
                    'January' => '01',
                    'February' => '02',
                    'March' => '03',
                    'April' => '04',
                    'May' => '05',
                    'June' => '06',
                    'July' => '07',
                    'August' => '08',
                    'September' => '09',
                    'October' => '10',
                    'November' => '11',
                    'December' => '12'
                ];
                $dateString .= ltrim($dateArr[3]);
                $dateString .= '-';
                $dateString .= $monthstr[$Month];
                $dateString .= '-';
                $dateString .= ltrim($dateArr[2]);
                $dateString .= 'T';
                $split = array_filter(explode(' ', $dateArr[4]), 'strlen');
                if( $split['2'] == 'am' ) {
                    $split1 = array_filter(explode(':', $split['1']), 'strlen');
                    $dateString .= ($split1[0] + 12);
                    $dateString .= ':';
                    $dateString .= $split1[1];
                    $dateString .= ':00';
                } else {
                    $split1 = array_filter(explode(':', $split['1']), 'strlen');
                    $dateString .= $split1[0];
                    $dateString .= ':';
                    $dateString .= $split1[1];
                    $dateString .= ':00';
                }
            }
            $event = new Google_Service_Calendar_Event(array(
                'summary' => 'New Booking',
                'description' => $description,
                'start' => array(
                    'dateTime' => $dateString,
                    'timeZone' => 'America/New_York',
                ),
                'end' => array(
                    'dateTime' => $dateString,
                    'timeZone' => 'America/New_York',
                ),
                'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 10),
                    ),
                ),
            ));
            $calendarId = 'primary';
            return $event = $service->events->insert($calendarId, $event);
        } else {
            return "Need Auth";
        }
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
