<?php
Class DbConnection{

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

    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->db;
    }
}