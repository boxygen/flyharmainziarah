<?php

use Curl\Curl;

// VISA SUBMISSION FORM
$router->get(visa.'/submit(.*)', function() {
    $url = explode('/', $_GET['url']);
    $count = count($url);
    if ($count < 4) { header('Location: '.root);  }

    $module = $url[0];
    $submit = $url[1];
    $from_country = $url[2];
    $to_country = $url[3];
    $date = $url[4];
    $ip = $_SERVER['REMOTE_ADDR'];
    $browser_version = $_SERVER['HTTP_USER_AGENT'];
    $request_type = 'web';
    $os = get_operating_system();

    $data = array(
    'from_country' => $from_country,
    'to_country' => $to_country,
    'ip' => $ip,
    'browser_version' => $browser_version,
    'request_type' => $request_type,
    'os' => $os
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => api_url.'api/ivisa/search?appKey='.api_key,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
    'Cookie: ci_session=j64b5qt3muujs1qhjcfjrdgdjio4oi9k'
    ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    // SEO META INFORMATION
    $title = "Submit Visa";
    $meta_title = "Submmit VIsa";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    // GENERATE LOGS
    logs($SearchType = "Visa search ");

    SEARCH_SESSION($MODULE=T::visa_visa,$CITY=strtoupper($from_country)."<i class='la la-arrow-right px-1'></i>".strtoupper($to_country));

    $body = views."modules/visa/index.php";
    include layout;
});

$router->get(visa, function() {

    $title = "Submit Visa";
    $meta_title = "Submmit VIsa";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $body = views."modules/visa/visa.php";
    include layout;
});

// VISA SUBMISSION FORM
$router->get('success/visa', function() {

    // SEO META INFORMATION
    $title = "Visa Submitted";
    $meta_title = "Visa Submitted";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $body = views."modules/visa/success.php";
    include layout;
});

$router->post('submit/visa', function() {
    $data = array(
    'first_name' => $_POST['first_name'],
    'last_name' => $_POST['last_name'],
    'email' => $_POST['email'],
    'status' => 'waiting',
    'phone' => $_POST['phone'],
    'from_country' => $_POST['from_country'],
    'to_country' => $_POST['to_country'],
    'notes' => $_POST['notes'],
    'date' => $_POST['date'],
    'res_code' => '1234'
    );
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => api_url.'api/ivisa/booking?appKey='.api_key,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
    'Cookie: ci_session=j64b5qt3muujs1qhjcfjrdgdjio4oi9k'
    ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    if ($response){

    // FINAL BOOKING REQUEST
    $req = new Curl();
    $req->post(api_url.'api/email/globalmail?appKey='.api_key, array(
    'email' => $_POST['email'],
    'body' => T::visa_mail_body,
    'subject' => T::visa_mail_subject
    ));

    header('Location: '.root.'success/visa');}else{

    // SEO META INFORMATION
    $title = "Submit Visa";
    $meta_title = "Submit Visa";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";
    $body = views."modules/visa/visa.php";
    include layout;
    }

    // GENERATE LOGS
    logs($SearchType = "Visa Submit ");

});
