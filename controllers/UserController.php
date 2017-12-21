<?php

if(file_exists('../models/User.php')){
    require_once('../models/User.php');
}

if(file_exists('../utils/DbConnection.php')) {
    require_once('../utils/DbConnection.php');
}

if(file_exists('../utils/Response.php')) {
    require_once('../utils/Response.php');
}

/**
 * Establish DB Connection
 */
$db = DbConnection::getConnection();

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

    /**
     * Loads a user's data key and values.
     *
     * @param $body
     */
    public static function userLoad($body) {
        global $db;
        $params = json_decode($body);
        $query = "SELECT * from users
            WHERE userId = '" . $params->UserId . "'";
        try {
            $result = $db->query($query);
        } catch (mysqli_sql_exception $e) {
            Response::error(400, $e->getMessage());
        }

        if($result->num_rows == 0){
            $response = [];
            Response::sendForceObject(200, $response);
        } else {
            $response['UserId'] = $params->UserId;
            $response['Data'] = array();
            while($row = $result->fetch_assoc()) {
                $dataKey = $row['dataKey'];
                $data = json_decode($row['data']);
                $response['Data'][$dataKey] = $data;
            }
            Response::sendForceObject(200, $response);
        }
    }
}