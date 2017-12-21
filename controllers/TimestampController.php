<?php

class TimestampController {
    public static function index() {
        $response['Timestamp'] = time();
        http_response_code(200);
        header('Content-Type: application/json');
        die(json_encode($response));
    }
}