<?php
use Curl\Curl;

$router->get('regions', function() { 

    header('Content-Type: application/json; charset=utf-8');
    $req = new Curl();
    $req->get('https://www.kayak.com/mvm/smartyv2/search?f=j&s=airportonly&where='.$_GET['q']);
    $respose = array ( "status"=>"true", "message"=>"image", "data"=> $req->response[0]->destination_images->image_jpeg );
    echo json_encode($respose);

});

/* ---------------------------------------------- */
// FLIGHTS INDEX
/* ---------------------------------------------- */

$router->get('flights', function() {
    $title = T::search. ' '. T::flights_flights;
    $meta_title = T::search. ' '. T::flights_flights;
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";
    $body = views."modules/flights/flights.php";
    include layout;
});

/* ---------------------------------------------- */
// FLIGHTS SEARCH
/* ---------------------------------------------- */

$lancur = $_SESSION['session_lang'].'/'.strtolower($_SESSION['session_currency']).'/';

$router->get('/flights/'.$lancur.'(.*)', function()  {
    $url = explode('/', $_GET['url']);
    $count = count($url);

    function flights_session(){

    $uri = explode('/', $_GET['url']);
    $c = count($uri);

    if ($c == 11) { } else { $_SESSION['flights_returning_date']=return_date; }

    $_SESSION['flights_origin']=origin;
    $_SESSION['flights_destination']=destination;
    $_SESSION['flights_departure_date']=departure_date;
    $_SESSION['flights_adults']=adults;
    $_SESSION['flights_childs']=childs;
    $_SESSION['flights_infants']=infants;
    $_SESSION['flights_type']=type;
    $_SESSION['flights_class']=class_type;

    }

    if ($count == 11) {

    define('lang', $url[1]);
    $currency = $url[2];
    define('origin', $url[3]);
    define('destination', $url[4]);
    define('type', $url[5]);
    define('class_type', $url[6]);
    define('departure_date', $url[7]);
    define('adults', $url[8]);
    define('childs', $url[9]);
    define('infants', $url[10]);
    define('return_date','');

    flights_session();

    } elseif ($count == 12) {

    define('lang', $url[1]);
    $currency = $url[2];
    define('origin', $url[3]);
    define('destination', $url[4]);
    define('type', $url[5]);
    define('class_type', $url[6]);
    define('departure_date', $url[7]);
    define('return_date', $url[8]);
    define('adults', $url[9]);
    define('childs', $url[10]);
    define('infants', $url[11]);

    flights_session();

    }elseif ($count > 12) {
    $url = explode('/', $_GET['url']);
    $last3_elements = array_slice($url, -3, 3, true);
    $adultsarr = array_slice($last3_elements, -3, true);
    $childsarr = array_slice($last3_elements, -2, true);
    $infantsarr = array_slice($last3_elements, -1, true);
    if ($count == 14) {
    define('lang', $url[0]);
    $currency = $url[1];
    define('flights_origin', $url[3]);
    define('flights_destination', $url[4]);
    define('flights_departure_date', $url[5]);
    define('flights_origin', $url[6]);
    define('flights_destination', $url[7]);
    define('flights_departure_date', $url[8]);
    define('flights_type', $url[9]);
    define('flights_flight_type', $url[10]);
    define('flights_adults', $adultsarr[0]);
    define('flights_childs', $childsarr[0]);
    define('flights_infants', $infantsarr[0]);

    echo "2";
    }elseif ($count == 17) {
    define('lang', $url[0]);
    $currency = $url[1];
    define('origin1', $url[3]);
    define('destination1', $url[4]);
    define('departure_date1', $url[5]);
    define('origin2', $url[6]);
    define('destination2', $url[7]);
    define('departure_date2', $url[8]);
    define('origin3', $url[9]);
    define('destination3', $url[10]);
    define('departure_date3', $url[11]);
    define('type', $url[12]);
    define('flight_type', $url[13]);
    define('adults', $adultsarr[0]);
    define('childs', $childsarr[0]);
    define('infants', $infantsarr[0]);
    echo "3";
    }elseif ($count == 20) {
    define('lang', $url[0]);
    $currency = $url[1];
    define('origin1', $url[3]);
    define('destination1', $url[4]);
    define('departure_date1', $url[5]);
    define('origin2', $url[6]);
    define('destination2', $url[7]);
    define('departure_date2', $url[8]);
    define('origin3', $url[9]);
    define('destination3', $url[10]);
    define('departure_date3', $url[11]);
    define('origin4', $url[12]);
    define('destination4', $url[13]);
    define('departure_date4', $url[14]);
    define('type', $url[15]);
    define('flight_type', $url[16]);
    define('adults', $adultsarr[0]);
    define('childs', $childsarr[0]);
    define('infants', $infantsarr[0]);
    echo "4";
    }elseif ($count == 23) {
    define('lang', $url[0]);
    $currency = $url[1];
    define('origin1', $url[3]);
    define('destination1', $url[4]);
    define('departure_date1', $url[5]);
    define('origin2', $url[6]);
    define('destination2', $url[7]);
    define('departure_date2', $url[8]);
    define('origin3', $url[9]);
    define('destination3', $url[10]);
    define('departure_date3', $url[11]);
    define('origin4', $url[12]);
    define('destination4', $url[13]);
    define('departure_date4', $url[14]);
    define('origin5', $url[15]);
    define('destination5', $url[16]);
    define('departure_date5', $url[17]);
    define('type', $url[18]);
    define('flight_type', $url[19]);
    define('adults', $adultsarr[0]);
    define('childs', $childsarr[0]);
    define('infants', $infantsarr[0]);
    echo "5";
    }else {
    define('lang', $url[0]);
    $currency = $url[1];
    define('origin1', $url[3]);
    define('destination1', $url[4]);
    define('departure_date1', $url[5]);
    define('origin2', $url[6]);
    define('destination2', $url[7]);
    define('departure_date2', $url[8]);
    define('origin3', $url[9]);
    define('destination3', $url[10]);
    define('departure_date3', $url[11]);
    define('origin4', $url[12]);
    define('destination4', $url[13]);
    define('departure_date4', $url[14]);
    define('origin5', $url[15]);
    define('destination5', $url[16]);
    define('departure_date5', $url[17]);
    define('origin6', $url[18]);
    define('destination6', $url[19]);
    define('departure_date6', $url[20]);
    define('type', $url[21]);
    define('flight_type', $url[22]);
    define('adults', $adultsarr[0]);
    define('childs', $childsarr[0]);
    define('infants', $infantsarr[0]);
    echo "6";
    }

    echo "Multi";

    }

    $title = "Flights";
    $meta_title = "Flights";
    $meta_appname = "Flights";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $req = new Curl();
    $req->setTimeout(0);
    $req->post(api_url.'api/flight/search?appKey='.api_key, array(
    'origin'=>origin,
    'destination'=>destination,
    'type'=>type,
    'departure_date'=>departure_date,
    'return_date'=>return_date,
    'currency'=>$currency,
    'adults'=>adults,
    'childrens'=>childs,
    'infants'=>infants,
    'class_type'=>class_type,
    'ip' => $_SERVER['REMOTE_ADDR'],
    'browser_version' => $_SERVER['HTTP_USER_AGENT'],
    'request_type' => 'web',
    'os' => get_operating_system()
    ));

    if ($req->error) { echo 'Error: ' . $req->errorCode . ': ' . $req->errorMessage . "\n";
    } else {
    if ($req->response) {
        $string = $req->response;
    }else{
        $string = [];
    }

function isJSON($string){
   return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

if(isJSON($string)){
 $flights_data = json_decode($string);
}
if(!isJSON($string)){
 $flights_data = $string;
}

};

// ADD SEARCH TO SESSION
SEARCH_SESSION($MODULE=T::flights_flights,$CITY=strtoupper($url[3])."<i class='la la-arrow-right px-1'></i>".strtoupper($url[4]));

$body = views."modules/flights/listing.php";
include layout;
});

/* ---------------------------------------------- */
// FLIGHTS BOOKING
/* ---------------------------------------------- */

$router->post('flights/booking', function() {

$title = "Flight Booking";
$meta_title = "Flight Booking";
$meta_appname = "Flight Booking";
$meta_desc = "";
$meta_img = "";
$meta_url = "";
$meta_author = "";
$meta = "1";

// CHECK USER SESSION
if (isset($_SESSION['user_login']) == true) {
$req = new Curl();
$req->post(api_url . 'api/login/get_profile?appKey=' . api_key, array('id' => $_SESSION['user_id'], ));
$profile = json_decode($req->response);
$profile_data = $profile->response;

} else {}

// GENERATE LOGS
logs($SearchType = "Flights Booking");

// PAYLOAD DATA
$routes = (array) json_decode(base64_decode($_POST['routes'], true));
$prices = json_decode(base64_decode($_POST['prices'], true));
$traveller = json_decode(base64_decode($_POST['travellers'], true));

$body = views."modules/flights/booking.php";
include layout;
});

// FINAL BOOKING REQUEST
$router->post('flights/book', function() {

// CRM HUBSPOT INTEGRATION
include "app/integrations/crm_booking_hubspot.php";

// PAYLOAD DATA
$route = json_decode(base64_decode($_POST['routes']));
$routes = json_encode($route);
$traveller = json_decode(base64_decode($_POST['traveller']));
$prices = json_decode(base64_decode($_POST['prices']));
$travellers = $traveller->adults + $traveller->childs + $traveller->infants;

// ADULTS
$data = [];
for ($i = 1; $i <= $traveller->adults; $i++) {
    array_push($data, (object) array(
    'traveller_type'=>$_POST["traveller_type_".$i],
    'title'=>$_POST["title_".$i],
    'first_name'=>$_POST["firstname_".$i],
    'last_name'=>$_POST["lastname_".$i],
    'nationality'=>$_POST["nationality_".$i],
    'dob_day'=>$_POST["dob_day_".$i],
    'dob_month'=>$_POST["dob_month_".$i],
    'dob_year'=>$_POST["dob_year_".$i],
    'passport'=>$_POST["passport_".$i],
    'passport_day'=>$_POST["passport_day_".$i],
    'passport_month'=>$_POST["passport_month_".$i],
    'passport_year'=>$_POST["passport_year_".$i],
    'passport_issuance_day'=>$_POST["passport_issuance_day_".$i],
    'passport_issuance_month'=>$_POST["passport_issuance_month_".$i],
    'passport_issuance_year'=>$_POST["passport_issuance_year_".$i]
    ));
}

// CHILDS
for ($x = 1; $x <= $traveller->childs; $x++) {
$adults = $traveller->adults;
array_push($data, (object) array(
'traveller_type'=>$_POST["traveller_type_".$x+$adults],
'title'=>$_POST["title_".$x+$adults],
'first_name'=>$_POST["firstname_".$x+$adults],
'last_name'=>$_POST["lastname_".$x+$adults],
'nationality'=>$_POST["nationality_".$x+$adults],
'dob_day'=>$_POST["dob_day_".$x+$adults],
'dob_month'=>$_POST["dob_month_".$x+$adults],
'dob_year'=>$_POST["dob_year_".$x+$adults],
'passport'=>$_POST["passport_".$x+$adults],
'passport_day'=>$_POST["passport_day_".$x+$adults],
'passport_month'=>$_POST["passport_month_".$x+$adults],
'passport_year'=>$_POST["passport_year_".$x+$adults],
'passport_issuance_day'=>$_POST["passport_issuance_day_".$x+$adults],
'passport_issuance_month'=>$_POST["passport_issuance_month_".$x+$adults],
'passport_issuance_year'=>$_POST["passport_issuance_year_".$x+$adults],
));
}

// INFANTS
for ($b = 1; $b <= $traveller->infants; $b++) {
$a = $traveller->childs+$traveller->adults;
array_push($data, (object) array(
'traveller_type'=>$_POST["traveller_type_".$b+$a],
'title'=>$_POST["title_".$b+$a],
'first_name'=>$_POST["firstname_".$b+$a],
'last_name'=>$_POST["lastname_".$b+$a],
'nationality'=>$_POST["nationality_".$b+$a],
'dob_day'=>$_POST["dob_day_".$b+$a],
'dob_month'=>$_POST["dob_month_".$b+$a],
'dob_year'=>$_POST["dob_year_".$b+$a],
'passport'=>$_POST["passport_".$b+$a],
'passport_day'=>$_POST["passport_day_".$b+$a],
'passport_month'=>$_POST["passport_month_".$b+$a],
'passport_year'=>$_POST["passport_year_".$b+$a],
'passport_issuance_day'=>$_POST["passport_issuance_day_".$b+$a],
'passport_issuance_month'=>$_POST["passport_issuance_month_".$b+$a],
'passport_issuance_year'=>$_POST["passport_issuance_year_".$b+$a],
));
}
$guests = json_encode($data);

function user_id()
{ if (isset($_SESSION['user_login']) == true) {
return $_SESSION['user_id'];} else { return "0";}
} $user_id = user_id();

$flight_no = isset($_POST['flight_id']) ? $_POST['flight_id'] : '';


$req = new Curl();
$req->post(api_url.'api/flight/book?appKey='.api_key, array(

'flight_id'=>$flight_no,
'total_price'=>$prices->total,
'adults'=>$traveller->adults,
'childs'=>$traveller->childs,
'infants'=>$traveller->infants,
'deposit'=>'50',
'tax'=>'45',

'firstname' => $_POST['firstname'],
'lastname' => $_POST['lastname'],
'email' => $_POST['email'],
'address' => $_POST['address'],
'phone' => $_POST['phone'],

'supplier'=>$prices->supplier,
'curr_code'=>$prices->currency,
'deposit_type'=>'percentage',
'flights_data'=>$routes,
'user_id' => $user_id,
'payment_gateway' => $_POST['payment_gateway'],
'booking_key' => '',
'guest' => $guests,
'supplier_name' => $prices->supplier_name,

'nationality' => $_POST['nationality'],

'booking_from' => 'web',
'flight_type' => $prices->flight_type,
"invoice_url" => root . 'flights/booking/invoice/',

'token' => 'SABSEPOWERFULLANDSECURECODESIGNUPKAYLIYE',

));
 if ($req->response == true) {
$invoice_url = root.'flights/booking/invoice/'.$req->response->sessid.'/'.$req->response->id;

// BOOKING HOOK
include "app/integrations/booking_hook.php";

header('Location: '.$invoice_url);
} else { echo "Booking Error Please Try Again."; }

// GENERATE LOGS
logs($SearchType = "Flights Book ");

});

/* ---------------------------------------------- */
// FLIGHTS GET INVOICE
/* ---------------------------------------------- */
$router->get('flights/booking/invoice/(.*)', function () {

    $url = explode('/', $_GET['url']);

    $req = new Curl();
    $req->get(api_url.'api/flight/invoice?appKey='.api_key.'&invoice_id='.$url[3].'&booking_id='.$url[4] );

    if (!empty($req->response->booking_response)){
        $booking_ = $req->response->booking_response;
        $booking = $booking_[0];
        $routes = json_decode($booking->routes);
    };

    $title = "Flight Invoice";
    $meta_title = "Flight Invoice";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $invoice = views."modules/flights/invoice.php";
    $body = invoice_layout;
    include layout;
});

/* ---------------------------------------------- */
// FLIGHTS INVOICE UPDATE
/* ---------------------------------------------- */
$router->get('flights/invoice/update', function () {
   //  $payload = json_decode(base64_decode($_POST['payload']));

    $req = new Curl();
    $req->post(api_url.'api/flight/invoicebooking?appKey='.api_key, array(
    'booking_id' => $_GET['booking_id'],
    'invoice_id' => $_GET['booking_no'],
    'status' => $_GET['booking_status'],
    'payment_status' => $_GET['payment_status'],
    'payment_gateway' => $_GET['payment_gateway'],
    'amount_paid' => "",
    'remaining_amount' => "",
    'payment_date' => date("Y-m-d"), //.date(" h:i:s a")
    'txn_id' => "",
    'token' => "",
    'logs' => "",
    'desc' => ""
    ));

    if ($req->response == true) {
        if($_GET['supplier_name'] !== 'manual'){
             $confirm = new Curl();
            $confirm->post(api_url.'api/flight/booking?appKey='.api_key, array(
            'booking_id' => $_GET['booking_id'],
            ));
            // var_dump($confirm->response);
            // exit();        
        }

    header('Location:'.root.'flights/booking/invoice/'.$_GET['booking_no'].'/'.$_GET['booking_id']);
    } else { echo "Booking Error Please Try Again."; }

    // GENERATE LOGS
    logs($SearchType = "Flight booking paid " );

});


/* ---------------------------------------------- */
// FLIGHTS BOOKING CANCELLATION REQUEST
/* ---------------------------------------------- */
$router->post('flights/cancellation', function () {

    // FINAL BOOKING REQUEST
    $req = new Curl();
    $req->post(api_url.'api/flight/cancellation?appKey='.api_key, array(
    'invoice_id' => $_POST['booking_no'],
    'booking_id' => $_POST['booking_id'],
    'cancellation_request' => 1
    ));

    if ($req->response == true) {
        header('Location: ' . root . 'flights/booking/invoice/' . $_POST['booking_no'] . '/' . $_POST['booking_id']);
    } else { echo "Booking Error Please Try Again."; }

    // GENERATE LOGS
    logs($SearchType = "Flight Cancel Request ID" .$_POST['booking_id'] );

});

// URL FOR CURRENCY CHANGED FLIGHTS
$router->get(flights.'(.*)', function()  {
$url = explode('/', $_GET['url']);
$urls = implode('/', $url);
$_SESSION['session_currency'] = $url[2];
echo '<script>window.location.href = "'.root.$urls.'"</script>';
});