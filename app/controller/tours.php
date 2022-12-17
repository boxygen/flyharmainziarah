<?php

/* ---------------------------------------------- */
// TOURS MODULE CONTROLLER
/* ---------------------------------------------- */

use Curl\Curl;

$router->get(tours, function() {

    $title = T::tours_search_tours;
    $meta_title = T::tours_search_tours;
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $body = views."modules/tours/tours.php";
    include layout;

});

$lancur = $_SESSION['session_lang'].'/'.strtolower($_SESSION['session_currency']).'/';

// ======================== TOURS LISTING PAGE ===========================================================
$router->get('/tours/'.$lancur.'(.*)', function()  {

    $url = explode('/', $_GET['url']);
    $count = count($url);
    if ($count < 8) { echo ""; }

    $language = $url[1];
    $currency = $url[2];
    $city = $url[3];
    $date = $url[4];
    $adults = $url[5];
    $childs = $url[6];

    // SEO META TAGS
    $title = "Tours in " .$city;
    $meta_title = "Tours in " .$city;
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    // ADDING SEARCH CREDENTIALS TO SESSION
    $_SESSION['tours_location']=$city;
    $_SESSION['tours_date']=$date;
    $_SESSION['tours_adults']=$adults;
    $_SESSION['tours_childs']=$childs;

    // GENERATE SEARCH LOGS
    logs($SearchType = "tours Search");

    // ADDING SEAARCH TO SESSION
    SEARCH_SESSION($MODULE=T::tours_tours,$CITY=$city);

    $req = new Curl();
     $req->post(api_url . 'api/tour/search?appKey=' . api_key, array(
    'loaction' => $city,
    'checkin' => $date,
    'adults' => $adults,
    'chlids' => $childs,
    'lang' => $_SESSION['session_lang'],
    'currency' => $currency,
    'ip' => $_SERVER['REMOTE_ADDR'],
    'browser_version' => $_SERVER['HTTP_USER_AGENT'],
    'type' => 'web',
    'os' => get_operating_system()
    ));

    $tours_data = $req->response;
    $nights = 10;

    logs($SearchType = "Tours Search");

    $_SESSION['tours_data'] = $tours_data;

    $body = views."modules/tours/listing.php";
    include layout;
});


// ======================== TOURS DETAILS PAGE ===========================================================
$router->get('/tour/'.$lancur.'(.*)', function()  {
    $url = explode('/', $_GET['url']);
    $count = count($url);
    if ($count < 8) { echo ""; }
    
    $language = $url[1];
    $currency = $url[2];
    $city = $url[3];
    $tour_name = $url[4];
    $tour_id = $url[5];
    $date = $url[6];
    $supplier = $url[7];
    $adults = $url[8];
    $childs = $url[9];
    
    $req = new Curl();
    $req->post(api_url . 'api/tour/detail?appKey=' . api_key, array(
        'tour_id' => $tour_id,
        'currency' => $currency,
        'supplier' => $supplier,
    ));
    
    // dd($req->response);exit();
    $tour = $req->response;
    if (isset($tour->img[0])){ $img = $tour->img[0]; } else { $img = ""; }

    $link = implode(" ",$url);

    $name = str_replace("-", " ", $tour_name);

    // SEO META TAGS
    $title = $name;
    $meta_title = $name;
    $meta_appname = "";
    $meta_desc = strip_tags($tour->desc);
    $meta_img = $img;
    $meta_url = root.str_replace(' ', '/', $link);
    $meta_author = "PHPTRAVELS";
    $meta = "1";

    // GENERATE DETAILS PAGE LOGS
    logs($SearchType = "tours details");

    $body = views."modules/tours/details.php";
    include layout;
});

// ======================== TOURS BOOKING PAGE ===========================================================
$router->post('tours/booking', function() {
    $tour = json_decode(base64_decode($_POST['payload']));
    // dd($_POST);exit();

    // SEO META TAGS
    $title = "Booking ". $tour->name;
    $meta_title = "Booking ". $tour->name;
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "PHPTRAVELS";
    $meta = "1";

    if (empty($_POST['adults'])) {$adults=0;} else {$adults=$_POST['adults'];}
    if (empty($_POST['childs'])) {$childs=0;} else {$childs=$_POST['childs'];}
    if (empty($_POST['infants'])) {$infants=0;} else {$infants=$_POST['infants'];}

    // CHECK IF USER EXIST SESSION
    if (isset($_SESSION['user_login']) == true) {
    $req = new Curl();
    $req->post(api_url . 'api/login/get_profile?appKey=' . api_key, array('id' => $_SESSION['user_id'], ));
    $profile = json_decode($req->response);
    $profile_data = $profile->response;
    } else {}

    // GENERATE LOGS
    logs($SearchType = "tours booking");

    $body = views."modules/tours/booking.php";
    include layout;

});

// ======================== TOURS BOOK ===========================================================
$router->post('tours/book', function() {
    $payload = json_decode(base64_decode($_POST['payload']));

    // CRM HUBSPOT INTEGRATION
    include "app/integrations/crm_booking_hubspot.php";

    function user_id()
    { if (isset($_SESSION['user_login']) == true) {
    return $_SESSION['user_id'];} else { return "0";}
    } $user_id = user_id();

    $travellers = $payload->travellers;
    $data = [];
    for ($i = 1; $i <= $travellers; $i++) {
        array_push($data, (object) array(
            'title'=>$_POST["title_".$i],
            'first_name'=>$_POST["firstname_".$i],
            'last_name'=>$_POST["lastname_".$i]
        ));
    }
    $guest = json_encode($data);

    $req = new Curl();
    $req->post(api_url . 'api/tour/book?appKey=' . api_key, array(
    'tour_id' => $payload->tour_id,
    'total_price' => str_replace(',','',$payload->total_price),
    'tours_name' => $payload->name,
    'checkin' => $payload->date,
    'adults' => $payload->adults,
    'childs' => $payload->childs,
    'infants' => $payload->infants,
    'deposit' => "",
    'tax' => "",

    'firstname' => $_POST['firstname'],
    'lastname' => $_POST['lastname'],
    'email' => $_POST['email'],
    'address' => $_POST['address'],
    'phone' => $_POST['phone'],

    'supplier' => $payload->supplier,
    'curr_code' => $payload->currency,
    'tax_type' => "",
    'deposit_type' => "",
    'loaction' => $payload->location,
    'tour_img' => $payload->img[0],

    'user_id' => $user_id,
    'payment_gateway' => $_POST['payment_gateway'],
    'latitude' => $payload->latitude,
    'longitude' => $payload->longitude,
    'guest' => $guest,
    'stars' => "",
    "supplier_name" => $payload->supplier_name,

    'hotel_phone' => "",
    'booking_from' => "web",
    'price_type' => "",
    'tour_adult_price' => "",
    'tour_child_price' => "",
    'tour_infant_price' => "",
    'infants' => "",

    'redirect' => "",
    "invoice_url" => root . 'tours/booking/invoice/',

    'token' => 'SABSEPOWERFULLANDSECURECODESIGNUPKAYLIYE',

    ));

    if ($req->response == true) {
    $invoice_url =  root.'tours/booking/invoice/' . $req->response->sessid . '/' . $req->response->id;

    // BOOKING HOOK
    include "app/integrations/booking_hook.php";

    header('Location: ' .$invoice_url);
    } else { echo "Booking Error Please Try Again."; }

    // GENERATE LOGS
    logs($SearchType = "Tour Booked ");

});

// ======================== TOURS INVOICE PAGE ===========================================================
$router->get('tours/booking/invoice/(.*)', function () {

    $url = explode('/', $_GET['url']);

    $req = new Curl();
    $req->get(api_url.'api/tour/invoice?appKey='.api_key.'&invoice_id='.$url[3].'&booking_id='.$url[4] );
    $booking = $req->response->booking_response[0];

    $price = $booking->total_price;

    $title = "Tour Invoice";
    $meta_title = "Tour Invoice";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $invoice = views . "modules/tours/invoice.php";
    $body = invoice_layout;
    include layout;

});

// ======================== TOURS INVOICE UPDATE PAGE ===========================================================
$router->get('tours/invoice/update', function () {

    $req = new Curl();
    $req->post(api_url.'api/tour/invoice?appKey='.api_key, array(
    'booking_id' => $_GET['booking_id'],
    'ref_id' => $_GET['booking_no'],
    'status' => $_GET['booking_status'],
    'payment_status' => $_GET['payment_status'],
    'payment_gateway' => $_GET['payment_gateway'],
    'amount_paid' => "",
    'remaining_amount' => "",
    'payment_date' => date("Y-m-d"),
    'txn_id' => "",
    'token' => "",
    'logs' => "",
    'desc' => ""
    ));

    if ($req->response == true) {

    $confirm = new Curl();
    $confirm->post(api_url.'api/tour/cofirmedbooking?appKey='.api_key, array(
    'booking_id' => $_GET['booking_id'],
    ));

    header('Location:'.root.'tours/booking/invoice/'.$_GET['booking_no'].'/'.$_GET['booking_id']);
    } else { echo "Booking Error Please Try Again."; }

    // GENERATE LOGS
    logs($SearchType = "Tour booking paid " );

});

// ======================== TOURS CANCELLATION REQUEST ===========================================================
$router->post('tours/cancellation', function () {

    $req = new Curl();
    $req->post(api_url.'api/tour/cancellation?appKey='.api_key, array(
    'invoice_id' => $_POST['booking_no'],
    'booking_id' => $_POST['booking_id'],
    'cancellation_request' => 1
    ));

    if ($req->response == true) {
        header('Location: ' . root . 'tours/booking/invoice/' . $_POST['booking_no'] . '/' . $_POST['booking_id']);
    } else { echo "Booking Error Please Try Again."; }

    // GENERATE LOGS
    logs($SearchType = "Tour Cancel Request ID" .$_POST['booking_id'] );

});

// URL FOR CURRENCY CHANGED
$router->get(tours.'(.*)', function()  {

    $url = explode('/', $_GET['url']);
    $urls = implode('/', $url);
    $_SESSION['session_currency'] = $url[2];
    echo '<script>window.location.href = "'.root.$urls.'"</script>';

});