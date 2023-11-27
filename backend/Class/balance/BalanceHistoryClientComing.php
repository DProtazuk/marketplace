<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");

class BalanceHistoryClientComing
{
    public function Create($array): void
    {
        $sql = "INSERT INTO `balance_history_client_coming`(`unique_id`, `type`, `data`, `payment_details`, `amount`, `status`) VALUES (:unique_id, :type, :data, :payment_details, :amount, :status)";
        $sth = DB::connect()->prepare($sql);
        $sth->execute($array);
    }
}