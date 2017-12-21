<?php

if(file_exists('../models/Transaction.php')){
    include_once('../models/Transaction.php');
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
            echo json_encode($response);
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
                $result = mysqli_query($db, $query);
            } catch (mysqli_sql_exception $e) {
                $response = array(
                    'error' => $e->getMessage());
                http_response_code(400);
                header('Content-Type: application/json');
                die(json_encode($response));
            }
            $row = mysqli_fetch_assoc($result);
            $response = array(
                'TransactionCount' => $row['TransactionCount'],
                'CurrencySum' => ($row['CurrencySum']) ? $row['CurrencySum'] : 0
            );
            http_response_code(200);
            header('Content-Type: application/json');
            die(json_encode($response));
        }
    }

    public static function validate($params) {
        if(isset($params->UserId) && count((array) $params) != 1) {
            $response = array(
                'error' => 'incorrect parametres provided in POST request');
            http_response_code(400);
            header('Content-Type: application/json');
            die(json_encode($response));
        } else {
            return true;
        }
    }
}