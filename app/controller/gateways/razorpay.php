<?php

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Curl\Curl;

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

// C1 rzp_test_fNUdDrce33sAWv
// C2 5B2f5roGEy2zW7iCcS4waATY
// CARD INTERNATIONAL 5104 0155 5555 5558

// GATEWAY NAME CONTROLLER
$router->post('payment/razorpay', function() {
include "app/core/pay_params.php";

$api = new Api($c1, $c2);
$amount = $price * 100;

$curl = curl_init();
$params = array(
    "amount" => $amount,
    "currency" => $currency,
    "receipt" => "Invoice ".$booking_id.$booking_no
);

$curl = new Curl();
$curl->setBasicAuthentication($c1, $c2);
$curl->post('https://api.razorpay.com/v1/orders', $params);
 
// dd($curl->response->id);
// die;

// file_put_contents("post.log", print_r($_POST, true));

$body = '<a href="#" type="button" id="rzp-button1" style="background: #5469d4;" class="pay"/>'.T::paynow.' <small> '.$currency.' </small>'.$price.'</a>';
include "app/core/pay_view.php";
?>

<form action="<?=root?>payment/razorpaid" method="POST">
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?=$c1?>" // Enter the Test API Key ID generated from Dashboard → Settings → API Keys
    data-amount="<?=$amount?>" // Amount is in currency subunits. Hence, 29935 refers to 29935 paise or ₹299.35.
    data-currency="<?=$currency?>"// You can accept international payments by changing the currency code. Contact our Support Team to enable International for your account
    data-order_id="<?=$curl->response->id?>"// Replace with the order_id generated by you in the backend.
    data-buttontext="Pay with Razorpay"
    data-name="Reservation"
    data-description="Invoice <?=$booking_id.$booking_no?>"
    data-image="<?=root?>api/uploads/global/favicon.png"
    data-prefill.name=""
    data-prefill.email="<?=$client_email?>"
    data-theme.color="#093eff"
></script>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>

    // TRIGGER RAZORPAY BUTTON 
    $("#rzp-button1").click(function(){
    $(".razorpay-payment-button").click(); 
    return false;
});
</script>

<style>
/* HIDE RAZORPAY BUTTON */
.razorpay-payment-button { display:none }
</style>

<input type="hidden" custom="" value="<?=$invoice_url?>" name="invoice_url">
<input type="hidden" custom="" value="<?=$success_url?>" name="success_url">
<input type="hidden" custom="" value="<?=$c1?>" name="c1">
<input type="hidden" custom="" value="<?=$c2?>" name="c2">
</form>

<?php  });

$router->post('payment/razorpaid(.*)', function() {
    
    $success = true;
    $error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($_POST['c1'], $_POST['c2']);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_POST['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
    $html = "<p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
             header('Location: '.$_POST['success_url']);
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
             header('Location: '.$_POST['invoice_url']);
}

echo $html;

});