<?php
include('../routes.php');

$router = new Router();

$method = $_SERVER["REQUEST_METHOD"];
$route = $_REQUEST['q'];
if ($method == 'POST') {
    $body = file_get_contents('php://input');
} else {
    $body = null;
}

$router->parse($route, $method, $body);