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
use Carbon\Carbon;
use DateTime;
use Exception;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
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
            $data['distance'] = "Error";
        }

        $customer = Customers::where('id', $data['customer-name'])->first();

        try{
            $dateobj = new DateTime($data['date']);
            $data['date'] = $dateobj->format('m-d-Y');
        } catch(Exception $e) {
        }

        $date = $data['date'].', '.$data['hour'].':'.$data['minute'].' '.$data['time-t'];

        // Calc Price
        $Calc_Price = 0;
        $vehicle = Vehicles::where('id', $data['vehicle'])->first();
        if( $data['ride'] == "Hourly" ) {
            $Calc_Price = $vehicle->Price_base + $vehicle->Price_hour * ($data['duration'] - 2);
            if( $Calc_Price < $vehicle->Price_base ) {
              $Calc_Price = $vehicle->Price_base;
            }
            $Calc_Price = round($Calc_Price, 2);
        } else {
            if( $data['distance'] === "Error" ) {
                $Calc_Price = "Can not get distance!";
            } else {
                $Calc_Price = $vehicle->Price_base + $vehicle->Price_mile * ($data['distance'] - $vehicle->Miles_included);
                if( $Calc_Price < $vehicle->Price_base ) {
                $Calc_Price = $vehicle->Price_base;
                }
                $Calc_Price = round($Calc_Price, 2);
            }
        }

        //Create Customer
        if ( $data['passenger-name'] != "" && $data['passenger-phone'] != "" ) {
            $customer1 = new Customers;
            $customer1->firstname = $data['passenger-name'];
            $customer1->lastname  = "";
            $customer1->email     = "Not Specified";
            $customer1->phone     = $data['passenger-phone'];
            $customer1->home_address = "Not Specified";
            $customer1->office_address = "Not Specified";
            $customer1->save();
        }

        return view('booking-step1', compact('data', 'customer', 'date', 'Calc_Price'));
    }

    function confirm_booking_step1(Request $request) {
        $data = $request->all();

        $mail = Settings::where('id', '1')->first();

        $sendOkay = true;
        try {
            if( $data['sendemail'] == "on" ) {
                //Mail::to($data['customer-email'])->send(new sendmail($data));
            }
            $vehicle = Vehicles::where('id', $data['vehicle'])->first();

            //Mail::to(session('email'))->send(new sendToUser($data, $vehicle));
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
        //$client->setAccessType("offline");

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

            return view('booking-confirmation', compact('data', 'sendOkay', 'event'));
        }
    }

    function InsertEventToCalendar($data) {

        if(!isset($_SESSION)) {
            session_start();
        }

        if( isset($_SESSION['access_token']) && $_SESSION['access_token'] ) {
            $this->client->setAccessToken($_SESSION['access_token']);
            if( $this->client->isAccessTokenExpired() ) {
                return "Need Auth";
            }
            try {
                $car = Vehicles::where('id', $data['vehicle'])->first();
                $service = new Google_Service_Calendar($this->client);

                $description = "Event Description".PHP_EOL;
                $description .= "Customer-Name  : ".$data['customer'].PHP_EOL;
                $description .= "Customer-Phone : ".$data['customer-phone'].PHP_EOL;
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

                $description .= "Vehicle : ".$car['Type_make'].' '.$car['Type_model'].' '.$car['License_plate'].PHP_EOL;
                $description .= "Comments:".PHP_EOL;
                $description .= $data['comments'];
                $dateArr = array_filter(explode(',', $data['date']), 'strlen');
                $dateString = "";
                if( count($dateArr) == 2 ) {
                    $spliteddate = array_filter(explode('-', $dateArr[0]), 'strlen');
                    $dateString .= $spliteddate[2];
                    $dateString .= "-";
                    $dateString .= $spliteddate[0];
                    $dateString .= "-";
                    $dateString .= $spliteddate[1];
                    $dateString .= "T";
                    $split = array_filter(explode(' ', $dateArr[1]), 'strlen');
                    if( $split['2'] == 'am' ) {
                        $split1 = array_filter(explode(':', $split['1']), 'strlen');
                        $dateString .= $split1[0];
                        $dateString .= ':';
                        $dateString .= $split1[1];
                        $dateString .= ':00';
                    } else {
                        $split1 = array_filter(explode(':', $split['1']), 'strlen');
                        $dateString .= ($split1[0] + 12);
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
                        $dateString .= $split1[0];
                        $dateString .= ':';
                        $dateString .= $split1[1];
                        $dateString .= ':00';
                    } else {
                        $split1 = array_filter(explode(':', $split['1']), 'strlen');
                        $dateString .= ($split1[0] + 12);
                        $dateString .= ':';
                        $dateString .= $split1[1];
                        $dateString .= ':00';
                    }
                }
                $timezone = "America/Chicago";
                if( session()->exists('timezone') )
                    $timezone = session('timezone');

                $event = new Google_Service_Calendar_Event(array(
                    'summary' => 'Booking with '.$data['customer'],
                    'description' => $description,
                    'start' => array(
                        'dateTime' => $dateString,
                        'timeZone' => $timezone,
                    ),
                    'end' => array(
                        'dateTime' => $dateString,
                        'timeZone' => $timezone,
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
            } catch(Exception $e) {
                return "Need Auth";
            }
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

        $result = $this->GetDrivingDistance($latitudeFrom, $latitudeTo, $longitudeFrom, $longitudeTo);
        $result = $result / 1000.0;
        return round($result * 0.621371, 2);
    }

    function GetDrivingDistance($lat1, $lat2, $long1, $long2)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL&key=AIzaSyATQgdZ12KKj6Kty5bJS90dnB9BUNEYnYg";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        $dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
        return $dist;
        //return array('distance' => $dist, 'time' => $time);
    }
}
