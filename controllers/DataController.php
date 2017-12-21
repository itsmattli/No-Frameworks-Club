<?php

if(file_exists('../utils/dbConnection.php')) {
    require_once('../utils/dbConnection.php');
}
if(file_exists('../utils/Response.php')) {
    require_once('../utils/Response.php');
}
/**
 * Establish DB Connection
 */
$db = DbConnection::getConnection();

/**
* Class DataController offers static functions for seeding and deleting all data.
*/
class DataController {
    const API_KEY = 'WXViXgSaYf2uFYUZg12JaXCn3IewYAhI';

    /**
     * Truncates all data on all tables
     * @param $auth
     */
    public static function delete($auth) {
        global $db;
        if(self::verifyAuth($auth)){
            $query = file_get_contents('../data/delete.sql');
            try {
                $db->multi_query($query);
            } catch (mysqli_sql_exception $e) {
                Response::error(500, "Internal Server Error");
            }
        }
    }

    /**
     * Seeds some data from seed.sql
     * @param $auth
     */
    public static function create($auth) {
        global $db;
        if(self::verifyAuth($auth)){
            $query = file_get_contents('../data/seed.sql');
            try {
                $db->multi_query($query);
            } catch (mysqli_sql_exception $e) {
                Response::error(500, "Internal Server Error");
            }
        }
    }

    /**
     * Verifies user's authorization header matches base64 encoded version of API_KEY
     * @param $authorization
     * @return bool
     */
    public static function verifyAuth($authorization) {

        if(base64_decode($authorization) == self::API_KEY) {
            return true;
        }
        Response::error(403, "Not Authorized");
    }
}