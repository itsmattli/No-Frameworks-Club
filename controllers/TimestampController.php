<?php
if(file_exists('../utils/Response.php')) {
    require_once('../utils/Response.php');
}

/**
 * Class TimestampController provides static functions relating to Timestamp
 */
class TimestampController {

    /**
     * Returns current UNIX timestamp
     */
    public static function index() {
        $response['Timestamp'] = time();
        Response::send(200, $response);
    }
}