<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
class WithdrawalOrders
{

    public function Create($unique_id, $data, $payment_details_type, $payment_details, $amount, $status) {
        $sql = "INSERT INTO `withdrawal_orders`(`unique_id`, `data`, `payment_details_type`, `payment_details`, `amount`, `status`) VALUES (?, ?, ?, ?, ?, ?)";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($unique_id, $data, $payment_details_type, $payment_details, $amount, $status));
    }
}