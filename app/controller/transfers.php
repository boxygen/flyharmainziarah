<?php

/* ---------------------------------------------- */
// CARS MODULE CONTROLLER
/* ---------------------------------------------- */

use Curl\Curl;

// STATIC SEARCH PAGE CONTROLLER
$router->get("cars", function() {

    $title = "Search Transfers";
    $meta_title = "Search Transfers";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $body = views."modules/cars/cars.php";
    include layout;

});

$lancur = $_SESSION['session_lang'].'/'.strtolower($_SESSION['session_currency']).'/';

// CAR LISTING PAGE CONTROLLER
$router->get('/transfers/'.$lancur.'(.*)', function()  {

    $url = explode('/', $_GET['url']);
    $count = count($url);
    if ($count < 9) { echo ""; }

    $language = $url[1];
    $currency = $url[2];
    $from_location = $url[3];
    $to_location = $url[4];
    $fromdate = $url[5];
    $todate = $url[6];
    $adults = $url[7];
    $childs = $url[8];

    // SEO META TAGS
    $title = "Transfers in ";
    $meta_title = "Transfers in ";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    // ADD SEARCH CREDENTIALS TO SESSION
    $_SESSION['carfrom_location']=$from_location;
    $_SESSION['carto_location']=$to_location;
    $_SESSION['carfromdate']=$fromdate;
    $_SESSION['cartodate']=$todate;
    $_SESSION['cars_adults']=$adults;
    $_SESSION['cars_childs']=$childs;

    $req = new Curl();
    $req->post(api_url . 'api/car/search?appKey=' . api_key, array(
    
    'origin' => $from_location,
    'destination' => $to_location,
    'from_date' => $fromdate,
    'to_date' => $todate,
    'adults' => $adults,
    'chlid' => $childs,
    'type' => "oneway",

    'lang' => $_SESSION['session_lang'],
    'currency' => $currency,
    'ip' => $_SERVER['REMOTE_ADDR'],
    'browser_version' => $_SERVER['HTTP_USER_AGENT'],
    'os' => get_operating_system()
    ));

    $cars_data = $req->response;

    // CREATE LOGS
    logs($SearchType = "Cars Search");

    // dd($cars_data);

    // ADD LISTING DATA TO SESSION
    $_SESSION['cars_data'] = $cars_data;

    $body = views."modules/cars/listing.php";
    include layout;
});