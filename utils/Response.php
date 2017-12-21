<?php
if(file_exists('../utils/dbConnection.php')) {
    require_once('../utils/dbConnection.php');
}

/**
 * Establish DB Connection
 */
$db = DbConnection::getConnection();


/**
 * Class Response formats responses and closes the database after before script concludes
 */
class Response {
    public static function send($code, $response){
        global $db;
        $db->close();
        http_response_code($code);
        header('Content-Type: application/json');
        die(json_encode($response));
    }
}