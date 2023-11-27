<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");
class Subcategories
{

    public function SelectAll($id): bool|array
    {
        $query = "SELECT * FROM `subcategories` WHERE `id_global_categorie` = ? AND `status` = 1";
        $sth = DB::connect()->prepare($query);
        $sth->execute(array($id));
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    private function SelectParameters($id): bool|array
    {
        $sth = DB::connect()->prepare("SELECT * FROM `parameters_product` WHERE `id_categories` = ? AND `status` = 1");
        $sth->execute([$id]);
        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function SelectCategoryEndParameters($id): bool|string
    {
        $arrayCategory = $this->SelectAll($id);
        $arrayParameters = $this->SelectParameters($id);
        $array = array(
            "0" => $arrayCategory,
            "1" => $arrayParameters
        );

        return json_encode($array);
    }

    public function insert($array) {
        $dbh = DB::connect();
        $sql = "INSERT INTO `subcategories`(`id_global_categorie`, `name`, `status`) VALUES ( :id_global_categorie, :name, :status)";
        $query = $dbh->prepare($sql);
        $query->execute($array);
    }

    public function update($array) {
        $query = "UPDATE `subcategories` SET `name` = :name WHERE `id` = :id";
        $sth = DB::connect()->prepare($query);
        $sth->execute($array);
    }
}