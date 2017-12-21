<?php

class Timestamp {
    public static function index() {
        $response['Timestamp'] = time();
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}