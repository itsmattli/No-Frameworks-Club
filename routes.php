<?php
if(file_exists('../controllers/includes.php')) {
    require_once('../controllers/includes.php');
}

/**
 * Class Router routes incoming requests base on URI
 */
class Router {

    /**
     * Parses incoming requests for Routing
     * @param $query
     */
    public function parse($query, $method, $body) {
        $params = explode('/', $query);
        switch(strtolower($params[0])) {
            case 'timestamp':
                $this->timestamp($method);
                break;
            case 'transaction':
                $this->transaction($method, $body);
                break;
            case 'transactionstats':
                $this->transactionStats($method, $body);
                break;
            case 'scorepost':
                $this->scorePost($method, $body);
                break;
            case 'leaderboardget':
                $this->leaderboardget($method, $body);
                break;
            case 'usersave':
                $this->userSave($method, $body);
                break;
            case 'userload':
                $this->userLoad($method, $body);
                break;
            default:
                http_response_code(404);
                break;
        }
    }

    /**
     * Selects appropriate function for GET /Timestamp
     * @param $method
     */
    public function timestamp($method) {
        if ($method != 'GET') {
            http_response_code(405);
        } else {
            TimestampController::index();
        }
    }

    /**
     * Calls appropriate function for POST /Transaction
     *
     * @param $method
     * @param $body
     */
    public function transaction($method, $body) {
        if ($method != 'POST') {
            http_response_code(405);
        } else {
            TransactionController::transaction($body);
        }
    }

    /**
     * Calls appropriate function for POST /TransactionStats
     *
     * @param $method
     * @param $body
     */
    public function transactionStats($method, $body) {
        if ($method != 'POST') {
            http_response_code(405);
        } else {
            TransactionController::transactionStats($body);
        }
    }

    /**
     * Calls appropriate function for POST /ScorePost
     * @param $method
     * @param $body
     */
    public function scorePost($method, $body) {
        if ($method != 'POST') {
            http_response_code(405);
        } else {
            LeaderboardController::scorePost($body);
        }
    }

    /**
     * Calls appropriate function for POST /LeaderboardGet
     * @param $method
     * @param $body
     */
    public function leaderboardGet($method, $body) {
        if ($method != 'POST') {
            http_response_code(405);
        } else {
            LeaderboardController::leaderboardGet($body);
        }
    }

    /**
     * Calls appropriate function for POST /UserSave
     * @param $method
     * @param $body
     */
    public function userSave($method, $body) {
        if ($method != 'POST') {
            http_response_code(405);
        } else {
            UserController::userSave($body);
        }
    }

    /**
     * Calls appropriate function for POST /UserLoad
     * @param $method
     * @param $body
     */
    public function userLoad($method, $body) {
        if ($method != 'POST') {
            http_response_code(405);
        } else {
            UserController::userLoad($body);
        }
    }
}