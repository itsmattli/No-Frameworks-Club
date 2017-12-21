<?php

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
                Response::error(400, $e->getMessage());
            }
            return true;
        } else {
            Response::error(400, 'Verifier String Incorrect');
        }
    }
}