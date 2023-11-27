<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
class GlobalCategories
{
    public function SelectGlobalCategories(): bool|array
    {
        $query = "SELECT * FROM `global_categories` WHERE `status` = 1";
        $sth = DB::connect()->prepare($query);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select_Global_categoriesID(){
        $query = "SELECT `id` FROM `global_categories`";
        $sth = DB::connect()->prepare($query);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    function SelectStartIdGlobal_categories() {
        $query = "SELECT `id` FROM `global_categories` LIMIT 1";
        $sth = DB::connect()->prepare($query);
        $sth->execute();
        $array = $sth->fetch(PDO::FETCH_ASSOC);
        return $array['id'];
    }

    function searchGlobalCategories($name) {
        $query = "SELECT `id` FROM `global_categories` WHERE `name` = ?";
        $sth = DB::connect()->prepare($query);
        $sth->execute(array($name));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    function searchGlobalCategoriesId($id) {
        $query = "SELECT * FROM `global_categories` WHERE `id` = ? AND `status` = 1";
        $sth = DB::connect()->prepare($query);
        $sth->execute(array($id));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($array) {
        $dbh = DB::connect();
        $sql = "INSERT INTO `global_categories`(`name`, `img`, `status`) VALUES ( :name, :img, :status)";
        $query = $dbh->prepare($sql);
        $query->execute($array);
        return $dbh->lastInsertId();
    }

    public function deleteGlobalCategories($id) {
        $query = "UPDATE `global_categories` SET `status` = 2 WHERE `id` = ?";
        $sth = DB::connect()->prepare($query);
        $sth->execute(array($id));
    }

    public function update($array) {
        $query = "UPDATE `global_categories` SET `name` = :name, `img` = :img WHERE `id` = :id";
        $sth = DB::connect()->prepare($query);
        $sth->execute($array);
    }
}