<?php
if(file_exists('../api/timestamp.php')) {
    require_once('../api/timestamp.php');
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
                $this->timestamp($method,$body);
                break;
        }
    }

    /**
     * Selects appropriate method for GET /Timestamp
     * @param $method
     * @param $body
     */
    public function timestamp($method, $body) {
        if ($method != 'GET') {
            header("HTTP/1.0 405 Method Not Allowed");
        } else {
            Timestamp::index();
        }
    }
}