<?php 

if (isset($_POST['phone'])) { $mobile = $_POST['phone']; } else { $mobile = ""; }

include "app/integrations/config.php";

if (!empty($nexmo_api_key)) {
    
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://rest.nexmo.com/sms/json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "from=$nexmo_from&text=Thanks for booking. view invoice link $invoice_url &to=$mobile&api_key=$nexmo_api_key&api_secret=$nexmo_api_shared_key");

$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

// dd($result);
// die;

}

?>