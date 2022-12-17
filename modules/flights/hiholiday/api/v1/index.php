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
/*Search*/
$router->post('/search', function() {
    //Check parameter
    if(isset($_POST['origin']) && trim($_POST['origin']) !== "") {} else { echo "origin : LHE - param or value missing "; die; }
    if(isset($_POST['destination']) && trim($_POST['destination']) !== "") {} else { echo "destination : DXB - param or value missing "; die; }
    if(isset($_POST['departure_date']) && trim($_POST['departure_date']) !== "") {} else { echo "departure_date : 10-10-2021 - param or value missing "; die; }
    if(isset($_POST['childrens']) && trim($_POST['childrens']) !== "") {} else { echo "childrens : 1 - param or value missing "; die; }
    if(isset($_POST['adults']) && trim($_POST['adults']) !== "") {} else { echo "adults : 1 - param or value missing "; die; }
    if(isset($_POST['infants']) && trim($_POST['infants']) !== "") {} else { echo "infants : 1 - param or value missing "; die; }
    if(isset($_POST['type']) && trim($_POST['type']) !== "") {} else { echo "type : oneway | return - param or value missing "; die; }
    if(isset($_POST['c1']) && trim($_POST['c1']) !== "") {} else { echo "c1 - param or value missing "; die; }
    if($_POST['type']=='round'){if(isset($_POST['return_date']) && trim($_POST['return_date']) !== "") {} else { echo "return_date : 10-10-2021 - param or value missing "; die; }}

    $departure_date = date('Y-m-d',strtotime($_POST['departure_date']));
    $return_date = date('Y-m-d',strtotime($_POST['return_date']));
    $type = $_POST['type'];

    //Define url
    if($type == 'oneway'){
        $url = 'http://api.hiholiday.ir/V4/Flight/OneWay/'.$_POST['c1'].'/'.$_POST['origin'].'/'.$_POST['destination'].'/'.$departure_date.'/1/50/1';
    }else{
        $url = 'http://api.hiholiday.ir/V4/Flight/RoundTrip/'.$_POST['c1'].'/'.$_POST['origin'].'/'.$_POST['destination'].'/'.$departure_date.'/'.$return_date.'/1/50/1';
    }

    //Call Api with curl request
    $parm =  array(
        'endpoint' => $url,
        );
    $response = sendRequest('GET', 'search', $parm);
    $main_array = json_decode($response);
    $final_array = [];
    //OneWay Flight
    if($type == 'oneway') {
        foreach ($main_array->DepartureFlights as $key => $value) {
            $segments["segments"] = array();
            $bj = (object)[
                "flight_id" => $value->FlightID,
                'departure_flight_no' => $value->FlightID,
                'img' => $value->Airline->Logo,
                'departure_time' => $value->DepartureTime,
                'departure_date' => date("d-m-Y", strtotime($value->DepartureDate)),
                'arrival_date' => date("d-m-Y", strtotime($value->DepartureDate)),
                'arrival_time' => $value->ArrivalTime,
                'departure_code' => $value->Departure->Code,
                'departure_airport' => $value->Departure->RegionName,
                'arrival_code' => $value->Arrival->Code,
                'arrival_airport' => $value->Arrival->RegionName,
                'duration_time' => '',
                'currency_code' => $_POST['currency'],
                'adult_price' => $value->AdtPrice,
                'child_price' => $value->ChdPrice,
                'infant_price' => $value->InfPrice,
                'price' => $value->AdtPrice,
                'url' => '',
                'airline_name' => $value->Airline->Name,
                'class_type' => $value->CabinType,
                'luggage' => '',
                'type' => '',
                'form' => '',
                'form_name' => '',
                'action' => '',
                'supplier' => 'hiholiday',
                "redirect" => '',
                "desc" => $value->Description,
                "booking_token" => '',
                "refundable" => '',
            ];
            $segments["segments"][0][] = $bj;
                $final_array[] = $segments;
        }
    }


    //Round Flight
    if($type == 'round'){
        foreach ($main_array->DepartureFlights as $key => $value) {
            $segments["segments"] = array();
            $bj = (object)[
                "flight_id" => $value->FlightID,
                'departure_flight_no' => $value->FlightID,
                'img' => $value->Airline->Logo,
                'departure_time' => $value->DepartureTime,
                'departure_date' => date("d-m-Y", strtotime($value->DepartureDate)),
                'arrival_date' => date("d-m-Y", strtotime($value->DepartureDate)),
                'arrival_time' => $value->ArrivalTime,
                'departure_code' => $value->Departure->Code,
                'departure_airport' => $value->Departure->RegionName,
                'arrival_code' => $value->Arrival->Code,
                'arrival_airport' => $value->Arrival->RegionName,
                'duration_time' => '',
                'currency_code' => $_POST['currency'],
                'adult_price' => $value->AdtPrice,
                'child_price' => $value->ChdPrice,
                'infant_price' => $value->InfPrice,
                'price' => $value->AdtPrice,
                'url' => '',
                'airline_name' => $value->Airline->Name,
                'class_type' => $value->CabinType,
                'luggage' => '',
                'type' => '',
                'form' => '',
                'form_name' => '',
                'action' => '',
                'supplier' => 'hiholiday',
                "redirect" => '',
                "desc" => $value->Description,
                "booking_token" => '',
                "refundable" => '',
            ];

            //Check index
            if(!empty($main_array->ReturnFlights[$key])) {
                $segments["segments"][0][] = $bj;
                $bject = (object)[
                    "flight_id" => $main_array->ReturnFlights[$key]->FlightID,
                    'departure_flight_no' => $main_array->ReturnFlights[$key]->FlightID,
                    'img' => $main_array->ReturnFlights[$key]->Airline->Logo,
                    'departure_time' => $main_array->ReturnFlights[$key]->DepartureTime,
                    'departure_date' => date("d-m-Y", strtotime($main_array->ReturnFlights[$key]->DepartureDate)),
                    'arrival_date' => date("d-m-Y", strtotime($main_array->ReturnFlights[$key]->DepartureDate)),
                    'arrival_time' => $main_array->ReturnFlights[$key]->ArrivalTime,
                    'departure_code' => $main_array->ReturnFlights[$key]->Departure->Code,
                    'departure_airport' => $main_array->ReturnFlights[$key]->Departure->RegionName,
                    'arrival_code' => $main_array->ReturnFlights[$key]->Arrival->Code,
                    'arrival_airport' => $main_array->ReturnFlights[$key]->Arrival->RegionName,
                    'duration_time' => '',
                    'currency_code' => $_POST['currency'],
                    'adult_price' => $main_array->ReturnFlights[$key]->AdtPrice,
                    'child_price' => $main_array->ReturnFlights[$key]->ChdPrice,
                    'infant_price' => $main_array->ReturnFlights[$key]->InfPrice,
                    'price' => $main_array->ReturnFlights[$key]->AdtPrice,
                    'url' => '',
                    'airline_name' => $main_array->ReturnFlights[$key]->Airline->Name,
                    'class_type' => $main_array->ReturnFlights[$key]->CabinType,
                    'luggage' => '',
                    'type' => '',
                    'form' => '',
                    'form_name' => '',
                    'action' => '',
                    'supplier' => 'hiholiday',
                    "redirect" => '',
                    "desc" => $main_array->ReturnFlights[$key]->Description,
                    "booking_token" => '',
                    "refundable" => '',
                ];
                $segments["segments"][1][] = $bject;
                $final_array[] = $segments;
            }
        }
    }
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    if (!empty($final_array)) {
        echo json_encode($final_array);
    }else{
        echo json_encode([array('msg'=>'no_result')]);
    }
});
/*booking*/
$router->post('/booking', function() {

//    if(isset($_POST['flight_id']) && trim($_POST['flight_id']) !== "") {} else { echo "flight_id : flight_id - param or value missing "; die; }
//    if(isset($_POST['c1']) && trim($_POST['c1']) !== "") {} else { echo "c1 : c1 - param or value missing "; die; }
//    if(isset($_POST['c2']) && trim($_POST['c2']) !== "") {} else { echo "c2 : c2 - param or value missing "; die; }
//    if(isset($_POST['c3']) && trim($_POST['c3']) !== "") {} else { echo "c3 : c3 - param or value missing "; die; }
//    if(isset($_POST['adults']) && trim($_POST['adults']) !== "") {} else { echo "adults : 1 - param or value missing "; die; }
//    if(isset($_POST['childs']) && trim($_POST['childs']) !== "") {} else { echo "childs : 1 - param or value missing "; die; }
//    if(isset($_POST['infants']) && trim($_POST['infants']) !== "") {} else { echo "infants : 1 - param or value missing "; die; }

    $data = json_decode($_POST['data']);
    $pessager = [];
    $pas_info = json_decode($data->booking_guest_info);
    foreach ($pas_info as $key=>$value){
        $pessager = array(
            'FirstName' =>$value->first_name,
            'LastName' =>$value->last_name,
            'PersianFirstName' =>'',
            'PersianLastName' =>'',
            'PassengerTitle' =>$value->title,
            'DateOfBirth' =>$value->dob_year .'-'.$value->dob_month.'-'.$value->dob_day,
            'PassengerType' =>'Adt',
            'NationalCode' =>1630028304,
            'PassportNumber' =>'',
            'PassportExpireDate' =>'',
            'Nationality' =>'IR',
            'AreaCode' =>'',
            'CountryCode' =>'',
            'PhoneNumber' =>'',
            'Email' =>'office@hiholiday.ir',
            'DocumentType' =>'NIC',
        );
    }
    $flight_id = json_decode($data->routes);
    $parm = array(
        'endpoint' => 'Api.HiHoliday.ir/v4/FlightRequestTest/Revalidate/'.$_POST['c1'],
        'Username'=> $_POST['c2'],
        'Password'=> $_POST['c3'],
        'FlightID'=> $flight_id[0][0]->departure_flight_no,
        'AdultCount'=> $data->booking_adults,
        'ChildCount'=> $data->booking_childs,
        'InfantCount'=> $data->booking_infants,
    );

    $revalidate = sendRequest('POST', 'search', $parm);
    $session_id = json_decode($revalidate);

    if(!empty($session_id->SessionID)){
        $par_m = array(
            'endpoint' => 'Api.HiHoliday.ir/v4/FlightRequestTest/PreReserve/'.$_POST['c1'].'/'.$session_id->SessionID,
        );
        $pre_reserve = sendRequest('POST', 'search', $par_m);
        $request_number = json_decode($pre_reserve);
        if(!empty($request_number->Request->RequestNumber)){


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'Api.HiHoliday.ir/v4/FlightRequestTest/Book/'.$_POST['c1'].'/'.$request_number->Request->RequestNumber,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '['.json_encode($pessager).']',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/plain'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $get_prn = json_decode($response);
            echo json_encode(array('status' => True,'response' => json_decode($response),'booking_prn'=>$get_prn->Request->RequestNumber, 'msg'=> 'CONFIRM'));
        }else{
            echo json_encode([array('msg'=>'RequestNumber not found')]);
        }
    }else{
        echo json_encode([array('msg'=>'SessionID not found')]);
    }
});
function dd($data) {
    echo "<pre>";
    print_r($data);
    die();
}

 function sendRequest($req_method = 'GET', $service = '', $payload = [], $_headers = [])
{
    $url = $payload['endpoint'];
    unset($payload['endpoint']);


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

    if ($req_method == 'POST') {
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
    } else {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        $url = $url."?".http_build_query($payload);
    }
    $headers[] = "cache-control: no-cache";
    if (! empty($headers) ) {
        $headers = array_merge($headers, $_headers);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }

    curl_setopt($curl, CURLOPT_URL, $url);

    $response = curl_exec( $curl );
    $err      = curl_error( $curl );

    curl_close( $curl );

    if ( $err ) {
        $response = $err;
    }

    return $response;
}

$router->dispatchGlobal();