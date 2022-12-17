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
$router->post('payment/bank-transfer', function() {
    $payload = json_decode(base64_decode($_POST['payload']));
  if($payload->type == 'wallet'){
    $payload->price = $_POST['price'];
  }
  $payload = base64_encode(json_encode($payload));
include "app/core/pay_params.php";
foreach ($_SESSION['app']->payment_gateways as $gateways){ if($gateways->title == "bank-transfer"){

$body = "
<style>.card-body{display:block !important}</style>
<p><strong>".T::bankname."</strong> $gateways->c1</p>
<p><strong>".T::bankaddress."</strong> $gateways->c2</p>
<p><strong>".T::accountnumber."</strong> $gateways->c3</p>
<p><strong>".T::swiftnumber."</strong> $gateways->c4</p>
<p><strong>".T::iban."</strong> $gateways->c5</p>
<hr>
<small>".T::noteinvoicemsg."</small>
"; }}

include "app/core/pay_view.php"; });