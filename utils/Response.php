<?php
if(file_exists('../utils/DbConnection.php')) {
    require_once('../utils/DbConnection.php');
}

/**
 * Establish DB Connection
 */
$db = DbConnection::getConnection();


/**
 * Class Response formats responses and closes the database after before script concludes
 */
class Response {
    /**
     * Sends json response and closes DB
     * @param $code
     * @param $response
     */
    public static function send($code, $response){
        global $db;
        $db->close();
        http_response_code($code);
        header('Content-Type: application/json');
        die(json_encode($response));
    }

    public static function error($code, $message) {
        global $db;
        if($db) {
            $db->close();
        }
        http_response_code($code);
        header('Content-Type: application/json');
        $response = array (
            'Error' => true,
            'ErrorMessage' => $message
        );
        die(json_encode($response));
    }

    /**
     * Sends empty json response forced as a object
     * @param $code
     * @param $response
     */
    public static function sendForceObject($code, $response) {
        global $db;
        $db->close();
        http_response_code($code);
        header('Content-Type: application/json');
        die(json_encode($response, JSON_FORCE_OBJECT));
    }
}