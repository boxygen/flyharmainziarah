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
$router->post('payment/paypal', function() {
    $payload = json_decode(base64_decode($_POST['payload']));
  if($payload->type == 'wallet'){
    $payload->price = $_POST['price'];
  }
  $payload = base64_encode(json_encode($payload));
include "app/core/pay_params.php";
?>
<script src="<?=$url?>?client-id=<?=$c1?>&disable-funding=credit,card&currency=<?=$currency?>"></script>
    <script>
        paypal.Buttons({
        style: {
        layout:  'vertical',
        color:   'blue',
        shape:   'rect',
        label:   'paypal'
        },
         createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?=$price?>
                    }
                }]
            });
        },
         onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Show a success message to the buyer
                // alert('Transaction completed by ' + details.payer.name.given_name + '!');
                window.location.href = '<?=$success_url?>';
            });
        }

        }).render('#paypal-button');
    </script>
    <?php
    $body = "<div style='width:100%' id='paypal-button'></div>";
    include "app/core/pay_view.php";
    ?>
    <hr>
    <p><?=T::oncepaymentcompletedmsg?></p>
<?php });