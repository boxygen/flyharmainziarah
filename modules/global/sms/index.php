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

require __DIR__ . '/twilio-php-main/src/Twilio/autoload.php';
use Twilio\Rest\Client;

$router->get('/'.'(.*)', function() {

$url = explode('/', $_GET['url']);
$number = $url[0];
$message = $url[1];

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'AC8ff46ab10e9e6ac1eea4b0c9c65c9da7';
$auth_token = '68ad1e55bf0b8c8ab888bd5350fca0c0';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]
// A Twilio number you own with SMS capabilities
$twilio_number = "+17206507982";
$client = new Client($account_sid, $auth_token);
$client->messages->create(
    // Where to send a text message (your cell phone?)
    $number,
    array(
        'from' => $twilio_number,
        'body' => $message
    )
);

header('content-type: application/json');
echo "Your Message Sent Successfully!";
echo "Number :".$number;
echo "Message :".$message;

});

$router->get('/page/(.*)', ['PageController', 'viewPage']);
$router->route(['OPTION', 'PUT'], '/test', 'PageController::test');
$router->dispatchGlobal();
?>