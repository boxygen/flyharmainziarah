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
$router->post('payment/setmpos', function() {
  $payload = json_decode(base64_decode($_POST['payload']));
  if($payload->type == 'wallet'){
    $payload->price = $_POST['price'];
  }
  $payload = base64_encode(json_encode($payload));

  // print_r($_SESSION["return_url"]); exit
include "app/core/pay_params.php"; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<style>
@import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic);
@import url(https://fonts.googleapis.com/css?family=Roboto:400,100italic,100,300,300italic,400italic,500,500italic,700,700italic,900,900italic);
body{background:#e2e2e2}
.card{width:600px;height:340px;background:#fff;margin:0 auto;border-radius:20px;margin-top:20px}
.top{width:100%;background:#1992fa;padding:42px 0;border-top-left-radius:20px;border-top-right-radius:20px;position:relative}
.payment{position:absolute;width:250px;font-size:22px;color:#fff;font-family:"ubuntu",sans-serif;text-transform:uppercase;line-height:25px;font-weight:500;top:32px;left:35px}
.visa svg{width:120px;height:auto;position:absolute;right:29px;top:-195px}
form{width:550px;margin:0 auto}
.one{width:225px}
.two{width:245px}
.one,.two,.three,.four,.five{float:left;margin:5px 40px 5px 0}
.three,.four,.five{float:left;width:143px}
input,select{clear:both;float:none;display:block;border:1px solid #c5c5c5;padding:14px 15px;border-radius:3px;width:100%;font-size:15px;color:#000;text-align:left;font-weight:bold;background:#fff}
input{color:#f4c358;text-shadow:0 0 0 #000;-webkit-text-fill-color:transparent}
select{padding-left:15px}
label{color:#979797;font-size:12px;font-weight:500;letter-spacing:.-0px;font-family:"ubuntu",sans-serif;text-transform:uppercase;margin:3px 0;display:block}
input[type="text"]:focus,input[type="number"]:focus,textarea:focus,select:focus{box-shadow:none;outline:0;border:1px solid #1992fa}
@media screen and (-webkit-min-device-pixel-ratio:0){select{padding-right:18px}
}label{position:relative}
.info{width:300px;margin:35px auto;text-align:center;font-family:"roboto",sans-serif}
.info h1{margin:0;padding:0;font-size:28px;font-weight:400;color:#333;padding-bottom:5px}
.info span{color:#666;font-size:13px;margin-top:20px}
.info span a{color:#666;text-decoration:none}
.info span .fa{color:#e2a810;font-size:19px;position:relative;left:-2px}
.info span .spoilers{color:#999;margin-top:5px;font-size:10px}
</style>


<div class="card">
  <div class="top">
    <div class="payment">Card Details</div>
  </div>

  <div class="card-body">

<form action="<?=root?>payment/setmpos_payment" method="post">

<?php 
$req = $_REQUEST;
// dd($req);
// die;
?>
      <div class="one">
        <label for=''>Name on card</label>
        <input placeholder='Name on Card' name="name" type='text' required>
      </div>

      <div class="two">
        <label for=''>Card Number</label>
        <input maxlength='16' placeholder='Card Number' name="card_no" type='text' required>
      </div>

      <div class="three">
        <label for=''>Expiry Month</label>
        <select id="" name="exp_month" required>
<?php  for ($i=1; $i < 13; $i++) { 
$monthName = date("M", mktime(0, 0, 0, $i, 10)); 
$monthName_withNo = str_pad($i, 2, "0", STR_PAD_LEFT) .' '. $monthName; ?>
           <option value="<?=$i?>"><?= $monthName_withNo ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="four">
        <!-- blank character -->
        <label for=''>Expiry Year</label>
        <select id="" name="exp_year" required>
          <?php for ($i=21; $i < 31; $i++) { ?>
            <option value="<?=$i?>">20<?=$i?></option>
          <?php } ?>
        </select>
      </div>
      <div class="five">
        <label for=''>CVV</label>
        <input maxlength='3' name="cvc" placeholder='' type='' required>
      </div>
    <input name="payload" type="hidden" value="<?php echo base64_encode(json_encode($req)) ?>">
      <button class="five btn btn-success" type="submit">Continue</button>
    </form>

  </div>

<div style="display: flex; width: 100%; margin-top: 25px;  padding-top: 0px; position: relative;">
<p>All payment transactions are under the protection of DigiCert, the world’s premier provider of high-assurance digital certificates.</p>
<img src="<?=root?>app/themes/default/assets/img/secure_payment.png" style="margin-left:50px; max-width: 80px;">
</div>

</div>

<?php  });

$router->post('payment/setmpos_payment', function() {
$payload_data = json_decode(base64_decode($_POST['payload']));
$payload_decode = json_decode(base64_decode($payload_data->payload));
$payload = $payload_decode;
$invoice_url = $payload_decode->invoice_url;
$currency = $payload_decode->currency; 
$price = (int)$payload_decode->price; 
$gateway = 'setmpos';

if ($currency == "USD") { $currency_code = "US"; };
if ($currency == "TRY") { $currency_code = "TL"; };
if ($currency == "EUR") { $currency_code = "EU"; };

$mid = $payload_data->c1; //Merchant Number
$tid = $payload_data->c2; //Merchant Terminal Number
$posnetid = $payload_data->c3; //Merchant POSNET Number
$XID = '67B1730500000'.$payload->booking_id.$payload->booking_no; //Order number, 20 alphanumeric characters
$_SESSION['booking_id'] = $payload->booking_id;
$_SESSION['booking_no'] = $payload->booking_no;
$amount = $price; //12.34 TL should be set as 1234
$currencyCode = "TL"; //TL, US, EU
$installment = 00;
$tranType = 'Sale';
$cardHolderName = $_POST['name'];
$card_no = $_POST['card_no'];
$cvc = $_POST['cvc'];
$expDate = $_POST['exp_year'].$_POST['exp_month']; //25year and 12 month

$input_xml = '<?xml version="1.0" encoding="ISO-8859-9"?>
<posnetRequest>
<mid>'.$mid.'</mid>
<tid>'.$tid.'</tid>
<oosRequestData>
<posnetid>'.$posnetid.'</posnetid>
<XID>'.$XID.'</XID>
<amount>'.$amount.'</amount>
<currencyCode>'.$currencyCode.'</currencyCode>
<installment>00</installment>
<tranType>'.$tranType.'</tranType>
<cardHolderName>'.$cardHolderName.'</cardHolderName>
<ccno>'.$card_no.'</ccno>
<expDate>'.$expDate.'</expDate>
<cvc>'.$cvc.'</cvc>
</oosRequestData>
</posnetRequest>';

$url = "https://setmpos.ykb.com/PosnetWebService/XML";
$ch = curl_init();
$headers = [
    "Content-type: text/xml;charset=\"utf-8\"", 
    "Accept: text/xml", 
    // "Content-length: ".strlen($input_xml)
]; 

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url."?xmldata=" . urlencode($input_xml));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
if (curl_error($ch)) {
echo 'error:' . curl_error($ch);
}
$data = curl_exec($ch);
curl_close($ch);
// echo "<pre>"; print_r($data); exit;
$response_data = json_decode(json_encode(simplexml_load_string($data)), true);

if ($response_data['approved'] == 1) {
    $first_posnetData = $response_data['oosRequestDataResponse']['data1'];
    $second_posnetData = $response_data['oosRequestDataResponse']['data2'];
    $sign_data = $response_data['oosRequestDataResponse']['sign'];
}

if ($response_data['approved'] == 2) {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo json_encode(array(
    'msg'=>'Already Paid',
    'error'=>''
  ));
  exit();
}

if ($response_data['approved'] == 0) {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  $msg='No Result';
  echo json_encode(array(
    'msg'=>'No Result',
    'error'=>$response_data['respText']
  ));
  exit();
}

?>

<form name="PAYMENTFORM" method="post" action="https://setmpos.ykb.com/3DSWebService/YKBPaymentService">
<input name="mid" type="hidden" id="mid" value="<?=$mid?>"/>
<input name="posnetID" type="hidden" id="PosnetID" value="<?=$posnetid?>"/>
<input name="posnetData" type="hidden" id="posnetData" value="<?=$first_posnetData?>"/>
<input name="posnetData2" type="hidden" id="posnetData2" value="<?=$second_posnetData?>"/>
<input name="digest" type="hidden" id="sign" value="<?=$sign_data?>" />
<input name="vftCode" type="hidden" id="vftCode" value="" />
<input name="merchantReturnURL" type="hidden" id="merchantReturnURL" value="<?=root?>payment/make-mac-data?invoice_url=<?=$invoice_url?>" />
<input name="lang" type="hidden" id="lang" value="en" />
<input name="openANewWindow" type="hidden" id="openANewWindow" value="0" />
<!-- <input type="submit" name="Submit" value="Pay"/> -->
</form>

<?php
$body = '<a href="javascript:document.PAYMENTFORM.submit()" style="background: #5469d4;" class="pay"/>'.T::paynow.' <small> '.$currency.' </small>'.$price.'</a>';
include "app/core/pay_view.php";

});

// $router->post('payment/confirmation/(.*)', function() {
//     $url = explode('/', $_GET['url']);
//     $redirect_url = root.$url[5].'/'.$url[6].'/'.$url[7].'/'.$url[8].'/'.$url[9];
//     header('Location: '.$redirect_url);
// });

$router->post('payment/make-mac-data', function() {
// echo "<pre>"; print_r($_POST); exit;

Function hashString($originalString){
 return base64_encode(hash('sha256',$originalString,true));
 }

  $amount = str_replace("0,","",$_POST['Amount']); 
  $encKey = '10,10,10,10,10,10,10,10';
  $terminalID = '67B17305';
  $xid = $_POST['Xid'];
  $currency = 'TL';
  $merchantNo = $_POST['MerchantId'];

  $firstHash = hashString($encKey.";".$terminalID);
  $MAC = hashString($xid.";".$amount.";".$currency.";".$merchantNo.";".$firstHash);

  $mac_param = '<?xml version="1.0" encoding="ISO-8859-9"?>
  <posnetRequest>
  <mid>'.$merchantNo.'</mid>
  <tid>'.$terminalID.'</tid>
  <oosResolveMerchantData>
  <merchantData>'.$_POST['MerchantPacket'].'</merchantData>
  <bankData>'.$_POST['BankPacket'].'</bankData>
  <sign>'.$_POST['Sign'].'</sign>
  <mac>'.urlencode($MAC).'</mac>
  </oosResolveMerchantData>
  </posnetRequest>';


  $url = "https://setmpos.ykb.com/PosnetWebService/XML";
  $ch = curl_init();
  $headers = [
      "Content-type: text/xml;charset=\"utf-8\"", 
      "Accept: text/xml", 
      // "Content-length: ".strlen($input_xml)
  ];

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_URL, $url."?xmldata=".urlencode($mac_param));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  if (curl_error($ch)) {
  echo 'error:' . curl_error($ch);
  }
  $mac_data = curl_exec($ch);
  curl_close($ch);
    $mac_response_data = json_decode(json_encode(simplexml_load_string($mac_data)), true);


// echo "<pre>"; print_r($mac_response_data); exit();

if ($mac_response_data['approved'] == 0) {
  header('Location: "'.root.'"/setmpos/payment/status');
  exit();
}

if ($mac_response_data['approved'] == 1 && $mac_response_data['oosResolveMerchantDataResponse']['mdStatus'] != 1) {
  header('Location: "'.root.'"/setmpos/payment/status');
  exit();
}


if ($mac_response_data['approved'] == 1) {
$amount = $mac_response_data['oosResolveMerchantDataResponse']['amount'];
$currency = $mac_response_data['oosResolveMerchantDataResponse']['currency'];
$xid = $mac_response_data['oosResolveMerchantDataResponse']['xid'];
$txStatus = $mac_response_data['oosResolveMerchantDataResponse']['txStatus'];
$mdStatus = $mac_response_data['oosResolveMerchantDataResponse']['mdStatus'];
$mdErrorMessage = $mac_response_data['oosResolveMerchantDataResponse']['mdErrorMessage'];
$mac_ = $mac_response_data['oosResolveMerchantDataResponse']['mac'];


$oosResolveMerchant = '<?xml version="1.0" encoding="ISO-8859-9"?>
<posnetRequest>
<mid>6700972673</mid>
<tid>67B17305</tid>
<oosTranData>
<bankData>'.$_POST['BankPacket'].'</bankData>
<wpAmount>0</wpAmount>
<mac>'.urlencode($MAC).'</mac>
</oosTranData>
</posnetRequest>';


$ch = curl_init();
$headers = [
"Content-type: text/xml;charset=\"utf-8\"", 
"Accept: text/xml", 
// "Content-length: ".strlen($input_xml)
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url."?xmldata=".urlencode($oosResolveMerchant));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
if (curl_error($ch)) {
echo 'error:' . curl_error($ch);
}
$MerchantDataResponse_data = curl_exec($ch);
curl_close($ch);

$MerchantDataResponse = json_decode(json_encode(simplexml_load_string($MerchantDataResponse_data)), true);

// print_r('<pre>');
// print_r($MerchantDataResponse['approved']);
// print_r('</pre>');

  if ($MerchantDataResponse['approved'] == 1) {
    $data_approve = '?booking_id='.$_SESSION['booking_id'].'&booking_no='.$_SESSION['booking_no'].'&booking_status=confirmed&payment_status=paid&supplier_name=aerticket&payment_gateway=setmpos&amount_paid='.$amount.'&txn_id='.$xid;
    unset($_SESSION['booking_id']);
    unset($_SESSION['booking_no']);
    header('Location: '.root.'api/../flights/invoice/update'.$data_approve);
  }else{
      header('Location: '.$_GET['invoice_url']);
      // header('Location: "'.root.'"setmpos/payment/status');
  }

}

if ($mac_response_data['approved'] == 2) {
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode(array(
'msg'=>'Already Paid',
'error'=>''
));
exit();
}

if ($mac_response_data['approved'] == 0) {
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$msg='No Result';
echo json_encode(array(
'msg'=>'No Result',
'error'=>'somthing wrong!'
));
exit();
}

});

$router->get('setmpos/payment/status', function() {
echo "payment not complete, there is somthing wrong!";
});
?>