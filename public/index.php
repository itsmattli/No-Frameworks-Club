<?php
include('../routes.php');

$router = new Router();

//determine route
$route = $_REQUEST['q'];

//determine method
$method = $_SERVER['REQUEST_METHOD'];
//get POST body
$body = null;
if ($method == 'POST') {
    $body = file_get_contents('php://input');
} else {
    $body = null;
}

//Check for Authorization headers
$headers = apache_request_headers();
$authorization = null;
if(isset($headers['Authorization'])){
    $authorization = $headers['Authorization'];
}

$router->parse($route, $method, $body, $authorization);