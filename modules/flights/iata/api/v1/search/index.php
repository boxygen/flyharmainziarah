<?php

// HEADER JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// print_r($_POST);
// die;

$parms = [
'origin' => $_REQUEST['origin'],
'destination' => $_REQUEST['destination'],
'departure_date' => $_REQUEST['departure_date'],
'return_date' => $_REQUEST['return_date'],
'type' => $_REQUEST['type'],
'class_trip' => $_REQUEST['class'],
'adults' => $_REQUEST['adults'],
'childrens' => $_REQUEST['childs'],
'infants' => $_REQUEST['infants'],
'currency' => $_REQUEST['currency'],
'evn' => 'dev',
'c1' => 'booknowphptravels',
'c2' => 'hM_ulx_KEwojzGyTCrKeSJuWMUVJWIA9',
'ip' => $_REQUEST['ip'],
'browser_version' => $_SERVER['HTTP_USER_AGENT'],
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://phptravels.net/modules/flights/kiwi/api/v1/search');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parms));
$response = curl_exec($ch);
var_export($response);


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array($parms),
//   CURLOPT_HTTPHEADER => array(
//     'Cookie: PHPSESSID=23jcvnt9ocnic0o7a5ok7u7pde'
//   ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>