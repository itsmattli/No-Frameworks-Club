<?php

if(file_exists('../models/Transaction.php')){
    include_once('../models/Transaction.php');
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

/**
 * Class TransactionController offers static functions relating to transactions
 */
class TransactionController {

    /**
     * Saves a transaction
     * @param $body
     */
    public static function transaction($body) {
        $params = json_decode($body);
        $transaction = new Transaction(
            $params->TransactionId,
            $params->UserId,
            $params->CurrencyAmount,
            $params->Verifier);
        if($transaction->save()) {
            $response = array(
                'Success' => true);
            Response::send(200, $response);
        }
    }

    /**
     * Counts transactions and currency sum for a userId
     * @param $body
     */
    public static function transactionStats($body)
    {
        global $db;
        $params = json_decode($body);
        if (self::validate($params)) {
            $query = "SELECT COUNT(transactionId) AS TransactionCount, SUM(currencyAmount) AS CurrencySum
              FROM transactions
              WHERE userId ='" . $params->UserId . "'";
            try {
                $result = $db->query($query);
            } catch (mysqli_sql_exception $e) {
                $response = array(
                    'error' => $e->getMessage());
                Response::send(400, $response);
            }
            $row = $result->fetch_assoc();
            $response = array(
                'TransactionCount' => $row['TransactionCount'],
                'CurrencySum' => ($row['CurrencySum']) ? $row['CurrencySum'] : 0
            );
            Response::send(200, $response);
        }
    }

    public static function validate($params) {
        if(isset($params->UserId) && count((array) $params) != 1) {
            $response = array(
                'error' => 'incorrect parametres provided in POST request');
            Response::send(400, $response);
        } else {
            return true;
        }
    }
}