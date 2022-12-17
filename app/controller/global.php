<?php

// ROUTE FOR ADMIN
$router->get('admin', function() {
header("Location: ".api_url."admin");
});

// ROUTE FOR SUPPLIER
$router->get('supplier', function() {
header("Location: ".api_url."supplier");
});

// RESPONSIVE
$router->get('responsive', function() {
include "app/themes/default/responsive.php";
});