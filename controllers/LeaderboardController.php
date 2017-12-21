<?php
if(file_exists('../models/Score.php')){
    include_once('../models/Score.php');
}
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

class LeaderboardController {

    /**
     * Posts score, and returns that user's highest score for that leaderboard
     * and return users rank compared to all other users and leaderboards
     * @param $body
     */
    public static function scorePost($body) {
        $params = json_decode($body);
        $score = new Score(
            $params->UserId,
            $params->LeaderboardId,
            $params->Score);
        $score->save();
        $response = self::getScoreWithRank($params->UserId, $params->LeaderboardId);
        Response::send(200, $response);
    }

    public static function leaderboardGet($body) {
        $params = json_decode($body);
        $response = self::getScoreWithRank($params->UserId, $params->LeaderboardId);
        $response['Entries'] = self::getLeaderboardWithRank($params->LeaderboardId, $params->Offset, $params->Limit);
        Response::send(200, $response);
    }

    public static function getLeaderboardWithRank($leaderboardId, $offset, $limit) {
        global $db;
        $query = "SELECT userId, score, 
                  FIND_IN_SET( score, (
                      SELECT GROUP_CONCAT( score
                      ORDER BY score DESC ) 
                      FROM leaderboards 
                      WHERE leaderboardId = '". $leaderboardId . "')
                  ) AS rank
            FROM leaderboards
            LIMIT " . $limit . " 
            OFFSET " . $offset;
        try {
            $result = $db->query($query);
        } catch (mysqli_sql_exception $e) {
            $response = array(
                'error' => $e->getMessage());
            Response::send(400, $response);
        }
        $entries = array();
        while($row = $result->fetch_assoc()) {
            array_push($entries, $row);
        }
        return $entries;
    }

    public static function getScoreWithRank($userId, $leaderboardId) {
        global $db;
        $query = "SELECT userId, leaderboardId, score, 
                FIND_IN_SET( score, (
                    SELECT GROUP_CONCAT( score
                        ORDER BY score DESC ) 
                        FROM leaderboards
                        WHERE leaderboardId = '". $leaderboardId . "')
                    ) AS rank
            FROM leaderboards
            WHERE userId = '" . $userId ."' AND
                leaderboardId = '" . $leaderboardId . "'";
        try {
            $result = mysqli_query($db, $query);
        } catch (mysqli_sql_exception $e) {
            $response = array(
                'error' => $e->getMessage());
            http_response_code(400);
            header('Content-Type: application/json');
            $db->close();
            die(json_encode($response));
        }
        $row = mysqli_fetch_assoc($result);
        $userScore = array (
            'UserId' => $row['userId'],
            'LeaderboardId' => $row['leaderboardId'],
            'Score' => $row['score'],
            'Rank' => $row['rank']
        );
        return $userScore;
    }
}