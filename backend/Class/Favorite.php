<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
class Favorite
{
    public function Select() {
        $sql = "SELECT * FROM `favorite` 
            INNER JOIN `product` ON `favorite`.`id_product` = `product`.`id`
            INNER JOIN `shop` ON `product`.`shop_id` = `shop`.`id`
        WHERE `favorite`.`unique_id` = ? ";

        $query = DB::connect()->prepare($sql);
        $query->execute(array($_COOKIE['unique_id']));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Add($id_product) {
        $sth = DB::connect()->prepare("INSERT INTO `favorite` SET `unique_id` = :unique_id, `id_product` = :id_product");
        $sth->execute(array('unique_id' => $_COOKIE['unique_id'], 'id_product' => $id_product));
    }

    public function Delete($id_product) {
        $sth = DB::connect()->prepare("DELETE FROM `favorite` WHERE `unique_id` = :unique_id AND `id_product` = :id_product");
        $sth->execute(array('unique_id' => $_COOKIE['unique_id'], 'id_product' => $id_product));
    }

    public function check($id_product) {
        $sth = DB::connect()->prepare("SELECT * FROM `favorite` WHERE `unique_id` = :unique_id AND `id_product` = :id_product");
        $sth->execute(array('unique_id' => $_COOKIE['unique_id'], 'id_product' => $id_product));
        $array = $sth->fetch(PDO::FETCH_ASSOC);

        if($array){
            return true;
        }
        else {
            return false;
        }
    }
}