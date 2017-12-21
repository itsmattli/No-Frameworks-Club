<?php

/**
 * Class DbConnection implements a singleton design pattern for a mysqli connection
 */
class DbConnection{

    /* Database connection start */
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "1234";
    private static $dbname = "iugo";

    private static $instance = null;

    private $db;
    private function __construct() {
        $this->db = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    }

    /**
     * Establishes the database connection if it doesn't already exist
     * @return mysqli
     */
    public static function getConnection() {
        if (self::$instance === null) {
            $driver = new mysqli_driver();
            $driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
            self::$instance = new self();
        }
        return self::$instance->db;
    }
}