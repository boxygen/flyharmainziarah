<?php

namespace AppRouter;use Exception;use DateTime;use DateInterval;use InvalidArgumentException;class Router{const NO_ROUTE_FOUND_MSG='No route found';private $routes;private $error;private $baseNamespace;private $currentPrefix;private $service=null;public function __construct($error,$baseNamespace=''){$this->routes=[];$this->error=$error;$this->baseNamespace=$baseNamespace==''?'':$baseNamespace.'\\';$this->currentPrefix='';}public function setService($service){$this->service=$service;}public function getService($service){return $this->service;}public function route($method,$regex,$handler){if($method=='*'){$method=['GET','PUT','DELETE','OPTIONS','TRACE','POST','HEAD'];}foreach((array)$method as $m){$this->addRoute($m,$regex,$handler);}return $this;}private function addRoute($method,$regex,$handler){$this->routes[strtoupper($method)][$this->currentPrefix.$regex]=[$handler,$this->service];}public function mount($prefix,callable $routes,$service=false){$previousPrefix=$this->currentPrefix;$this->currentPrefix=$previousPrefix.$prefix;if($service!==false){$previousService=$this->service;$this->service=$service;}$routes($this);$this->currentPrefix=$previousPrefix;if($service!==false){$this->service=$previousService;}return $this;}public function get($regex,$handler){$this->addRoute('GET',$regex,$handler);return $this;}public function post($regex,$handler){$this->addRoute('POST',$regex,$handler);return $this;}public function put($regex,$handler){$this->addRoute('PUT',$regex,$handler);return $this;}public function head($regex,$handler){$this->addRoute('HEAD',$regex,$handler);return $this;}public function delete($regex,$handler){$this->addRoute('DELETE',$regex,$handler);return $this;}public function options($regex,$handler){$this->addRoute('OPTIONS',$regex,$handler);return $this;}public function trace($regex,$handler){$this->addRoute('TRACE',$regex,$handler);return $this;}public function connect($regex,$handler){$this->addRoute('CONNECT',$regex,$handler);return $this;}public function dispatch($method,$path){if(!isset($this->routes[$method])){$params=[$method,$path,404,new HttpRequestException(self::NO_ROUTE_FOUND_MSG)];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}else{foreach($this->routes[$method]as $regex=>$route){$len=strlen($regex);if($len>0){$callback=$route[0];$service=isset($route[1])?$route[1]:null;if($regex[0]!='/')$regex='/'.$regex;if($len>1&&$regex[$len-1]=='/')$regex=substr($regex,0,-1);$regex=str_replace('@','\\@',$regex);if(preg_match('@^'.$regex.'$@',$path,$params)){array_shift($params);try{return $this->call($callback,$service==null?$params:array_merge([$service],$params));}catch(HttpRequestException $ex){$params=[$method,$path,$ex->getCode(),$ex];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}catch(Exception $ex){$params=[$method,$path,500,$ex];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}}}}}return $this->call($this->error,array_merge($this->service==null?[]:[$this->service],[$method,$path,404,new HttpRequestException(self::NO_ROUTE_FOUND_MSG)]));}private function call($callable,array $params=[]){if(is_string($callable)){if(strlen($callable)>0){if($callable[0]=='@'){$callable=$this->baseNamespace.substr($callable,1);}}else{throw new InvalidArgumentException('Route/error callable as string must not be empty.');}$callable=str_replace('.','\\',$callable);}if(is_array($callable)){if(count($callable)!==2)throw new InvalidArgumentException('Route/error callable as array must contain and contain only two strings.');if(strlen($callable[0])>0){if($callable[0][0]=='@'){$callable[0]=$this->baseNamespace.substr($callable[0],1);}}else{throw new InvalidArgumentException('Route/error callable as array must contain and contain only two strings.');}$callable[0]=str_replace('.','\\',$callable[0]);}return call_user_func_array($callable,$params);}public function dispatchGlobal(){$pos=strpos($_SERVER['REQUEST_URI'],'?');return $this->dispatch($_SERVER['REQUEST_METHOD'],'/'.trim(substr($pos!==false?substr($_SERVER['REQUEST_URI'],0,$pos):$_SERVER['REQUEST_URI'],strlen(implode('/',array_slice(explode('/',$_SERVER['SCRIPT_NAME']),0,-1)).'/')),'/'));}}class HttpRequestException extends Exception{}

$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('root', $root);
//use AppRouter\Router;

/* 404 page init */
$router = new Router(function ($method, $path, $statusCode, $exception) {
http_response_code($statusCode);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo " Wrong Request";
});

$router->get('/', function() { ?>

<link rel="stylesheet" href="https://raw.githack.com/qaxim/material/main/assets/css/style.css" />
<form method="post" action="search" target>
<div class="container mt-5 card">
<h2><strong>Amadeus Flights Search</strong></h2>
<hr>
<label><strong>Endpoint</strong><label>
<?=root?>search method POST
<hr>

<div class="row g-2">

  <div class="col-md-1">
  <label class="filled w100">
  <input type="text" value="DXB" placeholder=" " name="origin">
  <span>origin</span>
  </label>
  </div>

  <div class="col-md-1">
  <label class="filled w100">
  <input type="text" value="KUL" placeholder=" " name="destination">
  <span>destination</span>
  </label>
  </div>

  <div class="col-md-3">
  <div class="row g-2">

  <div class="col-md-6">
  <label class="filled w100">
  <input type="text" value="<?=date('d-m-Y',strtotime('+10 day'))?>" placeholder=" " name="departure_date">
  <span>departure_date</span>
  </label>
  </div>

  <div class="col-md-6">
  <label class="filled w100">
  <input type="text" value="<?=date('d-m-Y',strtotime('+12 day'))?>" placeholder=" " name="return_date">
  <span>return_date</span>
  </label>
  </div>

  </div>
  </div>

  <div class="col-md-1">
  <label class="filled w100">
  <input type="text" value="1" placeholder=" " name="adults">
  <span>adults</span>
  </label>
  </div>

  <div class="col-md-1">
  <label class="filled w100">
  <input type="text" value="1" placeholder=" " name="childrens">
  <span>childrens</span>
  </label>
  </div>

  <div class="col-md-1">
  <label class="filled w100">
  <input type="text" value="0" placeholder=" " name="infants">
  <span>infants</span>
  </label>
  </div>

  <div class="col-md-1">
  <label class="filled w100">
  <input type="text" value="USD" placeholder=" " name="currency">
  <span>currency</span>
  </label>
  </div>

  <div class="col-md-2">
  <label class="filled w100">
  <select name="type">
  <option value="oneway">oneway</option>
  <option value="return">return</option>
  </select>
  <span></span>
  </label>
  </div>

  <div class="col-md-2">
  <label class="filled w100">
  <select name="class_trip">
  <option value="ECONOMY">economy</option>
  </select>
  <span></span>
  </label>
  </div>

  <div class="col-md-1">
  <label class="filled w100">
  <select name="evn">
  <option value="dev" selected>dev</option>
  <option value="pro">pro</option>
  </select>
  <span></span>
  </label>
  </div>

  <div class="col-md-2 df">
  <button class="btn w100" type="submit" onclick="loading()" style="height:62px">Search</button><br>
  </div>

  <div class="row g-1">
    <hr class="my-3">

  <div class="col-md-4">
  <label class="filled w100">
  <input type="text" value="client_credentials" placeholder=" " name="c1">
  <span>c1</span>
  </label>
  </div>

  <div class="col-md-4">
  <label class="filled w100">
  <input type="text" value="B9wRGKqW9KitLGURs3hF3KEGlsOSs2rr" placeholder=" " name="c2">
  <span>c2</span>
  </label>
  </div>

  <div class="col-md-4">
  <label class="filled w100">
  <input type="text" value="sMiP1tjGFDDyeTyD" placeholder=" " name="c3">
  <span>c3</span>
  </label>
  </div>

  <progress id="loading" style="display:none" class="linear mt-3"></progress>
<script>
function loading() { document.getElementById("loading").style.display = "block";}
</script>
</div>
</div>
</div>

</form>

<?php  });

$router->post('/search', function() {

if(isset($_POST['origin']) && trim($_POST['origin']) !== "") {} else { echo "origin : LHE - param or value missing "; die; }
if(isset($_POST['destination']) && trim($_POST['destination']) !== "") {} else { echo "destination : DXB - param or value missing "; die; }
// if(isset($_POST['return_date']) && trim($_POST['return_date']) !== "") {} else { echo "return_date : 10-10-2021 - param or value missing "; die; }
if(isset($_POST['departure_date']) && trim($_POST['origin']) !== "") {} else { echo "departure_date : 10-10-2021 - param or value missing "; die; }
if(isset($_POST['adults']) && trim($_POST['adults']) !== "") {} else { echo "adults : 1 - param or value missing "; die; }
if(isset($_POST['childrens']) && trim($_POST['childrens']) !== "") {} else { echo "childrens : 1 - param or value missing "; die; }
if(isset($_POST['infants']) && trim($_POST['infants']) !== "") {} else { echo "infants : 1 - param or value missing "; die; }
// if(isset($_POST['evn']) && trim($_POST['evn']) !== "") {} else { echo "evn - param or value missing "; die; }
if(isset($_POST['currency']) && trim($_POST['currency']) !== "") {} else { echo "currency : USD - param or value missing "; die; }
if(isset($_POST['type']) && trim($_POST['type']) !== "") {} else { echo "type : oneway | return - param or value missing "; die; }
if(isset($_POST['c1']) && trim($_POST['c1']) !== "") {} else { echo "c1 - param or value missing "; die; }
if(isset($_POST['c2']) && trim($_POST['c2']) !== "") {} else { echo "c2 - param or value missing "; die; }
if(isset($_POST['c3']) && trim($_POST['c3']) !== "") {} else { echo "c3 - param or value missing "; die; }

if (isset($_POST['evn']) && $_POST['evn'] == 'pro') {
  $end_pointv1 = 'https://api.amadeus.com/v1/';
  $end_pointv2 = 'https://api.amadeus.com/v2/';
}else{
  $end_pointv1 = 'https://test.api.amadeus.com/v1/';
  $end_pointv2 = 'https://test.api.amadeus.com/v2/';
}

$c1 = $_POST['c1'];
$c2 = $_POST['c2'];
$c3 = $_POST['c3'];

// echo $c2; exit;
/*flight date & time*/
$departureDate = strtoupper(date('Y-m-d',strtotime($_POST['departure_date'])));
$departureTime = strtoupper(date('h:i:s',strtotime($_POST['departure_date'])));
$returnDate = strtoupper(date('Y-m-d',strtotime($_POST['return_date'])));
$returnTime = strtoupper(date('h:i:s',strtotime($_POST['return_date'])));
/*end flight date & time*/

/*flight route type*/
$route_data = [];
if ($_POST['type'] == 'oneway') {
    array_push($route_data,(object)array(
            "id"=> "1",
            "originLocationCode"=> strtoupper($_POST['origin']),
            "destinationLocationCode"=> strtoupper($_POST['destination']),
            "departureDateTimeRange"=> array(
                'date'=> $departureDate,
                'time'=> $departureTime
            ),
        ));
}
if ($_POST['type'] == 'round' || $_POST['type'] == 'return') {
    array_push($route_data,(object)array(
            "id"=> "1",
            "originLocationCode"=> strtoupper($_POST['origin']),
            "destinationLocationCode"=> strtoupper($_POST['destination']),
            "departureDateTimeRange"=> array(
                'date'=> $departureDate,
                'time'=> $departureTime
            ),

        ));

    array_push($route_data,(object)array(
            "id"=> "2",
            "originLocationCode"=> strtoupper($_POST['destination']),
            "destinationLocationCode"=> strtoupper($_POST['origin']),
            "departureDateTimeRange"=> array(
                'date'=> $returnDate,
                'time'=> $returnTime
            ),
        ));
}
/*end flight route type*/

$total_adults = $_POST['adults'];
$total_childrens = $_POST['childrens'];
$total_infants = $_POST['infants'];
/*travelers details*/
$travelers_details = [];
if ($_POST['adults']) {
    for ($i=1; $i < $_POST['adults']+1; $i++) {
        array_push($travelers_details,(object)array(
            "id"=> $i,
            "travelerType"=> 'ADULT',
            "fareOptions"=> array('STANDARD'),

        ));
    }

}

if ($_POST['childrens']) {
    for ($i=1; $i < $_POST['childrens']+1; $i++) {
        array_push($travelers_details,(object)array(
            "id"=> $i+$_POST['adults'],
            "travelerType"=> 'CHILD',
            "fareOptions"=> array('STANDARD'),

        ));
    }

}

if ($_POST['infants']) {
    for ($i=1; $i < $_POST['infants']+1; $i++) {
        array_push($travelers_details,(object)array(
            "id"=> $i+$_POST['adults']+$_POST['childrens'],
            "travelerType"=> 'SEATED_INFANT',
            "fareOptions"=> array('STANDARD'),

        ));
    }

}
/*end travelers details*/

$dynamic_search_data = array(
        'currencyCode'=> strtoupper($_POST['currency']),
        'originDestinations'=>$route_data,
        'travelers'=>$travelers_details,
        'sources'=>array('GDS'),
        'searchCriteria'=>(object)array(
            'maxFlightOffers'=>100,
            'flightFilters'=>(object)array(
                'cabinRestrictions'=>array(
                    (object)array(
                        'cabin'=>strtoupper($_POST['class_trip']),
                        'coverage'=>'MOST_SEGMENTS',
                        'originDestinationIds'=>array('1')
                    )
                ),
                'carrierRestrictions'=>(object)array(
                    'excludedCarrierCodes'=>array(
                        'AA',
                        'TP',
                        'AZ'
                    )
                )

            )
        ),
    );



// echo json_encode($dynamic_search_data);
// exit();
/*token api*/
$curls = curl_init();
curl_setopt($curls, CURLOPT_URL, $end_pointv1.'security/oauth2/token');
curl_setopt($curls, CURLOPT_POST, true);
curl_setopt($curls, CURLOPT_POSTFIELDS, "grant_type=".$c1."&client_id=".$c2."&client_secret=".$c3);
curl_setopt($curls, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($curls, CURLOPT_RETURNTRANSFER, true);
$token = curl_exec($curls);
$data = json_decode($token,true);
// echo $token; exit;
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
if (!empty($data)) {
$data = json_decode($token,true);
}else{
  echo json_encode([array('msg'=>'no_result')]); exit;
}

if (isset($data['access_token'])) { } else { echo json_encode([array('msg'=>'wrong_credentials')]); die; }

/*flights searching*/
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => $end_pointv2.'shopping/flight-offers',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>json_encode($dynamic_search_data),
CURLOPT_HTTPHEADER => array(
'Content-Type: application/json',
'Authorization: Bearer ' .$data['access_token']
),
));

$result = curl_exec($curl);
curl_close($curl);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// echo "<pre>";
// print_r(json_decode($result));
// print_r($result);
// exit;
/*api pattren*/
$main_array = array();
$object_array = array();
foreach (json_decode($result)->data as $key) {
            // echo "<pre>"; print_r($key); exit();
    if (!empty($key->price->currency)) {
          $currency_code = $key->price->currency;
        }else{$currency_code = ''; }

// echo "<pre>"; print_r($key->travelerPricings); exit();

    foreach ($key->itineraries as $kee => $value) {
        $test_array = array();
     foreach ($value->segments as $seg2) {
        $adult_price = 0;
        $child_price = 0;
        $infant_price = 0;
        $bags = '';
        $class_type = '';
        foreach ($key->travelerPricings as $travelerPricings) {
            if ($travelerPricings->travelerType == 'ADULT') {
                    $adult_price = $travelerPricings->price->total;
            $class_type = $travelerPricings->fareDetailsBySegment[0]->cabin;

if (isset($travelerPricings->fareDetailsBySegment[0]->includedCheckedBags->weight)){
$bags = $travelerPricings->fareDetailsBySegment[0]->includedCheckedBags->weight;
}else{
    $bags = 0;
}
            }if ($travelerPricings->travelerType == 'CHILD') {
                    $child_price = $travelerPricings->price->total;
            $class_type = $travelerPricings->fareDetailsBySegment[0]->cabin;
            }if ($travelerPricings->travelerType == 'SEATED_INFANT') {
                    $infant_price = $travelerPricings->price->total;
            $class_type = $travelerPricings->fareDetailsBySegment[0]->cabin;
            }
        }
        // echo $seg2->duration; exit();
          $start = new DateTime('@0');
          $start->add(new DateInterval($seg2->duration));
          $duration_time = $start->format('H:i');
            array_push($test_array, (object)array(
              'departure_flight_no'=> $seg2->aircraft->code,
              'img'=> './modules/global/resources/flights/airlines/'.$seg2->carrierCode.'.png',
              'departure_time'=> date('H:i',strtotime($seg2->departure->at)),
              'departure_date'=> date('d-m-Y',strtotime($seg2->departure->at)),
              'arrival_date'=> date('d-m-Y',strtotime($seg2->arrival->at)),
              'arrival_time'=> date('H:i',strtotime($seg2->arrival->at)),
              'departure_code'=> $seg2->departure->iataCode,
              'departure_airport'=> $seg2->departure->iataCode,
              'arrival_code'=> $seg2->arrival->iataCode,
              'arrival_airport'=> $seg2->arrival->iataCode,
              'duration_time'=> $duration_time,
              'currency_code'=> $currency_code,
              'adult_price'=> number_format($adult_price*$total_adults),
              'child_price'=> number_format($child_price*$total_childrens),
              'infant_price'=> number_format($infant_price*$total_infants),
              'price'=> number_format($key->price->total),
              'url'=> '',
              'airline_name'=> $seg2->carrierCode,
              'class_type'=> $class_type,
              'luggage'=> $bags,
              'type'=> '',
              'form'=> array($key),
              // 'form'=> '',
              'form_name'=> '',
              'action'=> '',
              'supplier'=> 'amadeus',
            ));
          }
    array_push($object_array, $test_array) ;
            $test_array = [];
    }
    $main_array[]["segments"] = $object_array;
    $object_array = [];
}
/*end new api pattren*/
if (!empty($main_array)) {
  echo json_encode($main_array);
}else{
  echo json_encode([array('msg'=>'no_result')]);
}

});
/*flights search api end*/



/*flights booking api start*/
$router->post('/booking', function() {
if (isset($_POST['evn']) &&  $_POST['evn'] == 'pro') {
  $end_pointv1 = 'https://api.amadeus.com/v1/';
  $end_pointv2 = 'https://api.amadeus.com/v2/';
}else{
  $end_pointv1 = 'https://test.api.amadeus.com/v1/';
  $end_pointv2 = 'https://test.api.amadeus.com/v2/';
}


$c1 = $_POST['c1'];
$c2 = $_POST['c2'];
$c3 = $_POST['c3'];
$data = $_POST['data'];
$decode_res = json_decode($data);
$booking_guest_info = json_decode($decode_res->booking_guest_info);
$routes = json_decode($decode_res->routes);
$booking_flight_data = $routes[0][0]->form;

// echo "<pre>"; print_r($booking_flight_data); exit();
$travelers_information = array();
$guests = [];
foreach ($booking_guest_info as $key) {
if ($key->title == 'Mr') {$gender = 'MALE';}else{$gender = 'FEMALE';}
array_push($guests,array(
"traveler_type"=> $key->traveller_type,
"title"=> $key->title,
"first_name"=> $key->first_name,
"last_name"=> $key->last_name,
"dateofBirth"=> date('Y-m-d', strtotime($key->dob_year.'-'.$key->dob_month.'-'.$key->dob_day)),
"gender"=> $gender,
"email"=> $decode_res->accounts_email,
"calling_code"=> 34,
"number"=> $decode_res->ai_mobile,
"documentType"=> "PASSPORT",
"birthPlace"=> "Madrid",
"issuanceLocation"=> "Madrid",
"issuanceDate"=> date('Y-m-d', strtotime($key->passport_issuance_year.'-'.$key->passport_issuance_month.'-'.$key->passport_issuance_day)),
"expiryDate"=> date('Y-m-d', strtotime($key->passport_year.'-'.$key->passport_month.'-'.$key->passport_day)),
"issuanceCountry"=> "ES",
"validityCountry"=> "ES",
"nationality"=> "ES",
"holder"=> true
));
}

$travelers_information[] = array(
"first_name"=> $decode_res->ai_first_name,
"last_name"=> $decode_res->ai_last_name,
"companyName"=> "PHPTRAVELS",
"countryCallingCode"=> 34,
"number"=> $decode_res->ai_mobile,
"emailAddress"=> $decode_res->accounts_email,
"address"=> "70 Crown Street, LONDON",
"postalCode"=> "28014",
"cityName"=> 'Madrid',
"countryCode"=> 'ES',
"traveler_information"=>$guests
);

$travelers = array();
$count = 1;
    foreach ((object)$travelers_information[0]['traveler_information'] as $key) {
            if ($key['traveler_type'] == 'adults') {
                array_push($travelers,(object)array(
                    'id'=>$count,
                    'dateOfBirth'=>$key['dateofBirth'],
                    'name'=>(object)array(
                        'firstName'=>$key['first_name'],
                        'lastName'=>$key['last_name']
                    ),
                    'gender'=>$key['gender'],
                    'contact'=>(object)array(
                        'emailAddress'=>$key['email'],
                        'phones'=>array((object)array(
                            'deviceType'=>'MOBILE',
                            'countryCallingCode'=>$key['calling_code'],
                            'number'=>$key['number']
                        )),
                    ),
                    'documents'=>array((object)array(
                        'documentType'=> $key['documentType'],
                        'birthPlace'=> $key['birthPlace'],
                        'issuanceLocation'=> $key['issuanceLocation'],
                        'issuanceDate'=> $key['issuanceDate'],
                        'number'=> $key['number'],
                        'expiryDate'=> $key['expiryDate'],
                        'issuanceCountry'=> $key['issuanceCountry'],
                        'validityCountry'=> $key['validityCountry'],
                        'nationality'=> $key['nationality'],
                        'holder'=> $key['holder']
                    ))
                ));
            }elseif($key['traveler_type'] == 'child'){
                array_push($travelers,(object)array(
                    'id'=>$count,
                    'dateOfBirth'=>$key['dateofBirth'],
                    'name'=>(object)array(
                        'firstName'=>$key['first_name'],
                        'lastName'=>$key['last_name']
                    ),
                    'gender'=>$key['gender'],
                    'contact'=>(object)array(
                        'emailAddress'=>$key['email'],
                        'phones'=>array((object)array(
                            'deviceType'=>'MOBILE',
                            'countryCallingCode'=>$key['calling_code'],
                            'number'=>$key['number']
                        )),
                    )
                ));
            }else{
                array_push($travelers,(object)array(
                    'id'=>$count,
                    'dateOfBirth'=>$key['dateofBirth'],
                    'name'=>(object)array(
                        'firstName'=>$key['first_name'],
                        'lastName'=>$key['last_name']
                    ),
                    'gender'=>$key['gender'],
                    'contact'=>(object)array(
                        'emailAddress'=>$key['email'],
                        'phones'=>array((object)array(
                            'deviceType'=>'MOBILE',
                            'countryCallingCode'=>$key['calling_code'],
                            'number'=>$key['number']
                        )),
                    )
                ));
            }
        $count++;
    }
    // echo "<pre>"; print_r(); exit();
    $booking_query = (object)array(
        'data'=>(object)array(
            'type'=>'flight-order',
            'flightOffers'=>$booking_flight_data,
            'travelers'=>$travelers,
            'remarks'=>(object)array(
                'general'=>array((object)array(
                    'subType'=>'GENERAL_MISCELLANEOUS',
                    'text'=>'ONLINE BOOKING FROM INCREIBLE VIAJES'
                    )
                )
            ),
            'ticketingAgreement'=>(object)array(
                'option'=>'CONFIRM',
                'delay'=>'6D',
            ),
            'contacts'=>array((object)array(
                'addresseeName'=>(object)array(
                    'firstName'=>$travelers_information[0]['first_name'],
                    'lastName'=>$travelers_information[0]['last_name']
                ),
                'companyName'=>$travelers_information[0]['companyName'],
                'purpose'=>'STANDARD',
                'phones'=>array((object)array(
                    'deviceType'=>'LANDLINE',
                    'countryCallingCode'=>$travelers_information[0]['countryCallingCode'],
                    'number'=>$travelers_information[0]['number']
                ),(object)array(
                    'deviceType'=>'MOBILE',
                    'countryCallingCode'=>$travelers_information[0]['countryCallingCode'],
                    'number'=>$travelers_information[0]['number']
                )
                ),
                'emailAddress'=>$travelers_information[0]['emailAddress'],
                'address'=>(object)array(
                    'lines'=>array(
                        $travelers_information[0]['address']
                    ),
                    'postalCode'=>$travelers_information[0]['postalCode'],
                    'cityName'=>$travelers_information[0]['cityName'],
                    'countryCode'=>$travelers_information[0]['countryCode']
                ),
            ))
        )
    );
    // echo "<pre>"; print_r(json_encode($booking_query)); exit;



$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://test.api.amadeus.com/v1/security/oauth2/token',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>'grant_type='.$c1.'&client_id='.$c2.'&client_secret='.$c3,
CURLOPT_HTTPHEADER => array(
'Content-Type: application/x-www-form-urlencoded'
),
));

$response = curl_exec($curl);
$api_token = json_decode($response,true);
curl_close($curl);


$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => $end_pointv1.'booking/flight-orders',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>json_encode($booking_query),
CURLOPT_HTTPHEADER => array(
'Content-Type: application/json',
'Authorization: Bearer ' .$api_token['access_token']
),
));

$order_res = curl_exec($curl);
curl_close($curl);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$pnr = (json_decode($order_res)->data->id);
// echo "<pre>"; print_r($order_res); exit;

/*end order api*/
if (!empty($order_res)) {
    $decode_booking_res = json_decode($order_res);
    if (isset($decode_booking_res->errors)) {
        echo json_encode(array('status' => True,'response' => json_decode($order_res), 'booking_pnr' => $pnr, 'msg'=> 'INVALID DATA RECEIVED'));
    }else{
        echo json_encode(array('status' => True,'response' => json_decode($order_res), 'booking_pnr' => $pnr, 'msg'=> 'CONFIRM'));
    }
}else{
    echo json_encode(array('status' => False,'response' => 0, 'msg'=> 'something is worng please check your request'));
}
 // echo"<pre>"; print_r(($decode_booking_res->errors)); exit();

});
/*flights booking api end*/

$router->dispatchGlobal();