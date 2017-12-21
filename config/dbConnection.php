<?php
Class dbConnection{

    /* Database connection start */
    var $servername = "localhost";
    var $username = "root";
    var $password = "1234";
    var $dbname = "iugo";
    var $conn;

    function getConnstring() {
        $dbContext = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        } else {
            $this->conn = $dbContext;
        }
        return $this->conn;
    }
}