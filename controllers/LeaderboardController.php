<?php
if(file_exists('../models/Score.php')){
    include_once('../models/Score.php');
}

/**
 * Establish DB Connection
 */
$db = DbConnection::getConnection();

class LeaderboardController {
    public static function scorePost($body) {
        global $db;
        $params = json_decode($body);
        $score = new Score(
            $params->UserId,
            $params->LeaderboardId,
            $params->Score);
        $score->save();
        $query = "SELECT userId, leaderboardId, score, 
                FIND_IN_SET( score, (
                    SELECT GROUP_CONCAT( score
                        ORDER BY score DESC ) 
                        FROM leaderboards )
                    ) AS rank
            FROM leaderboards
            WHERE userId = '" . $params->UserId ."' AND
                leaderboardId = '" . $params->LeaderboardId . "'";
        try {
            $result = mysqli_query($db, $query);
        } catch (mysqli_sql_exception $e) {
            $response = array(
                'error' => $e->getMessage());
            http_response_code(400);
            header('Content-Type: application/json');
            die(json_encode($response));
        }
        $row = mysqli_fetch_assoc($result);
        $response = array (
            'UserId' => $row['userId'],
            'LeaderboardId' => $row['leaderboardId'],
            'Score' => $row['score'],
            'Rank' => $row['rank']
        );
        http_response_code(200);
        header('Content-Type: application/json');
        die(json_encode($response));
    }
}