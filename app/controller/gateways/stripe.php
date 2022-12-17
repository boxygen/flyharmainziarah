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
$router->post('payment/stripe', function() {
    $payload = json_decode(base64_decode($_POST['payload']));
  if($payload->type == 'wallet'){
    $payload->price = $_POST['price'];
  }
  $payload = base64_encode(json_encode($payload));
include "app/core/pay_params.php";

// file_put_contents("post.log", print_r($_POST, true));

\Stripe\Stripe::setApiKey($c2);

$amount = $price * 100;

$session = \Stripe\Checkout\Session::create([
'customer_email' => $client_email,
'payment_method_types' => ['card'],
'mode' => 'payment',
'line_items' => [[
    // 'name' => 'T-shirt',
    // 'description' => 'Comfortable cotton t-shirt',
    // 'images' => ['https://example.com/t-shirt.png'],
    // 'amount' => 2000,
    // 'currency' => 'usd',
    'price_data' => [
      'currency' => $currency,
      'unit_amount' => $amount,
      'product_data' => [
        'name' => 'Travel Booking',
        'description' => 'Booking for Invoice ' . $booking_id.$booking_no,
        // 'images' => ['https://example.com/t-shirt.png'],
      ],
    ],
    'quantity' => 1,
  ]],
'success_url' => $success_url,
'cancel_url' => $invoice_url,
]);

// SHOW IF THERE IS ERROR 
if (!isset($session->id)) { echo " STRIPE SETTING ERROR"; die; }

$session_id = $session->id; ?>

<script src='https://js.stripe.com/v3/'></script>

<script>
function checkout(session_id) {
var stripe = Stripe('<?=$c1?>');
stripe.redirectToCheckout({
sessionId: '<?= $session_id; ?>'
}).then(function (result) {
// INCASE OF ERROR
});
}
</script>

<?php
$body = '<a href="#" type="button" onclick="checkout()" style="background: #5469d4;" class="pay"/>'.T::paynow.' <small> '.$currency.' </small>'.$price.'</a>';
include "app/core/pay_view.php";
?>

<?php  });