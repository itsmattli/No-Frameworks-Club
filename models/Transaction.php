<?php
if(file_exists('../config/dbConnection.php')) {
    include_once('../config/dbConnection.php');
}

/**
 * Establish DB Connection
 */
$db = DbConnection::getConnection();

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
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        if($this->verify()) {
            $query = "INSERT INTO transactions VALUES ("
                . "'" . $this->transactionId . "',"
                . "'" . $this->userId . "',"
                . "'" . $this->currencyAmount . "',"
                . "'" . $this->verifier . "')";
            try {
                mysqli_query($db, $query);
            } catch (mysqli_sql_exception $e) {
                $response = array(
                    'error' => $e->getMessage());
                http_response_code(400);
                header('Content-Type: application/json');
                die(json_encode($response));
            }
            return true;
        } else {

            $response = array(
                'error' => 'improper verifier string');
            http_response_code(400);
            header('Content-Type: application/json');
            die(json_encode($response));
        }
    }
}