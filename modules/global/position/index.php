<?php
$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('root', $root);
require_once 'router.php';
use AppRouter\Router;

$router = new Router(function ($method, $path, $statusCode, $exception) {
http_response_code($statusCode);
echo "404";
});

$router->get('/'.'(.*)', function() {
header('content-type: application/json');
$url = explode('/', $_GET['url']);
$location = $url[0];

header('Access-Control-Allow-Origin: *');
$api = "http://api.positionstack.com/v1/forward?access_key=09cfc4f6e54703eb4b3ad15b916b28ff&query=";

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $api.$location,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}

});

$router->get('/page/(.*)', ['PageController', 'viewPage']);
$router->route(['OPTION', 'PUT'], '/test', 'PageController::test');
$router->dispatchGlobal();
?>