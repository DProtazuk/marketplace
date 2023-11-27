<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

class Discounts
{
    public function selectId($id) {
        $sql = "SELECT * FROM `discounts` where `id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($id));
        return $query->fetch();
    }

    public function selectName($name) {
        $sql = "SELECT * FROM `discounts` where `name` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($name));
        return $query->fetch();
    }

    public function create($array) {
        $sql = "INSERT INTO `discounts` 
            (`type`, `name`, `quantity`, `data_start`, `data_finish`, `shop`, `percent`, `status`) 
            VALUES (:type, :name, :quantity, :data_start, :data_finish, :shop, :percent, :status)";
        $sth = DB::connect()->prepare($sql);
        $sth->execute($array);
    }

    public function delete($id) {
        $sql = "UPDATE `discounts` SET `status`= 2 WHERE `discounts`.`id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($id));
    }

    public function update($array) {
        $sql = "UPDATE `discounts` SET 
                       `type`= :type, 
                       `name`= :name, 
                       `quantity`= :quantity, 
                       `data_start`= :data_start, 
                       `data_finish`= :data_finish, 
                       `shop`= :shop, 
                       `percent`= :percent 
                WHERE `discounts`.`id` = :id";
        $query = DB::connect()->prepare($sql);
        $query->execute($array);
    }

    public function checkingForUniqueness($name, $id) {
        $sql = "SELECT EXISTS (
            SELECT 1 FROM discounts WHERE name = ? AND id <> ?
        ) AS name_exists";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($name, $id));
        $name_exists = $query->fetchColumn();

        if ($name_exists) {
            return false;
        }
        else return true;

    }
}