<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

class ParametersProduct
{
    public function SelectParametersCategory($category){
        $query = "SELECT * FROM `parameters_product` WHERE `id_categories` = ?";
        $sth = DB::connect()->prepare($query);
        $sth->execute(array($category));
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function insert($array) {
        $dbh = DB::connect();
        $sql = "INSERT INTO `parameters_product` (`id_categories`, `name`, `type`, `mass`, `status`) 
                    VALUES ( :id_categories, :name, :type, :mass, :status)";
        $query = $dbh->prepare($sql);
        $query->execute($array);
    }

    public function update($array) {
        $query = "UPDATE `parameters_product` SET `name` = :name, `type` = :type, `mass` = :mass WHERE `id` = :id";
        $sth = DB::connect()->prepare($query);
        $sth->execute($array);
    }
}