<?php

// MODULE tiqets affiliate API v2
// API DOCS https://www.tiqets.com/distributorapi/docs

namespace AppRouter;use Exception;use DateTime;use DateInterval;use InvalidArgumentException;class Router{const NO_ROUTE_FOUND_MSG='No route found';private $routes;private $error;private $baseNamespace;private $currentPrefix;private $service=null;public function __construct($error,$baseNamespace=''){$this->routes=[];$this->error=$error;$this->baseNamespace=$baseNamespace==''?'':$baseNamespace.'\\';$this->currentPrefix='';}public function setService($service){$this->service=$service;}public function getService($service){return $this->service;}public function route($method,$regex,$handler){if($method=='*'){$method=['GET','PUT','DELETE','OPTIONS','TRACE','POST','HEAD'];}foreach((array)$method as $m){$this->addRoute($m,$regex,$handler);}return $this;}private function addRoute($method,$regex,$handler){$this->routes[strtoupper($method)][$this->currentPrefix.$regex]=[$handler,$this->service];}public function mount($prefix,callable $routes,$service=false){$previousPrefix=$this->currentPrefix;$this->currentPrefix=$previousPrefix.$prefix;if($service!==false){$previousService=$this->service;$this->service=$service;}$routes($this);$this->currentPrefix=$previousPrefix;if($service!==false){$this->service=$previousService;}return $this;}public function get($regex,$handler){$this->addRoute('GET',$regex,$handler);return $this;}public function post($regex,$handler){$this->addRoute('POST',$regex,$handler);return $this;}public function put($regex,$handler){$this->addRoute('PUT',$regex,$handler);return $this;}public function head($regex,$handler){$this->addRoute('HEAD',$regex,$handler);return $this;}public function delete($regex,$handler){$this->addRoute('DELETE',$regex,$handler);return $this;}public function options($regex,$handler){$this->addRoute('OPTIONS',$regex,$handler);return $this;}public function trace($regex,$handler){$this->addRoute('TRACE',$regex,$handler);return $this;}public function connect($regex,$handler){$this->addRoute('CONNECT',$regex,$handler);return $this;}public function dispatch($method,$path){if(!isset($this->routes[$method])){$params=[$method,$path,404,new HttpRequestException(self::NO_ROUTE_FOUND_MSG)];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}else{foreach($this->routes[$method]as $regex=>$route){$len=strlen($regex);if($len>0){$callback=$route[0];$service=isset($route[1])?$route[1]:null;if($regex[0]!='/')$regex='/'.$regex;if($len>1&&$regex[$len-1]=='/')$regex=substr($regex,0,-1);$regex=str_replace('@','\\@',$regex);if(preg_match('@^'.$regex.'$@',$path,$params)){array_shift($params);try{return $this->call($callback,$service==null?$params:array_merge([$service],$params));}catch(HttpRequestException $ex){$params=[$method,$path,$ex->getCode(),$ex];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}catch(Exception $ex){$params=[$method,$path,500,$ex];return $this->call($this->error,$this->service==null?$params:array_merge([$this->service],$params));}}}}}return $this->call($this->error,array_merge($this->service==null?[]:[$this->service],[$method,$path,404,new HttpRequestException(self::NO_ROUTE_FOUND_MSG)]));}private function call($callable,array $params=[]){if(is_string($callable)){if(strlen($callable)>0){if($callable[0]=='@'){$callable=$this->baseNamespace.substr($callable,1);}}else{throw new InvalidArgumentException('Route/error callable as string must not be empty.');}$callable=str_replace('.','\\',$callable);}if(is_array($callable)){if(count($callable)!==2)throw new InvalidArgumentException('Route/error callable as array must contain and contain only two strings.');if(strlen($callable[0])>0){if($callable[0][0]=='@'){$callable[0]=$this->baseNamespace.substr($callable[0],1);}}else{throw new InvalidArgumentException('Route/error callable as array must contain and contain only two strings.');}$callable[0]=str_replace('.','\\',$callable[0]);}return call_user_func_array($callable,$params);}public function dispatchGlobal(){$pos=strpos($_SERVER['REQUEST_URI'],'?');return $this->dispatch($_SERVER['REQUEST_METHOD'],'/'.trim(substr($pos!==false?substr($_SERVER['REQUEST_URI'],0,$pos):$_SERVER['REQUEST_URI'],strlen(implode('/',array_slice(explode('/',$_SERVER['SCRIPT_NAME']),0,-1)).'/')),'/'));}}class HttpRequestException extends Exception{}

use Curl\Curl;

include "vendor/autoload.php";

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

$router->post('/search', function() {

// if(isset($_POST['origin']) && trim($_POST['origin']) !== "") {} else { echo "origin : LHE - param or value missing "; die; }

header('Content-Type: application/json');

file_put_contents("post.log", print_r($_POST, true));

// REQUEST TO GET COUNTRY CODE
$req = new Curl();
$req->get('https://www.tiqets.com/en/_autocomplete?q='.$_REQUEST['loaction']);
$c_code=($req->response->results[0]->city_id);

// print_r($req->response->results[0]->country_id);
// die;

// REQUEST TO GET TOURS DATA
$req = new Curl();
$req->setHeader('Authorization', 'Token '.$_REQUEST['c1']);
$req->get('https://api.tiqets.com/v2/products?lang=en&currency=USD&page_size=50&page=1&city_id='.$c_code.'&sort=price%20desc');

// print_r(json_encode($req->response->products));
// die;


$data = $req->response->products;

    $array = [];
    foreach ($data as $key => $i){
        if(!empty($i->venue->name)) {

            // IMAGE CHECK
            if (isset($i->images['0']->large)) {$img = $i->images['0']->large; } else { $img = ""; }

            $array[] = (object)[
                'tour_id' => $i->id,
                'name' => $i->title,
                'location' => $i->venue->name. ' '. $i->venue->address,
                'img' => $img,
                'desc' => $i->summary,
                'price' => $i->price,
                'actual_price' => $i->price,
                'duration' => $i->duration,
                'rating' => $i->ratings->average,
                'redirected' => $i->product_url,
                'latitude' => $i->geolocation->lat,
                'longitude' => $i->geolocation->lng,
                'currency_code' => ''
            ];
        }
    }

print_r(json_encode($array));

});

$router->dispatchGlobal();