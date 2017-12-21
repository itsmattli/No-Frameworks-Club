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
                Timestamp::index();
                break;
        }
    }
}