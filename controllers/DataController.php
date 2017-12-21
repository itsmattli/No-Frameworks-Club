<?php

if(file_exists('../utils/Response.php')) {
    require_once('../utils/Response.php');
}
/**
* Class DataController offers static functions for seeding and deleting all data.
*/
class DataController {
    const API_KEY = 'WXViXgSaYf2uFYUZg12JaXCn3IewYAhI';
    public static function delete($authorization) {
        if(self::verifyAuth($authorization)){

        }
    }

    public static function create($authorization) {
        if(self::verifyAuth($authorization)){

        }
    }

    public static function verifyAuth($authorization) {
        if(base64_decode($authorization) == self::API_KEY) {
            return true;
        }
        Response::error(403, "Not Authrorized");
    }
}