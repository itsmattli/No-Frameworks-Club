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
 * Class User represents one row in the users table.
 */
class User {
    var $userId;
    var $dataKey;
    var $data;

    /**
     * User constructor.
     * @param $userId
     * @param $dataKey
     * @param $data
     */
    public function __construct($userId, $dataKey, $data) {
        $this->userId = $userId;
        $this->dataKey = $dataKey;
        $this->data = $data;
    }

    /**
     * Stores user information into the database.
     */
    public function save() {
        global $db;
        $existingRecord = self::load($this->userId, $this->dataKey);
        if($existingRecord) {
            $query = "UPDATE users 
                SET data = '" . $this->data . "'
                WHERE userId = '" . $this->userId . "' AND
                dataKey = '" . $this->dataKey . "'";
            try {
                $db->query($query);
            } catch (mysqli_sql_exception $e) {
                $response = array(
                    'error' => $e->getMessage());
                Response::send(400, $response);
            }
        } else {
            $query = "INSERT INTO users VALUES ("
                . "'" . $this->userId . "',"
                . "'" . $this->dataKey . "',"
                . "'" . $this->data . "')";
            try {
                $db->query($query);
            } catch (mysqli_sql_exception $e) {
                $response = array(
                    'error' => $e->getMessage());
                Response::send(400, $response);
            }
        }
    }

    public function load($userId, $dataKey) {
        global $db;
        $query = "SELECT * from Users
            WHERE userId = '" . $userId . "' AND
            dataKey = '" . $dataKey . "'";
        try {
            $result = $db->query($query);
        } catch (mysqli_sql_exception $e) {
            $response = array(
                'error' => $e->getMessage());
            Response::send(400, $response);
        }
        $row = $result->fetch_assoc();
        if($row) {
            return new User($row['userId'], $row['dataKey'], $row['data']);
        } else {
            return null;
        }
    }
}