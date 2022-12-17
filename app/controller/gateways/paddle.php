<?php

// PARAMS TO USE FOR GATEWAY
// ===================================>
// Client Email -> $client_email
// Price        -> $price
// Currency     -> $currency
// Success URL  -> $success_url
// Invoice URL  -> $invoice_url
// Booking ID   -> $booking_id
// Booking No   -> $booking_no
// ===================================>

// GATEWAY NAME CONTROLLER
$router->post('payment/paddle', function() {
  $payload = json_decode(base64_decode($_POST['payload']));
  if($payload->type == 'wallet'){
    $payload->price = $_POST['price'];
  }
  $payload = base64_encode(json_encode($payload));
include "app/core/pay_params.php";

$data['vendor_id'] = $c1;
$data['vendor_auth_code'] = $c2;

$data['title'] = $desc; // name of product
$data['webhook_url'] = 'http://phptravels.com/'; // $invoice_url URL to call when product is purchased

$data['prices'] = [ ''.$currency.':'.$price.'' ];

// Setting some other (optional) data.
$data['custom_message'] = $desc;
$data['return_url'] = $invoice_url;

// Here we make the request to the Paddle API
$urlc = $url;
$ch = curl_init($urlc);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);

// And handle the response...
$data = json_decode($response);
if($data->success) {
  // echo "<a href=" . $data->response->url . ">pay</a>";
} else {
    echo "Your request failed with error: ".$data->error->message;
} ?>

<?php
$body = '<a href='. $data->response->url .' class="pay" style="background:#445a7d"/>'.T::paynow.'</a>';
include "app/core/pay_view.php";

});