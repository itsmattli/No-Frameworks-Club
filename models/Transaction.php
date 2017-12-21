<?php

class Transaction {
    protected $transactionId;
    protected $userId;
    protected $currencyAmount;
    protected $verifier;

    public function __construct($transactionId, $userId, $currencyAmount) {
        $this->$transactionId = $transactionId;
        $this->userId = $userId;
        $this->currencyAmount = $currencyAmount;
        $this->verifier = sha1($transactionId . $userId . $currencyAmount);
    }

    public function save() {

    }

    public function load() {

    }
}