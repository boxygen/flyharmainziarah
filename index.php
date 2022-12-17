<?php

// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://etravelplus.net/api/api/main/app?appKey=phptravels&lang=ar&currency=usd',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'GET',
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// echo $response;

// die;


// $servername = "phptravelsnet-84d8f891c6";
// $username = "rootuser";
// $password = "rootuser";

// // Create connection
// $conn = new mysqli($servername, $username, $password);

// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";

// die;


// GET SERVER ROOT PATH
$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('root',$root);

// X-FRAME OPTIONS
header("X-Frame-Options: SAMEORIGIN");

// REDIRECT TO INSTALL
if(!file_exists('config.php')) {
header('Location: ./install'); }

// CREATE CACHE AND LOGS IF NOT EXIST
if(!file_exists('app/logs')) {  mkdir('app/logs', 0777, true); }
if(!file_exists('app/cache')) {  mkdir('app/cache', 0777, true); }

// CREATE HTACCESS FILE IF DOES NOT EXIST ON SERVER
if(!file_exists('.htaccess')) {
$content = 'RewriteEngine On' . "\n";
$content .= 'RewriteCond %{REQUEST_FILENAME} !-d' . "\n";
$content .= 'RewriteCond %{REQUEST_FILENAME} !-f' . "\n";
$content .= 'RewriteCond %{REQUEST_FILENAME} !-l' . "\n\n";
$content .= 'RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]';
file_put_contents('.htaccess', $content);
header('Location: '.root);
}

// BASEPATH OF API SERVER
define('BASEPATH', '');

// ENVIROMENT OF API SERVER
define('ENVIRONMENT', 'production');

// MAIN APP CONFIG FILE
require_once "config.php";

// DEFINE MODULES ROUTES
define('hotels',   'hotels'    );
define('hotel',    'hotel'     );
define('flights',  'flights'   );
define('blog',     'blog'      );
define('offers',   'offers'    );
define('login',    'login'     );
define('signup',   'signup'    );
define('visa',     'visa'      );
define('tours',    'tours'     );
define('transfers','transfers' );

use Curl\Curl;
use AppRouter\Router;
require "app/vendor.php";
require "./vendor/autoload.php";

/* init whoops errors  */
$whoops = new Whoops\Run();
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
$whoops->register();

/* init multi language */
require './app/lib/i18n/i18n.class.php';
$i18n = new i18n('./app/lang/{LANGUAGE}.json','app/cache/','en');

session_start();

// PHP CHECK VERSION IF BELOW v8
$php = explode('.', phpversion()); if ($php[0] < 7.4 ) {
include "app/core/php.php";
die; }

if (dev == 1 ) {
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
};

// SENTRY DEBUGGER TOOL
\Sentry\init(['dsn' => 'https://5904e7d55eb94a989e73112ebeb63d4e@o1354411.ingest.sentry.io/6638041' ]);

// USE THIS METHOD ONLY IF CACHE
// if (empty($_SESSION['app'])) {
// $req = new Curl();
// $req->get(root.'api/api/main/app?appKey='.api_key);
// if ($req->error) { 	 $req->error;
// } else { $_SESSION['app'] = $req->response; }; }

// THIS THIS METHOD WITHOUT CACHE
$req = new Curl();
$req->get(root.'api/api/main/app?appKey='.api_key);

unset($_SESSION['app']);
$_SESSION['app'] = $req->response;

// dd($req->response);
// die;

// SHOW SERVER API RESPONSE ERROR
if (empty($_SESSION['app']->app)) {
echo '<body style="display: flex; justify-content: center; align-items: center; font-weight: bold; font-family: monospace; font-size: 16px; background: #e1e5eb; color: #0329b1">';
echo 'No Response from API Server';
echo '<a target="_blank" style="background: #005aff; color: #fff; text-decoration: none; padding: 14px; border-radius: 7px; margin-left: 12px; font-size: 12px;" href="./api/api/main/app?appKey='.api_key.'&env=dev">Check API Dev</a>';
echo '<a target="_blank" style="background: #005aff; color: #fff; text-decoration: none; padding: 14px; border-radius: 7px; margin-left: 12px; font-size: 12px;" href="./api/api/main/app?appKey='.api_key.'">Check API Pro</a>';
echo '</body>';
session_destroy(); die; };

// ADD MAIN API RESPONSE TO SESSION
$app = $_SESSION['app'];

// DEFINE META TAGS
define('slogan', $app->app->meta_title);
define('meta_url', "");
define('meta_author',api_url);

// DEFINE TEMAPLTE VIEWS
$theme = "default";
define('invoice_layout', "app/themes/".$theme."/invoice_layout.php");
define('layout', "app/themes/".$theme."/main.php");
define('views', "app/themes/".$theme."/");
define('theme_url',"app/themes/default/");

// ADD CURRENCY AND LANGUAGES TO SESSION
if (!isset($_SESSION['session_currency']) || (trim($_SESSION['session_currency']) == '')) { $_SESSION['session_currency'] = $app->app->currency_code; }
if (!isset($_SESSION['session_lang']) || (trim($_SESSION['session_lang']) == '')) { $_SESSION['session_lang'] = $app->app->default_language; }

$session_langcur = $_SESSION['session_lang'].'/'.strtolower($_SESSION['session_currency']).'/';
$current_uri = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// GET CLIENT IP
$ip = call_user_func(function(){
$ipaddress = '';
if (getenv('HTTP_CLIENT_IP')) $ipaddress = getenv('HTTP_CLIENT_IP');
else if(getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
else if(getenv('HTTP_X_FORWARDED')) $ipaddress = getenv('HTTP_X_FORWARDED');
else if(getenv('HTTP_FORWARDED_FOR')) $ipaddress = getenv('HTTP_FORWARDED_FOR');
else if(getenv('HTTP_FORWARDED')) $ipaddress = getenv('HTTP_FORWARDED');
else if(getenv('REMOTE_ADDR')) $ipaddress = getenv('REMOTE_ADDR');
else $ipaddress = 'no-ip';
return $ipaddress; });

// DD FUNCTION FOR DEBUG RESPONSES
function dd($d) { echo "<pre>"; print_r($d); echo "</pre>"; }

// ERROR 404 PAGE
$router = new Router(function ($method, $path, $statusCode, $exception) {
http_response_code($statusCode);
$title = slogan; $meta_title = slogan; $meta_desc = ""; $meta_img = ""; $meta_url = meta_url; $meta_author = meta_author; $meta = "1";
$body = views."404.php";
include layout;
});

// SESSION VIEW AND DESTROY CONROLLERS
$router->get('s', function() { echo "<pre>"; json_decode(print_r($_SESSION)); });
$router->get('sd',function() { session_destroy(); echo '
    <style>body{background:#545454;display:flex;justify-content:center;align-items: center;}</style>
    <svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" stroke="#fff"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="1"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" /> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" /> </circle> <circle cx="22" cy="22" r="1"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" /> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" /> </circle> </g> </svg>
    <meta http-equiv="refresh" content="1; URL='.root.'"/>';
});

// CREATE DYNAMIC CONTROLLERS FROM FILES
// $controller = 'app/controller';
// $indir = array_filter(scandir($controller), function($item)use($controller)
// {return !is_dir($controller.'/'.$item);});
// foreach ($indir as $key=>$value){
// include $controller.'/'.$value; }

// AUTOLOAD CONTROLLERS
require_once "app/controller/accounts.php";
require_once "app/controller/blog.php";
require_once "app/controller/transfers.php";
require_once "app/controller/cms.php";
require_once "app/controller/flights.php";
require_once "app/controller/global.php";
require_once "app/controller/home.php";
require_once "app/controller/hotels.php";
require_once "app/controller/offers.php";
require_once "app/controller/tours.php";
require_once "app/controller/visa.php";
require_once "app/controller/flush.php";

// DYNAMIC CONTROLLERS FOR PAYMENT GATEWAYS
$controller = 'app/controller/gateways';
$indir = array_filter(scandir($controller), function($item)use($controller)
{return !is_dir($controller.'/'.$item);});
foreach ($indir as $key=>$value){
include $controller.'/'.$value; }

// LANGUAGES FIELS PATH
$dir='app/lang';
$indir = array_filter(scandir($dir,1), function($item)
{return !is_dir('app/lang/'.$item);});
$files_data = array();
foreach ($indir as $key=>$value){
$string = file_get_contents("app/lang/".$value);
array_push ($files_data,json_decode($string));}

// CHECK & SET LANGUAGES
if(isset($_SESSION['session_lang'])){
$i18n->setForcedLang($_SESSION['session_lang']);
$i18n->init();
}elseif(!isset($_SESSION['session_lang'])){
foreach($files_data as $item){  if($item->country == strtolower(user_country_code)) {
$_SESSION['session_lang'] = $item->lang_code;
}else{ $_SESSION['session_lang'] = 'en'; }}
$i18n->setForcedLang($_SESSION['session_lang']);
$i18n->init(); }

// LANGUAGE CONTROLLERS
foreach($files_data as $item){
$lan = $item->lang_code;
$router->get('lang-'.$item->lang_code, function() use ($lan) {

$req = new Curl();
$req->get(api_url.'api/api/main/app?lang='.$lan.'&appKey='.api_key);
if ($req->error) { 	// $req->error;
} else { $_SESSION['app'] = $req->response; };

$_SESSION['session_lang']=$lan;
header("Location: ".root); });}

// CURRENCY SESSION VERIABLES
if(isset($_SESSION['session_currency'])){ $_SESSION['session_currency'];
}elseif(!isset($_SESSION['session_currency'])){ foreach($currency_data as $key => $value){
if($value->country_code == strtolower(user_country_code)) { $currency_code = $value->code;
$_SESSION['session_currency'] = $currency_code; } } }

// STORE CURRENCY TO SESSION
foreach ($app->currencies as $currency){{
$c = $currency->code;
$router->get('currency-'.$currency->code, function() use ( $c )  {

$req = new Curl();
$req->get(api_url.'api/api/main/app?currency='.$c.'&appKey='.api_key);
if ($req->error) { 	// $req->error;
} else { $_SESSION['app'] = $req->response; };

$_SESSION['session_currency'] = $c;
echo '<script>window.location.href = "'.root.'"</script>';
}); } }

// STORE LOGS TO LOGGING FILE
function logs($SearchType){ $log = "IP: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a"). '- Type => '.$SearchType . ' - URL => ' .$_GET['url'].PHP_EOL.
"------------------------------------".PHP_EOL;
$logs_path = "app/logs";
if (!file_exists($logs_path)) { mkdir("app/logs", 0777); } else { };
file_put_contents('app/logs/log_'.date("j.n.Y").'.log', $log, FILE_APPEND); };

// STORE SEARCHS TO SESSION
function SEARCH_SESSION($MODULE,$CITY){
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$b_=(object)array($MODULE,$CITY,$actual_link);
if (isset($_SESSION['SEARCHES'])){} else { $_SESSION['SEARCHES'] = array();  }
array_push($_SESSION['SEARCHES'],$b_); };

// $router->get('/page/(.*)', ['PageController', 'viewPage']);
// $router->route(['OPTION', 'PUT'], '/test', 'PageController::test');
$router->dispatchGlobal();

?>