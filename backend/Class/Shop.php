<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");

class Shop
{

    public function Create($array): void
    {
        $sth = DB::connect()->prepare("INSERT INTO `shop` SET `seller_id` = :seller_id, `name` = :name, `heading` = :heading, `cover` = :cover, `logo` = :logo, `description` = :description, `lower_description` = :lower_description, `rating` = :rating, `fake_rating` = NULL, `type_rating` = :type_rating");
        $sth->execute($array);
    }

    public function SelectShop($id) {
        $sth = DB::connect()->prepare("SELECT * FROM `shop` WHERE `id` = ?");
        $sth->execute(array($id));
        $sth = $sth->fetch(PDO::FETCH_ASSOC);
        return $sth;
    }

    public function SelectMyShop($id) {
        $sth = DB::connect()->prepare("SELECT * FROM `shop` WHERE `seller_id` = ?");
        $sth->execute(array($id));
        $sth = $sth->fetch(PDO::FETCH_ASSOC);
        return $sth;
    }

    public function ReturnIdShop(){
        $sth = DB::connect()->prepare("SELECT * FROM `shop` WHERE `seller_id` = ?");
        $sth->execute(array($_COOKIE['unique_id']));
        $sth = $sth->fetch(PDO::FETCH_ASSOC);
        return $sth['id'];
    }
    public function Rating($id) {
        $sth = DB::connect()->prepare("SELECT * FROM `shop` WHERE `id` = ?");
        $sth->execute(array($id));
        $sth = $sth->fetch(PDO::FETCH_ASSOC);
        return $sth['rating'];
    }

    public function SelectShopsCategory($category): bool|array
    {
        $sth = DB::connect()->prepare("SELECT DISTINCT `shop`.`id`, `shop`.`name`, `shop`.`heading`, `shop`.`logo`, `shop`.`rating`, `shop`.`fake_rating` FROM `shop` INNER JOIN `product` ON `shop`.`id` = `product`.`shop_id` WHERE `product`.`global_category` = ?");
        $sth->execute(array($category));
        $sth = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $sth;
    }

    public function select() {
        $sth = DB::connect()->prepare("SELECT * FROM `shop`");
        $sth->execute();
        $sth = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $sth;
    }
}