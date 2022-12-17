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

// if(isset($_POST['origin']) && trim($_POST['origin']) !== "") {} else { echo "origin : LHE - param or value missing "; die; }
// if(isset($_POST['destination']) && trim($_POST['destination']) !== "") {} else { echo "destination : DXB - param or value missing "; die; }
// // if(isset($_POST['return_date']) && trim($_POST['return_date']) !== "") {} else { echo "return_date : 10-10-2021 - param or value missing "; die; }
// if(isset($_POST['departure_date']) && trim($_POST['origin']) !== "") {} else { echo "departure_date : 10-10-2021 - param or value missing "; die; }
// if(isset($_POST['adults']) && trim($_POST['adults']) !== "") {} else { echo "adults : 1 - param or value missing "; die; }
// if(isset($_POST['childrens']) && trim($_POST['childrens']) !== "") {} else { echo "childrens : 1 - param or value missing "; die; }
// if(isset($_POST['infants']) && trim($_POST['infants']) !== "") {} else { echo "infants : 1 - param or value missing "; die; }
// // if(isset($_POST['evn']) && trim($_POST['evn']) !== "") {} else { echo "evn - param or value missing "; die; }
// if(isset($_POST['currency']) && trim($_POST['currency']) !== "") {} else { echo "currency : USD - param or value missing "; die; }
// if(isset($_POST['type']) && trim($_POST['type']) !== "") {} else { echo "type : oneway | return - param or value missing "; die; }
// if(isset($_POST['c1']) && trim($_POST['c1']) !== "") {} else { echo "c1 - param or value missing "; die; }
// if(isset($_POST['c2']) && trim($_POST['c2']) !== "") {} else { echo "c2 - param or value missing "; die; }
// if(isset($_POST['c3']) && trim($_POST['c3']) !== "") {} else { echo "c3 - param or value missing "; die; }

if (isset($_POST['evn']) && $_POST['evn'] == 'pro') {
  $end_pointv1 = 'https://api.example.com/';
  $end_pointv2 = 'https://api.example.com/';
}else{
  $end_pointv1 = 'https://test.example.com/';
  $end_pointv2 = 'https://test.example.com/';
}

// CREDENTIALS
$c1 = $_POST['c1'];
$c2 = $_POST['c2'];
$c3 = $_POST['c3'];

// HEADERS
$header = $c2.':'.$c3;

// DATES
$checkin = date("Y-m-d", strtotime($_POST['checkin']));
$checkout = date("Y-m-d", strtotime($_POST['checkout']));

// ENV
define ('ENVIRONMENT', 'production');

// DATABSE
include('../../../../../config.php');

$servername = $db['default']['hostname'];
$username = $db['default']['username'];
$password = $db['default']['password'];
$db_name = $db['default']['database'];

$conn = new \MySQLi($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

// GET CITY ID FROM DATABSE
$city = $conn->query("SELECT * FROM `_modules_hotels_agoda` WHERE `city` = '".$_POST['city']."' LIMIT 1")->fetch_object();

if (isset($city->city_id)) { $cityId = $city->city_id; } else { $cityId = ''; }

// echo $city->city_id;
// die;

// print_r($cityID);
// die;
// // echo implode(" ",$city->city_id);
// // echo $city_id;
// die;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $c1,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPHEADER => 'Authorization: "'.$c2.'":"'.$c3.'"',
  CURLOPT_HTTPHEADER => 'Content-Type: application/json',
  CURLOPT_HTTPHEADER => 'Accept-Encoding: gzip, deflate, br',
  CURLOPT_HTTPHEADER => 'Connection: keep-alive',
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
 "criteria": {
 "additional": {
 "currency": "'.$_POST['currency'].'",
 "dailyRate": {
 "maximum": 10000,
 "minimum": 1
 },
 "discountOnly": false,
 "language": "en-us",
 "maxResult": 500,
 "minimumReviewScore": 0,
 "minimumStarRating": 0,
 "occupancy": {
 "numberOfAdult": 2,
 "numberOfChildren": 1
 },
 "sortBy": "PriceAsc"
 },
 "checkInDate": "'.$checkin.'",
 "checkOutDate": "'.$checkout.'",
 "cityId": '.$cityId.'
 }
}',
  CURLOPT_HTTPHEADER => array(
    "Authorization: ".$header,
    'Content-Type: application/json'
  ),
));

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$response = curl_exec($curl);
curl_close($curl);

$resp = json_decode($response, true);

if (!empty($resp['error'])) {
    echo "no_result";
    die;
}

$data = $resp['results'];

//  print_r(json_encode($resp['results']));

 $arry = [];
  foreach ($data as $key) {

   // $adrs = $conn->query("SELECT * FROM `_modules_hotels_agoda` WHERE `hotel_id` = '".$key['hotelId']."'");

    $arry[] = (object)[
        'hotel_id'=> $key['hotelId'],
        'name'=> $key['hotelName'],
        'img'=> $key['imageURL'],
        'stars'=> $key['starRating'],
        'rating'=> $key['reviewScore'],
        'latitude'=> $key['latitude'],
        'longitude'=> $key['longitude'],
        'price'=> $key['dailyRate'],
        'actual_price'=> $key['dailyRate'],
        'currency'=> $key['currency'],
        'redirect'=> $key['landingURL'],
        'city_code'=> $city->city_id,
        'country_code'=> '',
        'address'=> '', //$_POST['city'],
        'discount'=> '',
        'amenities'=> '',
    ];
}
if (!empty($arry)) {
  echo json_encode($arry);
 }else{
  echo json_encode([array('msg'=>'no_result')]);
 }

});

$router->dispatchGlobal();