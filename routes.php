<?php
if(file_exists('../controllers/includes.php')) {
    require_once('../controllers/includes.php');
}

class Router {

    public function __construct(){
    }

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
                $this->transaction($method,$body);
                break;
            case 'transactionstats':
                $this->transactionStats($method,$body);
                break;
            default:
                http_response_code(404);
                break;
        }
    }

    /**
     * Selects appropriate method for GET /Timestamp
     * @param $method
     * @param $body
     */
    public function timestamp($method) {
        if ($method != 'GET') {
            http_response_code(405);
        } else {
            TimestampController::index();
        }
    }

    public function transaction($method, $body) {
        if ($method != 'POST') {
            http_response_code(405);
        } else {
            TransactionController::transaction($body);
        }
    }

    public function transactionStats($method, $body) {
        if ($method != 'POST') {
            http_response_code(405);
        } else {
            TransactionController::transactionStats($body);
        }
    }
}