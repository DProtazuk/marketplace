<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");

class BalanceHistoryClientExpenditure
{
    public function Create($array): void
    {
        $sql = "INSERT INTO `balance_history_client_expenditure`(`unique_id`, `type`, `data`, `content`, `amount`, `status`) VALUES (:unique_id, :type, :data, :content, :amount, :status)";
        $sth = DB::connect()->prepare($sql);
        $sth->execute($array);
    }
}