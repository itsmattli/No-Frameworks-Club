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
 * Class Score represents one row in the leaderboards table.
 */
class Score{
    var $userId;
    var $leaderboardId;
    var $score;

    /**
     * Score constructor.
     * @param $userId
     * @param $leaderboardId
     * @param $score
     */
    public function __construct($userId, $leaderboardId, $score){
        $this->userId = $userId;
        $this->leaderboardId = $leaderboardId;
        $this->score = $score;
    }

    /**
     * Stores score information in the database
     */
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
                    Response::error(400, $e->getMessage());
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
                Response::error(400, $e->getMessage());
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
            Response::error(400, $e->getMessage());
        }
        $row = $result->fetch_assoc();
        if($row) {
            return new Score($row['userId'], $row['leaderboardId'], $row['score']);
        } else {
            return null;
        }
    }
}