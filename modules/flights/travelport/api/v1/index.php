<?php

namespace AppRouter;use DOMDocument;use stdClass;use Exception;use DateTime;use DateInterval;use InvalidArgumentException;class Router{const NO_ROUTE_FOUND_MSG='No route found';private $routes;private $error;private $baseNamespace;private $currentPrefix;private $service=null;public function __construct($error,$baseNamespace=''){$this->routes=[];$this->error=$error;$this->baseNamespace=$baseNamespace==''?'':$baseNamespace.'\\';$this->currentPrefix='';}public function setService($service){$this->service=$service;}public function getService($service){return $this->service;}public function route($method,$regex,$handler){if($method=='*'){$method=['GET','PUT','DELETE','OPTIONS','TRACE','POST','HEAD'];}foreach((array)$method as $m){$this->addRoute($m,$regex,$handler);}return $this;}private function addRoute($method,$regex,$handler){$this->routes[strtoupper($method)][$this->currentPrefix.$regex]=[$handler,$this->service];}public function mount($prefix,callable $routes,$service=false){$previousPrefix=$this->currentPrefix;$this->currentPrefix=$previousPrefix.$prefix;if($service!==false){$previousService=$this->service;$this->service=$service;}$routes($this);$this->currentPrefix=$previousPrefix;if($service!==false){$this->service=$previousService;}return $this;}public function get($regex,$handler){$this->addRoute('GET',$regex,$handler);return $this;}public function post($regex,$handler){$this->addRoute('POST',$regex,$handler);return $this;}public function put($regex,$handler){$this->addRoute('PUT',$regex,$handler);return $this;}public function head($regex,$handler){$this->addRoute('HEAD',$regex,$handler);return $this;}public function delete($regex,$handler){$this->addRoute('DELETE',$regex,$handler);return $this;}public function options($regex,$handler){$this->addRoute('OPTIONS',$regex,$handler);return $this;}public function trace($regex,$handler){$this->addRoute('TRACE',$regex,$handler);return $this;}public function connect($regex,$handler){$this->addRoute('CONNECT',$regex,$handler);return $this;}public function dispatch($method,$path){if(!isset($this->routes[$method])){$params=[$method,$path,404,new HttpRequestException(self::NO_ROUTE_FOUND_MSG)];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}else{foreach($this->routes[$method]as $regex=>$route){$len=strlen($regex);if($len>0){$callback=$route[0];$service=isset($route[1])?$route[1]:null;if($regex[0]!='/')$regex='/'.$regex;if($len>1&&$regex[$len-1]=='/')$regex=substr($regex,0,-1);$regex=str_replace('@','\\@',$regex);if(preg_match('@^'.$regex.'$@',$path,$params)){array_shift($params);try{return $this->call($callback,$service==null?$params:array_merge([$service],$params));}catch(HttpRequestException $ex){$params=[$method,$path,$ex->getCode(),$ex];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}catch(Exception $ex){$params=[$method,$path,500,$ex];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}}}}}return $this->call($this->error,array_merge($this->service==null?[]:[$this->service],[$method,$path,404,new HttpRequestException(self::NO_ROUTE_FOUND_MSG)]));}private function call($callable,array $params=[]){if(is_string($callable)){if(strlen($callable)>0){if($callable[0]=='@'){$callable=$this->baseNamespace.substr($callable,1);}}else{throw new InvalidArgumentException('Route/error callable as string must not be empty.');}$callable=str_replace('.','\\',$callable);}if(is_array($callable)){if(count($callable)!==2)throw new InvalidArgumentException('Route/error callable as array must contain and contain only two strings.');if(strlen($callable[0])>0){if($callable[0][0]=='@'){$callable[0]=$this->baseNamespace.substr($callable[0],1);}}else{throw new InvalidArgumentException('Route/error callable as array must contain and contain only two strings.');}$callable[0]=str_replace('.','\\',$callable[0]);}return call_user_func_array($callable,$params);}public function dispatchGlobal(){$pos=strpos($_SERVER['REQUEST_URI'],'?');return $this->dispatch($_SERVER['REQUEST_METHOD'],'/'.trim(substr($pos!==false?substr($_SERVER['REQUEST_URI'],0,$pos):$_SERVER['REQUEST_URI'],strlen(implode('/',array_slice(explode('/',$_SERVER['SCRIPT_NAME']),0,-1)).'/')),'/'));}}class HttpRequestException extends Exception{}
$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('root', $root);

ini_set('display_errors', 1);

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
            <h2><strong>Flights Search</strong></h2>
            <hr>
            <label><strong>Endpoint</strong><label>
                    <?=root?>search method POST
                    <hr>

                    <div class="row g-2">

                        <div class="col-md-1">
                            <label class="filled w100">
                                <input type="text" value="DEN" placeholder=" " name="origin">
                                <span>origin</span>
                            </label>
                        </div>

                        <div class="col-md-1">
                            <label class="filled w100">
                                <input type="text" value="ATL" placeholder=" " name="destination">
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
                                    <option value="round">return</option>
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
                                    <input type="text" value="P7165793" placeholder=" " name="c1">
                                    <span>c1</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="filled w100">
                                    <input type="text" value="Universal API/uAPI2521640764-f33f1063:7g?P_3Ax6j" placeholder=" " name="c2">
                                    <span>c2</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="filled w100">
                                    <input type="text" value="1G" placeholder=" " name="c3">
                                    <span>c3</span>
                                </label>
                            </div>

                            <!-- <div class="col-md-4">
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
                            </div> -->

                            <progress id="loading" style="display:none" class="linear mt-3"></progress>
                            <script>
                                function loading() { document.getElementById("loading").style.display = "block";}
                            </script>
                        </div>
                    </div>
        </div>

    </form>

<?php  }); ?>

    <?php

/*Search*/
$router->post('/search', function() {
    //Check parameter

    if(isset($_POST['origin']) && trim($_POST['origin']) !== "") {} else { echo "origin : LHE - param or value missing "; die; }
    if(isset($_POST['destination']) && trim($_POST['destination']) !== "") {} else { echo "destination : DXB - param or value missing "; die; }
    if(isset($_POST['departure_date']) && trim($_POST['departure_date']) !== "") {} else { echo "departure_date : 10-10-2021 - param or value missing "; die; }
    if(isset($_POST['childrens']) && trim($_POST['childrens']) !== "") {} else { echo "childrens : 1 - param or value missing "; die; }
    if(isset($_POST['adults']) && trim($_POST['adults']) !== "") {} else { echo "adults : 1 - param or value missing "; die; }
    if(isset($_POST['infants']) && trim($_POST['infants']) !== "") {} else { echo "infants : 1 - param or value missing "; die; }
    if(isset($_POST['triptypename']) && trim($_POST['triptypename']) !== "") {} else { echo "type : oneway | return - param or value missing "; die; }
    if(isset($_POST['c1']) && trim($_POST['c1']) !== "") {} else { echo "c1 - param or value missing "; die; }
    if(isset($_POST['c2']) && trim($_POST['c2']) !== "") {} else { echo "c2 - param or value missing "; die; }
    if(isset($_POST['c3']) && trim($_POST['c3']) !== "") {} else { echo "c3 - param or value missing "; die; }
    if($_POST['type']=='round'){if(isset($_POST['return_date']) && trim($_POST['return_date']) !== "") {} else { echo "return_date : 10-10-2021 - param or value missing "; die; }}

    $departure_date = date('Y-m-d',strtotime($_POST['departure_date']));
    $return_date = date('Y-m-d',strtotime($_POST['return_date']));
    $type = $_POST['triptypename'];

    $TARGETBRANCH = $_POST['c1'];
    $CREDENTIALS = $_POST['c2'];
    $Provider = $_POST['c3'];
    $PreferredDepDate = $departure_date;
    $PreferredRetDate = $return_date;

    $total_adults = $_POST['adults'];
    $total_childrens = $_POST['childrens'];
    $total_infants = $_POST['infants'];

    $NumberOfTravelers = array_sum(array($total_adults, $total_childrens, $total_infants));

    $Origin = $_POST['origin'];
    $Destination = $_POST['destination'];
    $Carrier = "UA";//This should be taken from User input in HTML/PHP user interface
    $CabinClass = "Economy";//This should be taken from User input in HTML/PHP user interface
    $endpoint = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";

    //Create SOAP XML
    $message = new DOMDocument('1.0', 'UTF-8');

    //Create Envelope
    $xmlRoot = $message->createElementNS("http://schemas.xmlsoap.org/soap/envelope/","soapenv:Envelope","");
    $xmlRoot = $message->appendChild($xmlRoot);

    //Create Header
    $xmlRootHeader = $message->createElement("soapenv:Header");
    $xmlRootHeader = $xmlRoot->appendChild($xmlRootHeader);

    //Create Body
    $xmlRootBody = $message->createElement("soapenv:Body");
    $xmlRootBody = $xmlRoot->appendChild($xmlRootBody);

    $lfsRootNode = $message->createElementNS("http://www.travelport.com/schema/air_v42_0","air:LowFareSearchReq","");
    $lfsRootNode = $xmlRootBody->appendChild($lfsRootNode);

    $lfsRootNodeattribute = $message->createAttribute("TraceId");
    $lfsRootNodeattribute->value = "trace";
    $lfsRootNode->appendChild($lfsRootNodeattribute);

    $lfsRootNodeattribute = $message->createAttribute("AuthorizedBy");
    $lfsRootNodeattribute->value = "user";
    $lfsRootNode->appendChild($lfsRootNodeattribute);

    $lfsRootNodeattribute = $message->createAttribute("TargetBranch");
    $lfsRootNodeattribute->value = $TARGETBRANCH;
    $lfsRootNode->appendChild($lfsRootNodeattribute);

    //Above part of code will be same for almost all the requests in UAPI

    //Below part of code might be different based on request structure

    $lfsRootNodeattribute = $message->createAttribute("SolutionResult");
    $lfsRootNodeattribute->value = "true";//If PricePoint is needed then we need to pass the value as false, bydefault this valus is false, incase of true we will receive PricingSolutions
    $lfsRootNode->appendChild($lfsRootNodeattribute);

    $billPointOfSaleNode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:BillingPointOfSaleInfo","");
    $billPointOfSaleNodeattribute = $message->createAttribute("OriginApplication");
    $billPointOfSaleNodeattribute->value = "UAPI";
    $billPointOfSaleNode->appendChild($billPointOfSaleNodeattribute);

    $billPointOfSaleNode = $lfsRootNode->appendChild($billPointOfSaleNode);

    //Outbound Flight Request
    $outboundFlightLeg = $message->createElement("air:SearchAirLeg");
    $outboundFlightLeg = $lfsRootNode->appendChild($outboundFlightLeg);

    $originLeg = $message->createElement("air:SearchOrigin");
    $originLeg = $outboundFlightLeg->appendChild($originLeg);
    $destinatonLeg = $message->createElement("air:SearchDestination");
    $destinatonLeg = $outboundFlightLeg->appendChild($destinatonLeg);
    $prefOutDate = $message->createElement("air:SearchDepTime");
    $prefOutDateAttribute = $message->createAttribute("PreferredTime");
    $prefOutDateAttribute->value = $PreferredDepDate;
    $prefOutDate->appendChild($prefOutDateAttribute);
    $prefOutDate = $outboundFlightLeg->appendChild($prefOutDate);


    if($type == 'round'){
        //It can be aiportCode, or City Code, or CityOrAirportCode with any one of them as preferrence
        $aiportCode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:Airport","");
        $aiportCodeattribute = $message->createAttribute("Code");
        $aiportCodeattribute->value = $Origin;
        $aiportCode->appendChild($aiportCodeattribute);
        $aiportCode = $originLeg->appendChild($aiportCode);

        $aiportCode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:Airport","");
        $aiportCodeattribute = $message->createAttribute("Code");
        $aiportCodeattribute->value = $Destination;
        $aiportCode->appendChild($aiportCodeattribute);
        $aiportCode = $destinatonLeg->appendChild($aiportCode);

        //Inbound/Return Flight Request
        //we can add this part as a inside a if block if return flight requested by the user
        $inboundFlightLeg = $message->createElement("air:SearchAirLeg");
        $inboundFlightLeg = $lfsRootNode->appendChild($inboundFlightLeg);

        $originLeg = $message->createElement("air:SearchOrigin");
        $originLeg = $inboundFlightLeg->appendChild($originLeg);
        $destinatonLeg = $message->createElement("air:SearchDestination");
        $destinatonLeg = $inboundFlightLeg->appendChild($destinatonLeg);
        $prefOutDate = $message->createElement("air:SearchDepTime");
        $prefOutDateAttribute = $message->createAttribute("PreferredTime");
        $prefOutDateAttribute->value = $PreferredRetDate;
        $prefOutDate->appendChild($prefOutDateAttribute);
        $prefOutDate = $inboundFlightLeg->appendChild($prefOutDate);


        //It can be aiportCode, or City Code, or CityOrAirportCode with any one of them as preferrence
        $aiportCode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0", "com:Airport", "");
        $aiportCodeattribute = $message->createAttribute("Code");
        $aiportCodeattribute->value = $Destination;
        $aiportCode->appendChild($aiportCodeattribute);
        $aiportCode = $originLeg->appendChild($aiportCode);

        $aiportCode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0", "com:Airport", "");
        $aiportCodeattribute = $message->createAttribute("Code");
        $aiportCodeattribute->value = $Origin;
        $aiportCode->appendChild($aiportCodeattribute);
        $aiportCode = $destinatonLeg->appendChild($aiportCode);
    }

    if($type == 'oneway') {
        //It can be aiportCode, or City Code, or CityOrAirportCode with any one of them as preferrence
        $aiportCode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0", "com:Airport", "");
        $aiportCodeattribute = $message->createAttribute("Code");
        $aiportCodeattribute->value = $Origin;
        $aiportCode->appendChild($aiportCodeattribute);
        $aiportCode = $originLeg->appendChild($aiportCode);

        $aiportCode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0", "com:Airport", "");
        $aiportCodeattribute = $message->createAttribute("Code");
        $aiportCodeattribute->value = $Destination;
        $aiportCode->appendChild($aiportCodeattribute);
        $aiportCode = $destinatonLeg->appendChild($aiportCode);
    }

    //Below part is modifiers and optional data
    $airSearchModifiersNode = $message->createElement("air:AirSearchModifiers");
    $airSearchModifiersNode = $lfsRootNode->appendChild($airSearchModifiersNode);

    $prefProviderNode = $message->createElement("air:PreferredProviders");
    $prefProviderNode = $airSearchModifiersNode->appendChild($prefProviderNode);

    $prefCabinNode = $message->createElement("air:PermittedCabins");
    $prefCabinNode = $airSearchModifiersNode->appendChild($prefCabinNode);

    $prefCarrierNode = $message->createElement("air:PermittedCarriers");
    $prefCarrierNode = $airSearchModifiersNode->insertBefore($prefCarrierNode, $prefCabinNode);//this has been added just to show that a particular node can be inserted before a particualr node dynamically

    //if there is multiple provider as permitted or preferred we can run this code in a loop to add all the carriers permitted
    $perfProviderCodeNode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:Provider","");
    $perfProviderCodeNodeattribute = $message->createAttribute("Code");
    $perfProviderCodeNodeattribute->value = $Provider;
    $perfProviderCodeNode->appendChild($perfProviderCodeNodeattribute);
    $perfProviderCodeNode = $prefProviderNode->appendChild($perfProviderCodeNode);

    //if there is multiple carrier as permitted or preferred we can run this code in a loop to add all the carriers permitted
    $perfCarrierCodeNode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:Carrier","");
    $perfCarrierCodeNodeattribute = $message->createAttribute("Code");
    $perfCarrierCodeNodeattribute->value = $Carrier;
    $perfCarrierCodeNode->appendChild($perfCarrierCodeNodeattribute);
    $perfCarrierCodeNode = $prefCarrierNode->appendChild($perfCarrierCodeNode);

    $perfCabinCodeNode = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:CabinClass","");
    $perfCabinCodeNodeattribute = $message->createAttribute("Type");
    $perfCabinCodeNodeattribute->value = $CabinClass;
    $perfCabinCodeNode->appendChild($perfCabinCodeNodeattribute);
    $perfCabinCodeNode = $prefCabinNode->appendChild($perfCabinCodeNode);

    //Below part is to add number of traveler in the request
    for($i = 0; $i < $NumberOfTravelers; $i++)
    {
        $travelerDetails = $message->createElementNS("http://www.travelport.com/schema/common_v42_0","com:SearchPassenger","");
        $travelerDetailsattribute = $message->createAttribute("BookingTravelerRef");
        $travelerDetailsattribute->value = $i;
        $travelerDetails->appendChild($travelerDetailsattribute);
        $travelerDetailsattribute = $message->createAttribute("Code");
        $travelerDetailsattribute->value = "ADT";
        $travelerDetails->appendChild($travelerDetailsattribute);
        $travelerDetails = $lfsRootNode->appendChild($travelerDetails);
    }

    // Currency Conversion
    $airPriceModifiersNode = $message->createElement("air:AirPricingModifiers");
    $airPriceModifiersNodeattribute = $message->createAttribute("CurrencyType");
    $airPriceModifiersNodeattribute->value = "USD";
    $airPriceModifiersNode->appendChild($airPriceModifiersNodeattribute);
    $airPriceModifiersNode = $lfsRootNode->appendChild($airPriceModifiersNode);

    $message->preserveWhiteSpace = false;
    $message->formatOutput = true;
    $message = $message->saveXML();

    // End Generate XML

    $file = "001-".$Provider."_LowFareSearchReq.xml"; // file name to save the request xml for test only(if you want to save the request/response)
    prettyPrint($message,$file);//call function to pretty print xml

    //$endpoint = "http://localhost/travelport/api/v1/001-1G_LowFareSearchRsp.xml";

    // Sending search Request
    $auth = base64_encode("$CREDENTIALS");
    $soap_do = curl_init($endpoint);
    $header = array(
        "Content-Type: text/xml;charset=UTF-8",
        "Accept-Encoding: gzip,deflate",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "SOAPAction: \"\"",
        "Authorization: Basic $auth",
        "Content-length: ".strlen($message),
    );
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($soap_do, CURLOPT_POST, true );
    curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message);
    curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
    curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($soap_do, CURLOPT_ENCODING, '');
    $return = curl_exec($soap_do);
    curl_close($soap_do);

    $file = "001-".$Provider."_LowFareSearchRsp.xml"; // file name to save the response xml for test only(if you want to save the request/response)
    $content = prettyPrint($return,$file);

    $LowFareSearchRsp = $content; //use this if response is not saved anywhere else use above variable
    $xml = simplexml_load_String("$LowFareSearchRsp", null, null, 'SOAP', true);

    // $plainXML = convert_xml(trim($LowFareSearchRsp));
    // $arrayResult = json_decode(json_encode(simplexml_load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

    // echo "<pre>";
    // print_r($arrayResult);
    // exit();

    if(!$xml){
        echo json_encode([array('msg'=>'Encoding Error! Check SOAP Fault')]);
        exit();
    }

    $Results = $xml->children('SOAP',true);

    foreach($Results->children('SOAP',true) as $fault){
        if(strcmp($fault->getName(),'Fault') == 0){
            echo json_encode([array('msg'=>'Error occurred request/response processing! Check SOAP Fault')]);
            exit();
        }
    }

    $final_array = [];
    $count = 0;
    if($type == 'oneway') {
        foreach($Results->children('air',true) as $lowFare){
            foreach($lowFare->children('air',true) as $airPriceSol){
                $segments["segments"] = array();
                $newContent = array();
                if(strcmp($airPriceSol->getName(),'AirPricingSolution') == 0){
                    foreach($airPriceSol->children('air',true) as $journey){
                        if(strcmp($journey->getName(),'Journey') == 0){
                            foreach($journey->children('air', true) as $segmentRef){
                                if(strcmp($segmentRef->getName(),'AirSegmentRef') == 0){
                                    foreach($segmentRef->attributes() as $a => $b){
                                        $segment = ListAirSegments($b, $lowFare);
                                        //$opf = OperatingFlight($segment);
                                        // $newContent['airline_name'] = (string)$opf;
                                        // foreach($opf->attributes() as $c => $d){
                                        //   if(strcmp($c, "OperatingCarrier") == 0){
                                        //     // $newContent[$c] = (string)$d;
                                        //     $newContent['img'] = 'modules/global/resources/flights/airlines/'.(string)$d.'.png';
                                        //   }
                                        //   if(strcmp($c, "OperatingFlightNumber") == 0){
                                        //     $newContent['departure_flight_no'] = (string)$d;
                                        //   }
                                        // }
                                        foreach($segment->attributes() as $c => $d){
                                            if(strcmp($c, "Origin") == 0){
                                                // $newContent[$c] = (string)$d;
                                                $newContent['departure_code'] = (string)$d;
                                                $newContent['departure_airport'] = (string)$d;
                                            }
                                            if(strcmp($c, "TravelTime") == 0){
                                                $newContent['duration_time'] = (string)$d;
                                            }
                                            if(strcmp($c, "Destination") == 0){
                                                // $newContent[$c] = (string)$d;
                                                $newContent['arrival_code'] = (string)$d;
                                                $newContent['arrival_airport'] = (string)$d;
                                            }
                                            if(strcmp($c, "Carrier") == 0){
                                                $newContent["airline_code"] = (string)$d;
                                                $newContent['airline_name'] = (string)$d;
                                                $newContent['img'] = 'modules/global/resources/flights/airlines/'.(string)$d.'.png';

                                            }
                                            if(strcmp($c, "FlightNumber") == 0){
                                                $newContent['flight_id'] = (string)$d;
                                            }
                                            if(strcmp($c, "DepartureTime") == 0){
                                                $t_d = explode('T', (string)$d);
                                                $newContent['departure_date'] = $t_d[0];
                                                $newContent['departure_time'] = substr($t_d[1], 0, 5);
                                            }
                                            if(strcmp($c, "ArrivalTime") == 0){
                                                $t_d = explode('T', (string)$d);
                                                $newContent['arrival_date'] = $t_d[0];
                                                $newContent['arrival_time'] = substr($t_d[1], 0, 5);
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                    foreach($airPriceSol->children('air',true) as $priceInfo){
                        if(strcmp($priceInfo->getName(),'AirPricingInfo') == 0){
                            foreach($priceInfo->attributes() as $e => $f){
                                if(strcmp($e, "TotalPrice") == 0){
                                    // $newContent[$e] = (string)$f;
                                    $basePrice = (string)$f;
                                    $price = substr($basePrice, 3, strlen($basePrice) - 3);
                                    $currency = substr((string)$f, 0,3);
                                    $newContent['price'] = $price;
                                    $newContent['adult_price'] = $price;
                                    $newContent['child_price'] = $price;
                                    $newContent['infant_price'] = $price;
                                    $newContent['currency_code'] = $currency;
                                    $newContent['url'] = '';
                                }

                            }
                            foreach($priceInfo->children('air',true) as $bookingInfo){
                                if(strcmp($bookingInfo->getName(),'BookingInfo') == 0){
                                    foreach($bookingInfo->attributes() as $e => $f){
                                        if(strcmp($e, "CabinClass") == 0) {
                                            $newContent['class_type'] = (string)$f;
                                            $newContent['form'] = '';
                                            $newContent['form_name'] = '';
                                            $newContent['action'] = '';
                                            $newContent['type'] = '';
                                            $newContent['luggage'] = '';
                                            $newContent['desc'] = '';
                                            $newContent['booking_token'] = '';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $arr = (array) $newContent;
                if(!empty($arr)){
                    $segments["segments"][0][] = (object)$arr;
                    $final_array[] = $segments;
                }
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

// /*booking*/
// $router->post('/booking', function() {

// });

function prettyPrint($result,$file){
    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = false;
    $dom->loadXML($result);
    $dom->formatOutput = true;
    //call function to write request/response in file
    outputWriter($file,$dom->saveXML());
    return $dom->saveXML();
}

function outputWriter($file,$content){
    file_put_contents($file, $content); // Write request/response and save them in the File
}

function ListAirSegments($key, $lowFare){
    foreach($lowFare->children('air',true) as $airSegmentList){
        if(strcmp($airSegmentList->getName(),'AirSegmentList') == 0){
            foreach($airSegmentList->children('air', true) as $airSegment){
                if(strcmp($airSegment->getName(),'AirSegment') == 0){
                    foreach($airSegment->attributes() as $a => $b){
                        if(strcmp($a,'Key') == 0){
                            //if(strcmp($b, $key) == 0){
                            return $airSegment;
                            // }
                        }
                    }
                }
            }
        }
    }
}

function OperatingFlight($seg){
    foreach($seg->children('air', true) as $CodeshareInfo){
        if(strcmp($CodeshareInfo->getName(),'CodeshareInfo') == 0){
            return $CodeshareInfo;
        }
    }
}

function convert_xml($xml)
{
    $obj = simplexml_load_string($xml);
    if ($obj === FALSE) return $xml;

    // GET NAMESPACES, IF ANY
    $nss = $obj->getNamespaces(TRUE);
    if (empty($nss)) return $xml;

    // CHANGE ns: INTO ns_
    $nsm = array_keys($nss);
    foreach ($nsm as $key)
    {
        // A REGULAR EXPRESSION TO MUNG THE XML
        $rgx
            = '#'               // REGEX DELIMITER
            . '('               // GROUP PATTERN 1
            . '\<'              // LOCATE A LEFT WICKET
            . '/?'              // MAYBE FOLLOWED BY A SLASH
            . preg_quote($key)  // THE NAMESPACE
            . ')'               // END GROUP PATTERN
            . '('               // GROUP PATTERN 2
            . ':{1}'            // A COLON (EXACTLY ONE)
            . ')'               // END GROUP PATTERN
            . '#'               // REGEX DELIMITER
        ;
        // INSERT THE UNDERSCORE INTO THE TAG NAME
        $rep
            = '$1'          // BACKREFERENCE TO GROUP 1
            . '_'           // LITERAL UNDERSCORE IN PLACE OF GROUP 2
        ;
        // PERFORM THE REPLACEMENT
        $xml =  preg_replace($rgx, $rep, $xml);
    }

    return $xml;

}
function dd($data) {
    echo "<pre>";
    print_r($data);
    die();
}

$router->dispatchGlobal();