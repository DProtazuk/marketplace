<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");

class PaymentDetailsType
{

    public function Select() {
        $sql = "SELECT * FROM `payment_details_type`";
        $query = DB::connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function SelectOne($id) {
        $sql = "SELECT * FROM `payment_details_type` WHERE `id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($id));
        $array = $query->fetch();
        return $array['name'];
    }
}