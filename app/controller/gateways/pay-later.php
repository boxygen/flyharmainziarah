<?php

// gateway name
$router->post('payment/pay-later', function() {
    $payload = json_decode(base64_decode($_POST['payload']));
    if($payload->type == 'wallet'){
      $payload->price = $_POST['price'];
    }
    $payload = base64_encode(json_encode($payload));
include "app/core/pay_params.php"; ?>

<form id="form" action="<?=root?>hotels/invoice/update" method="get">
<input type="hidden" name="booking_id" value="<?=$booking_id?>" />
<input type="hidden" name="booking_no" value="<?=$booking_no?>" />
<input type="hidden" name="booking_status" value="pending" />
<input type="hidden" name="payment_status" value="pay_later" />
<input type="hidden" name="payment_gateway" value="<?=$gateway?>" />
</form>

<script>
setInterval(function() { document.getElementById("form").submit(); }, 2500);
</script>

<?php });