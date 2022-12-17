<?php
namespace AppRouter;use Exception;use DateTime;use DateInterval;use InvalidArgumentException;class Router{const NO_ROUTE_FOUND_MSG='No route found';private $routes;private $error;private $baseNamespace;private $currentPrefix;private $service=null;public function __construct($error,$baseNamespace=''){$this->routes=[];$this->error=$error;$this->baseNamespace=$baseNamespace==''?'':$baseNamespace.'\\';$this->currentPrefix='';}public function setService($service){$this->service=$service;}public function getService($service){return $this->service;}public function route($method,$regex,$handler){if($method=='*'){$method=['GET','PUT','DELETE','OPTIONS','TRACE','POST','HEAD'];}foreach((array)$method as $m){$this->addRoute($m,$regex,$handler);}return $this;}private function addRoute($method,$regex,$handler){$this->routes[strtoupper($method)][$this->currentPrefix.$regex]=[$handler,$this->service];}public function mount($prefix,callable $routes,$service=false){$previousPrefix=$this->currentPrefix;$this->currentPrefix=$previousPrefix.$prefix;if($service!==false){$previousService=$this->service;$this->service=$service;}$routes($this);$this->currentPrefix=$previousPrefix;if($service!==false){$this->service=$previousService;}return $this;}public function get($regex,$handler){$this->addRoute('GET',$regex,$handler);return $this;}public function post($regex,$handler){$this->addRoute('POST',$regex,$handler);return $this;}public function put($regex,$handler){$this->addRoute('PUT',$regex,$handler);return $this;}public function head($regex,$handler){$this->addRoute('HEAD',$regex,$handler);return $this;}public function delete($regex,$handler){$this->addRoute('DELETE',$regex,$handler);return $this;}public function options($regex,$handler){$this->addRoute('OPTIONS',$regex,$handler);return $this;}public function trace($regex,$handler){$this->addRoute('TRACE',$regex,$handler);return $this;}public function connect($regex,$handler){$this->addRoute('CONNECT',$regex,$handler);return $this;}public function dispatch($method,$path){if(!isset($this->routes[$method])){$params=[$method,$path,404,new HttpRequestException(self::NO_ROUTE_FOUND_MSG)];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}else{foreach($this->routes[$method]as $regex=>$route){$len=strlen($regex);if($len>0){$callback=$route[0];$service=isset($route[1])?$route[1]:null;if($regex[0]!='/')$regex='/'.$regex;if($len>1&&$regex[$len-1]=='/')$regex=substr($regex,0,-1);$regex=str_replace('@','\\@',$regex);if(preg_match('@^'.$regex.'$@',$path,$params)){array_shift($params);try{return $this->call($callback,$service==null?$params:array_merge([$service],$params));}catch(HttpRequestException $ex){$params=[$method,$path,$ex->getCode(),$ex];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}catch(Exception $ex){$params=[$method,$path,500,$ex];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}}}}}return $this->call($this->error,array_merge($this->service==null?[]:[$this->service],[$method,$path,404,new HttpRequestException(self::NO_ROUTE_FOUND_MSG)]));}private function call($callable,array $params=[]){if(is_string($callable)){if(strlen($callable)>0){if($callable[0]=='@'){$callable=$this->baseNamespace.substr($callable,1);}}else{throw new InvalidArgumentException('Route/error callable as string must not be empty.');}$callable=str_replace('.','\\',$callable);}if(is_array($callable)){if(count($callable)!==2)throw new InvalidArgumentException('Route/error callable as array must contain and contain only two strings.');if(strlen($callable[0])>0){if($callable[0][0]=='@'){$callable[0]=$this->baseNamespace.substr($callable[0],1);}}else{throw new InvalidArgumentException('Route/error callable as array must contain and contain only two strings.');}$callable[0]=str_replace('.','\\',$callable[0]);}return call_user_func_array($callable,$params);}public function dispatchGlobal(){$pos=strpos($_SERVER['REQUEST_URI'],'?');return $this->dispatch($_SERVER['REQUEST_METHOD'],'/'.trim(substr($pos!==false?substr($_SERVER['REQUEST_URI'],0,$pos):$_SERVER['REQUEST_URI'],strlen(implode('/',array_slice(explode('/',$_SERVER['SCRIPT_NAME']),0,-1)).'/')),'/'));}}class HttpRequestException extends Exception{}

$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('root', $root);

/* 404 page init */
$router = new Router(function ($method, $path, $statusCode, $exception) {
  http_response_code($statusCode);
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  echo " Wrong Request";
});

$router->post('/search', function() {

if(isset($_POST['origin']) && trim($_POST['origin']) !== "") {} else { echo "origin : LHE - param or value missing "; die; }
if(isset($_POST['destination']) && trim($_POST['destination']) !== "") {} else { echo "destination : DXB - param or value missing "; die; }
// if(isset($_POST['return_date']) && trim($_POST['return_date']) !== "") {} else { echo "return_date : 10-10-2021 - param or value missing "; die; }
if(isset($_POST['departure_date']) && trim($_POST['origin']) !== "") {} else { echo "departure_date : 10-10-2021 - param or value missing "; die; }
if(isset($_POST['adults']) && trim($_POST['adults']) !== "") {} else { echo "adults : 1 - param or value missing "; die; }
if(isset($_POST['childrens']) && trim($_POST['childrens']) !== "") {} else { echo "childrens : 1 - param or value missing "; die; }
if(isset($_POST['infants']) && trim($_POST['infants']) !== "") {} else { echo "infants : 1 - param or value missing "; die; }
if(isset($_POST['evn']) && trim($_POST['evn']) !== "") {} else { echo "evn - param or value missing "; die; }
if(isset($_POST['currency']) && trim($_POST['currency']) !== "") {} else { echo "currency : USD - param or value missing "; die; }
if(isset($_POST['type']) && trim($_POST['type']) !== "") {} else { echo "type : oneway | return - param or value missing "; die; }
if(isset($_POST['c1']) && trim($_POST['c1']) !== "") {} else { echo "c1 - param or value missing "; die; }
if(isset($_POST['c2']) && trim($_POST['c2']) !== "") {} else { echo "c2 - param or value missing "; die; }

if (isset($_POST['evn']) && $_POST['evn'] == 'pro') {
  $end_pointv1 = 'https://apihub.aerticket-it.de/api/v1/';
}else{
  $end_pointv1 = 'https://apihub.aerticket-it.de/api/v1/';
}

$login = $_POST['c1'];
$password = $_POST['c2'];

/*flight date & time*/
$departure_y = strtoupper(date('Y',strtotime($_POST['departure_date'])));
$departure_m = strtoupper(date('m',strtotime($_POST['departure_date'])));
$departure_d = strtoupper(date('d',strtotime($_POST['departure_date'])));
$return_y= strtoupper(date('Y',strtotime($_POST['return_date'])));
$return_m = strtoupper(date('m',strtotime($_POST['return_date'])));
$return_d = strtoupper(date('d',strtotime($_POST['return_date'])));
/*end flight date & time*/

/*flight route type*/
$route_data = [];
if ($_POST['type'] == 'oneway') {
array_push($route_data,(object)array(
"departure" => array(
'iata'=>$_POST['origin'],
'geoObjectType'=>'AIRPORT'
),
"destination" => array(
'iata'=>$_POST['destination'],
'geoObjectType'=>'CITY'
),
'departureDate'=>array(
'year'=> intval($departure_y),
'month'=> intval($departure_m),
'day'=> intval($departure_d)
),
'viaExcluded'=>array(),
'viaIncluded'=>array()
));
}
if ($_POST['type'] == 'round' || $_POST['type'] == 'return') {
array_push($route_data,(object)array(
"departure" => array(
'iata'=>$_POST['origin'],
'geoObjectType'=>'AIRPORT'
),
"destination" => array(
'iata'=>$_POST['destination'],
'geoObjectType'=>'CITY'
),
'departureDate'=>array(
'year'=> intval($departure_y),
'month'=> intval($departure_m),
'day'=> intval($departure_d)
),
'viaExcluded'=>array(),
'viaIncluded'=>array()
));

array_push($route_data,(object)array(
"departure" => array(
'iata'=>$_POST['destination'],
'geoObjectType'=>'AIRPORT'
),
"destination" => array(
'iata'=>$_POST['origin'],
'geoObjectType'=>'CITY'
),
'departureDate'=>array(
'year'=> intval($return_y),
'month'=> intval($return_m),
'day'=> intval($return_d)
),
'viaExcluded'=>array(),
'viaIncluded'=>array()
));
} 
/*end flight route type*/

$total_adults = $_POST['adults'];
$total_childrens = $_POST['childrens'];
$total_infants = $_POST['infants'];

$count_total_pax = array_sum(array($total_adults, $total_childrens, $total_infants));

if($count_total_pax > 9){
  echo json_encode([array('msg'=>'no more pax than 9 for aerTicket')]);
  exit();
}

/*travelers details*/
$travelers_details = [];
if ($_POST['adults']) {
array_push($travelers_details,(object)array(
"passengerTypeCode"=> 'ADT',
"count"=> intval($total_adults),

));

}

if ($_POST['childrens']) {
array_push($travelers_details,(object)array(
"passengerTypeCode"=> 'CHD',
"count"=> intval($total_childrens),

));

}

if ($_POST['infants']) {
array_push($travelers_details,(object)array(
"passengerTypeCode"=> 'INF',
"count"=> intval($total_infants),

));
}
/*end travelers details*/

$dynamic_search_data = array(
'segmentList'=> $route_data,
'requestPassengerTypeList'=> $travelers_details,
'searchOptions'=> array(
'cabinClassList'=> array(
strtoupper($_POST['class_trip'])
),
'airlineAllianceList'=>array(),
'nonStopFlightsOnly'=>false,
'directFlightsOnly'=>false,
'includedAirlineList'=>array(),
'excludedAirlineList'=>array(),
// 'maxFares'=>3,
'fareSourceList'=>array(
array(
'id'=>'FSC_IATA'
),
array(
'id'=>'FSC_NEGO'
),
array(
'id'=>'FSC_CONSO'
),
array(
'id'=>'FSC_WEB'
),

),
'closedUserGroupTypeList'=>array(
array(
'code'=>'ALL'
)
),
'connectingTimeFilter'=>array(
'allowAirportChange'=>true
),
'needBaggage'=>false
),
);

// print_r(json_encode($dynamic_search_data)); exit();
// print_r($_POST); exit();


$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => $end_pointv1.'search',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_HEADER => true,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_INTERFACE => '190.92.156.130',
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>json_encode($dynamic_search_data),
CURLOPT_HTTPHEADER => array(
'Content-Type: application/json',
'login: '.$login.'',
'password: '.$password.''

),
));

$response = curl_exec($curl);

file_put_contents("search.txt", json_encode($response));

if(curl_errno($curl)) {
  $error_msg = curl_error($curl);
  file_put_contents("curl.txt", json_encode($error_msg));
}

list($header, $response) = explode("\r\n\r\n", $response, 2);
// print_r(json_encode($header));
// exit;

// file_put_contents('request.log', json_encode($dynamic_search_data));
// file_put_contents('response.log', $response);

curl_close($curl);
// echo $response; exit();


$decode_res = json_decode($response);


// GENERATE SEARCH LOGS
// $json = json_decode( curl_exec($curl) );
// $resp = json_encode($json, JSON_PRETTY_PRINT);
// file_put_contents("logs.txt", json_encode($header));

/*api pattren*/
$main_array = array();
$object_array = array();
$adults_price = 0;
$childrens_price = 0;
$infants_price = 0;
foreach ($decode_res->availableFareList as $key) {

foreach ($key->passengerTypeFareList as $price) {
if ($price->passengerTypeCode == 'ADT') {
$adults_price = $price->count*$price->priceList[0]->value+$price->priceList[1]->value+$price->priceList[2]->value;
}
if ($price->passengerTypeCode == 'CHD') {
$childrens_price = $price->count*$price->priceList[0]->value+$price->priceList[1]->value+$price->priceList[2]->value;
}
if ($price->passengerTypeCode == 'INF') {
$infants_price = $price->count*$price->priceList[0]->value+$price->priceList[1]->value+$price->priceList[2]->value;
}
}

foreach ($key->legList as $legList_key) {

foreach ($legList_key->itineraryList as $itineraryList_key) {
// echo "<pre>"; print_r($itineraryList_key->segmentList);
$flight_no = 0;
$test_array = array();
foreach ($itineraryList_key->segmentList as $segment) {

$departure_time = $itineraryList_key->segmentList[$flight_no]->departureTimeOfDay->hour.':'.$itineraryList_key->segmentList[$flight_no]->departureTimeOfDay->minute;
$departure_date = $itineraryList_key->segmentList[$flight_no]->departureDate->year.'-'.$itineraryList_key->segmentList[$flight_no]->departureDate->month.'-'.$itineraryList_key->segmentList[$flight_no]->departureDate->day;

$arrival_time = $itineraryList_key->segmentList[$flight_no]->arrivalTimeOfDay->hour.':'.$itineraryList_key->segmentList[$flight_no]->arrivalTimeOfDay->minute;
$arrival_date = $itineraryList_key->segmentList[$flight_no]->arrivalDate->year.'-'.$itineraryList_key->segmentList[$flight_no]->arrivalDate->month.'-'.$itineraryList_key->segmentList[$flight_no]->arrivalDate->day;

$departure_code = $itineraryList_key->segmentList[$flight_no]->departure->iata;
$departure_airport = $itineraryList_key->segmentList[$flight_no]->departure->name;

$arrival_code = $itineraryList_key->segmentList[$flight_no]->destination->iata;
$arrival_airport = $itineraryList_key->segmentList[$flight_no]->destination->name;

$airline_name = $itineraryList_key->segmentList[$flight_no]->marketingAirline->name;
$img = $itineraryList_key->segmentList[$flight_no]->marketingAirline->iata;

$oneway_id=end($legList_key->itineraryList)->id;
$return_id=end(end($key->legList)->itineraryList)->id;
if ($oneway_id == $return_id) {
$return_id = null;
}
$luggage = 0;
if ($itineraryList_key->segmentList[$flight_no]->baggageAllowance->unit == 'PC' && $itineraryList_key->segmentList[$flight_no]->baggageAllowance->quantity != 0) {
  $luggage = 'PC '. $itineraryList_key->segmentList[$flight_no]->baggageAllowance->quantity;
}else{
    $luggage = $itineraryList_key->segmentList[$flight_no]->baggageAllowance->quantity;
}
array_push($test_array, (object)array(
'departure_flight_no'=> $itineraryList_key->segmentList[$flight_no]->flightNumber,
'img'=> $root.'modules/global/resources/flights/airlines/'.$img.'.png',
'departure_time'=> date('H:i',strtotime($departure_time)),
'departure_date'=> date('d-m-Y',strtotime($departure_date)),
'arrival_time'=> date('H:i',strtotime($arrival_time)),
'arrival_date'=> date('d-m-Y',strtotime($arrival_date)),
'departure_code'=> $departure_code,
'departure_airport'=> $departure_airport,
'arrival_code'=> $arrival_code,
'arrival_airport'=> $arrival_airport,
'duration_time'=> date('H:i', mktime(0,$itineraryList_key->flyingTimeInMinutes)),
'currency_code'=> 'EUR',
'adult_price'=> number_format($adults_price),
'child_price'=> number_format($childrens_price),
'infant_price'=> number_format($infants_price),
'price'=> number_format($adults_price+$childrens_price+$infants_price),
'url'=> '',
'airline_name'=> $airline_name,
'class_type'=> $segment->cabinClass,
'luggage'=> $luggage,
'type'=> '',
'form'=> array(
'fareId'=>$key->fareId,
'oneway_id'=>$oneway_id,
'return_id'=>$return_id,
),
'form_name'=> '',
'action'=> '',
'supplier'=> 'aerticket',
));
$flight_no++; }

}
array_push($object_array, $test_array) ;
$test_array = [];
}
$main_array[]["segments"] = $object_array;
$object_array = [];
}
/*end api pattren*/
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
if (!empty($main_array)) {
echo json_encode($main_array);
}else{
echo json_encode([array('msg'=>'no_result')]);
}

});


/*Aerticket booking*/
$router->post('/booking', function() {
if (isset($_POST['evn']) && $_POST['evn'] == 'pro') {
  $end_pointv1 = 'https://apihub.aerticket-it.de/api/v1/';
}else{
  $end_pointv1 = 'https://apihub.aerticket-it.de/api/v1/';
}

$login = $_POST['c1'];
$password = $_POST['c2'];

$data = $_POST['data'];

$decode_res = json_decode($data);
// echo "<pre>"; print_r($decode_res); exit();

$booking_guest_info = json_decode($decode_res->booking_guest_info);
$routes = json_decode($decode_res->routes);
$route = $routes[0][0]->form;
// print_r($route->fareId); exit();

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


// echo "<pre>"; print_r($guests); exit();
if ($route->return_id == null) {
$verify_fare = (object)array(
'fareId'=>$route->fareId,
'itineraryIdList'=>array(
'oneway_id'=>$route->oneway_id
),
);
}else{
$verify_fare = (object)array(
'fareId'=>$route->fareId,
'itineraryIdList'=>array(
'oneway_id'=>$route->oneway_id,
'return_id'=>$route->return_id,
),
);
}

// echo json_encode($verify_fare); exit;

//aerticket verify-fare
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => $end_pointv1.'verify-fare',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_HEADER => true,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_INTERFACE => '190.92.156.130',
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>json_encode($verify_fare),
CURLOPT_HTTPHEADER => array(
'Content-Type: application/json',
'login: '.$login.'',
'password: '.$password.''

),
));

$verify_fare_res = curl_exec($curl);
file_put_contents("verify.txt", json_encode($verify_fare_res));
list($header, $verify_fare_res) = explode("\r\n\r\n", $verify_fare_res, 2);
curl_close($curl);
// echo $verify_fare_res; exit;


// GENERATE VERIFY LOGS
// $resp = json_encode($verify_fare_res, JSON_PRETTY_PRINT);
// file_put_contents("verify-logs.txt", json_encode($header));


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$verify_fareId = '';
$decode_verify_fare = json_decode($verify_fare_res);
if ($decode_verify_fare->success == 1) {
$verify_fareId = $decode_verify_fare->fare->fareId;
}else{
echo json_encode(['msg'=>'Fare expired','status' => false]); exit; 
}
//end aerticket verify-fare

//creation json request for creat-booking
$guests_res = json_decode(json_encode($guests));
$travelers = array();
$count = 1;
foreach ($guests_res as $key) {
if ($key->traveler_type == 'adults') {
array_push($travelers,(object)array(
'id'=>$count,
'lastName'=>$key->last_name,
'firstName'=>$key->first_name,
'passengerTypeCode'=>'ADT',
'dateOfBirth'=>(object)array(
'year'=>intval(strtoupper(date('Y',strtotime($key->dateofBirth)))),
'month'=>intval(strtoupper(date('m',strtotime($key->dateofBirth)))),
'day'=>intval(strtoupper(date('d',strtotime($key->dateofBirth))))
),
'gender'=>$key->gender,
'title'=>strtoupper($key->title),
'frequentFlyerNumberList'=>(object)array(),
'travelDocument'=>(object)array(
'type'=>'PASSENGER_PASSPORT',
'issuingCountry'=>(object)array(
'iso'=>'MA'),
'nationality'=>(object)array(
'iso'=>'MA'),
'number'=> 'HB7605042',
// 'number'=>$key->number,
'dateOfBirth'=>(object)array(
'year'=>intval(strtoupper(date('Y',strtotime($key->dateofBirth)))),
'month'=>intval(strtoupper(date('m',strtotime($key->dateofBirth)))),
'day'=>intval(strtoupper(date('d',strtotime($key->dateofBirth))))
),
'gender'=>$key->gender,
'expiration'=>(object)array(
  'year' => 2022,
  'month' => 05,
  'day' => 15
  // todo
  // 'year'=>intval(strtoupper(date('Y',strtotime($key->expiryDate)))),
// 'month'=>intval(strtoupper(date('m',strtotime($key->expiryDate)))),
// 'day'=>intval(strtoupper(date('d',strtotime($key->expiryDate))))
),
'lastName'=>$key->last_name,
'firstName'=>$key->first_name,
),
'priceList'=>[],
'operationalContactData'=>(object)array(
'emailAddressRefused'=>true,
'phoneNumberRefused'=>true,
'emailAddress'=>'XXXXXXX',
'phoneNumber'=>'2342345'
),
'ruleSetBookingList'=>[]
));
}elseif($key->traveler_type == 'child'){
array_push($travelers,(object)array(
'id'=>$count,
'lastName'=>$key->last_name,
'firstName'=>$key->first_name,
'passengerTypeCode'=>'CHD',
'dateOfBirth'=>(object)array(
'year'=>intval(strtoupper(date('Y',strtotime($key->dateofBirth)))),
'month'=>intval(strtoupper(date('m',strtotime($key->dateofBirth)))),
'day'=>intval(strtoupper(date('d',strtotime($key->dateofBirth))))
),
'gender'=>$key->gender,
'title'=>'CHD',
'operationalContactData'=>(object)array(
'emailAddressRefused'=>true,
'phoneNumberRefused'=>true
)
));
}else{
array_push($travelers,(object)array(
'id'=>$count,
'lastName'=>'SOFTCON',
'firstName'=>$key->first_name,
'passengerTypeCode'=>'INF',
'dateOfBirth'=>(object)array(
'year'=>intval(strtoupper(date('Y',strtotime($key->dateofBirth)))),
'month'=>intval(strtoupper(date('m',strtotime($key->dateofBirth)))),
'day'=>intval(strtoupper(date('d',strtotime($key->dateofBirth))))
),
'gender'=>$key->gender,
'title'=>'INF',
'operationalContactData'=>(object)array(
'emailAddressRefused'=>true,
'phoneNumberRefused'=>true
)
));
}
$count++;
}

$booking_query = (object)array(
'fareId'=>$verify_fareId,
'billingInformation'=>(object)array(),
'passengerList'=>$travelers,
'bookingOptions'=>(object)array(
'instantTicketOrder'=> true,
'pullRules'=> true
)
);

// echo json_encode($booking_query); exit();

// print_r($_POST); exit();
//creation json request for creat-booking

//create-booking
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => $end_pointv1.'create-booking',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_HEADER => true,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_INTERFACE => '190.92.156.130',
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>json_encode($booking_query),
CURLOPT_HTTPHEADER => array(
'Content-Type: application/json',
'login: '.$login.'',
'password: '.$password.''

),
));

$create_booking_res_pre = curl_exec($curl);
file_put_contents('booking-logs.txt', json_encode($create_booking_res_pre));
list($header, $create_booking_res) = explode("\r\n\r\n", $create_booking_res_pre, 2);
curl_close($curl);
// echo $create_booking_res; exit;

$repricing_res = json_decode($create_booking_res);
$repricing_arr = [];
if ($repricing_res->success == 1) {
$repricing_arr = [
'bookingData'=>array(
'locator'=>$repricing_res->pnr->locator
)
];

}else{
echo json_encode(['msg'=>'something wrong!','status'=>false]); exit; 
}
//end create-booking

//repricing
// $curl = curl_init();
// curl_setopt_array($curl, array(
// CURLOPT_URL => $end_pointv1.'repricing',
// CURLOPT_RETURNTRANSFER => true,
// CURLOPT_FOLLOWLOCATION => true,
// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// CURLOPT_CUSTOMREQUEST => 'POST',
// CURLOPT_POSTFIELDS =>json_encode($repricing_arr),
// CURLOPT_HTTPHEADER => array(
// 'Content-Type: application/json',
// 'login: '.$login.'',
// 'password: '.$password.''

// ),
// ));

// $repricing = curl_exec($curl);

// file_put_contents('repricing.logs', json_encode($repricing));

// curl_close($curl);
// $ticket_booking_res = json_decode($repricing);
// $ticket_booking_arr = [];
// if ($ticket_booking_res->pnr->locator) {
// $ticket_booking_arr = [
// 'bookingData'=>array(
// 'locator'=>$ticket_booking_res->pnr->locator
// )
// ];
// }else{
// echo json_encode(['msg'=>'something wrong!','status'=>false]); exit; 
// }
//end repricing

//ticket-booking
// not required when instant order is true
// $curl = curl_init();
// curl_setopt_array($curl, array(
// CURLOPT_URL => $end_pointv1.'ticket-booking',
// CURLOPT_RETURNTRANSFER => true,
// CURLOPT_HEADER => true,
// CURLOPT_FOLLOWLOCATION => true,
// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// CURLOPT_INTERFACE => '190.92.156.130',
// CURLOPT_CUSTOMREQUEST => 'POST',
// CURLOPT_POSTFIELDS =>json_encode($repricing_arr),
// // CURLOPT_POSTFIELDS =>json_encode($ticket_booking_arr),
// CURLOPT_HTTPHEADER => array(
// 'Content-Type: application/json',
// 'login: '.$login.'',
// 'password: '.$password.''

// ),
// ));


// $booking_resurlt_x = curl_exec($curl);
// list($header, $booking_resurlt) = explode("\r\n\r\n", $booking_resurlt_x, 2);
// file_put_contents('ticket-booking.txt', json_encode($booking_resurlt_x));

// curl_close($curl);
// echo $booking_resurlt;
//end ticket-booking
});
/*End Aerticket booking*/
$router->dispatchGlobal();