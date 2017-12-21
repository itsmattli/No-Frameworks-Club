<?php
if(file_exists('../utils/dbConnection.php')) {
    include_once('../utils/dbConnection.php');
}

/**
 * Establish DB Connection
 */
$db = DbConnection::getConnection();

class Response {
    public static function send($code, $response){
        global $db;
        $db->close();
        http_response_code($code);
        header('Content-Type: application/json');
        die(json_encode($response));
    }
}