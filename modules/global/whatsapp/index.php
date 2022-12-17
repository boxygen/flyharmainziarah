<?php
$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('root', $root);
require_once 'router.php';
use AppRouter\Router;

$router = new Router(function ($method, $path, $statusCode, $exception) {
http_response_code($statusCode);
echo "To send sms example https://travelapi.co/modules/global/sms/16304274409/message";
});

$router->post('/'.'(.*)', function() {

$url = explode('/', $_POST['url']);
$number = $url[0];
$message = $url[1];

header('Access-Control-Allow-Origin: *');
$api = "https://script.google.com/macros/s/AKfycbzQg54Uc1_jS0RR8k0SD3GQAaBDrvHopA8xKZYqIrTTQKQ7uZPWftqKJQ/exec?s=Sheet1&q=update&number=".$number."&text=".$message;

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

header('content-type: application/json');
echo "Your Message Sent Successfully!";
echo "Number :".$number;
echo "Message :".$message;

});

$router->get('/page/(.*)', ['PageController', 'viewPage']);
$router->route(['OPTION', 'PUT'], '/test', 'PageController::test');
$router->dispatchGlobal();
?>