<?php

if(file_exists('../utils/dbConnection.php')) {
    include_once('../utils/dbConnection.php');
}

if(file_exists('../utils/Response.php')) {
    include_once('../utils/Response.php');
}

/**
 * Establish DB Connection
 */
$db = DbConnection::getConnection();

//@TODO close DB CONN

class Score{
    var $userId;
    var $leaderboardId;
    var $score;

    public function __construct($userId, $leaderboardId, $score){
        $this->userId = $userId;
        $this->leaderboardId = $leaderboardId;
        $this->score = $score;
    }

    public function save() {
        global $db;
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $oldScore = $this->load($this->userId, $this->leaderboardId);
        if($oldScore) {
            if($oldScore->score < $this->score) {
                $query = "UPDATE leaderboards 
                SET score = '" . $this->score . "'
                WHERE userId = '" . $this->userId . "' AND
                leaderboardId = '" . $this->leaderboardId . "'";
                try {
                    mysqli_query($db, $query);
                } catch (mysqli_sql_exception $e) {
                    $response = array(
                        'error' => $e->getMessage());
                    Response::send(400, $response);
                }
            }
        } else {
            $query = "INSERT INTO leaderboards VALUES ("
                . "'" . $this->userId . "',"
                . "'" . $this->leaderboardId . "',"
                . "'" . $this->score . "')";
            try {
                mysqli_query($db, $query);
            } catch (mysqli_sql_exception $e) {
                $response = array(
                    'error' => $e->getMessage());
                Response::send(400, $response);
            }
        }
    }

    /**
     * Loads a single Leaderboard entry.
     *
     * @param $userId
     * @param $leaderboardId
     * @return Score
     */
    public function load($userId, $leaderboardId) {
        global $db;
        $query = "SELECT * from leaderboards
            WHERE userId = '" . $userId . "' AND
            leaderboardId = '" . $leaderboardId . "'";
        try {
            $result = $db->query($query);
        } catch (mysqli_sql_exception $e) {
            $response = array(
                'error' => $e->getMessage());
            Response::send(400, $response);
        }
        $row = $result->fetch_assoc();
        if($row) {
            return new Score($row['userId'], $row['leaderboardId'], $row['score']);
        } else {
            return null;
        }
    }
}