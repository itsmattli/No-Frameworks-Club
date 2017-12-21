<?php

if(file_exists('../utils/dbConnection.php')) {
    require_once('../utils/dbConnection.php');
}

if(file_exists('../utils/Response.php')) {
    require_once('../utils/Response.php');
}

/**
 * Establish DB Connection
 */
$db = DbConnection::getConnection();

/**
 * Class Transaction represents one row in the Transactions table.
 */
class Transaction {
    const SECRET_KEY = "NwvprhfBkGuPJnjJp77UPJWJUpgC7mLz";
    var $transactionId;
    var $userId;
    var $currencyAmount;
    var $verifier;

    /**
     * Transaction constructor
     * @param $transactionId
     * @param $userId
     * @param $currencyAmount
     * @param $verifier
     */
    public function __construct($transactionId, $userId, $currencyAmount, $verifier) {
        $this->transactionId = $transactionId;
        $this->userId = $userId;
        $this->currencyAmount = $currencyAmount;
        $this->verifier = $verifier;
    }

    /**
     * Checks if Secret Key + TransactionId + UserId + CurrencyAmount SHA-1 Hash == Verifier
     * @return bool
     */
    public function verify() {
        if($this->verifier != sha1(self::SECRET_KEY . $this->transactionId . $this->userId . $this->currencyAmount)) {
            return false;
        }
        return true;
    }

    /**
     * Stores the transaction into the DB
     */
    public function save() {
        global $db;
        if($this->verify()) {
            $query = "INSERT INTO transactions VALUES ("
                . "'" . $this->transactionId . "',"
                . "'" . $this->userId . "',"
                . "'" . $this->currencyAmount . "',"
                . "'" . $this->verifier . "')";
            try {
                $db->query($query);
            } catch (mysqli_sql_exception $e) {
                $response = array(
                    'error' => $e->getMessage());
                Response::send(400, $response);
            }
            return true;
        } else {
            $response = array(
                'error' => 'improper verifier string');
            Response::send(400, $response);
        }
    }
}