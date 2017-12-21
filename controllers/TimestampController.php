<?php
if(file_exists('../utils/Response.php')) {
    include_once('../utils/Response.php');
}

class TimestampController {
    public static function index() {
        $response['Timestamp'] = time();
        Response::send(200, $response);
    }
}