<?php
include('../routes.php');
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 2017-12-20
 * Time: 4:37 PM
 */
$router = new Router();

$request_method = $_SERVER["REQUEST_METHOD"];
$route = $_REQUEST['q'];
if ($request_method == 'POST') {
    $body = file_get_contents('php://input');
} else {
    $body = null;
}

$router->parse($route, $request_method, $body);