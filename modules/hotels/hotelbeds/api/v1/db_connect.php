<?php

// DATABSE
include('../../../../../config.php');

$localhost = $db['default']['hostname'];
$username = $db['default']['username'];
$password = $db['default']['password'];
$dbname = $db['default']['database'];

// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
//   echo "Successfully connected";
}

?>