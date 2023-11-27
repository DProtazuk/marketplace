<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

class ApplicationsForSeller
{
    function check() {
        $sql = "SELECT * FROM `applications_for_seller` WHERE `unique_id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($_COOKIE['unique_id']));
        $array = $query->fetch();

        if ($array)
            return false;
        else return true;
    }

    function create($array) {


        $sql = "INSERT INTO `applications_for_seller`(`unique_id`, `data`, `payment`, `status`) 
            VALUES (:unique_id, :data, :payment, :status)";

        $query = DB::connect()->prepare($sql);
        $query->execute($array);
    }

    function updateStatus($array) {
        $sth = DB::connect()->prepare("UPDATE `applications_for_seller` SET `status` = :status WHERE `unique_id` = :unique_id");
        $sth->execute($array);
    }
}