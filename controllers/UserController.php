<?php

if(file_exists('../models/User.php')){
    require_once('../models/User.php');
}

if(file_exists('../utils/dbConnection.php')) {
    require_once('../utils/dbConnection.php');
}

if(file_exists('../utils/Response.php')) {
    require_once('../utils/Response.php');
}

/**
* Class UserController offers static functions relating to users
*/
class UserController {

    /**
     * Saves a UserId, DataKey, Data record based on the keys under the "Data" field in the body.
     *
     * @param $body
     */
    public static function userSave($body) {
        $params = json_decode($body);
        foreach($params->Data as $dataKey => $data) {
            $user = new User($params->UserId, $dataKey, json_encode($data));
            $user->save();
        }
        $response = array(
            'Success' => true
        );
        Response::send(200, $response);
    }
}