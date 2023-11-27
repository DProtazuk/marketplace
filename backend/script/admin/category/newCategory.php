<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
$role = new Role();

if (!$role->Check('admin')) {
    header("Location: /");
}

$sql = "SELECT * FROM `global_categories` WHERE `status` = 1";

if (!empty($_POST['search'])) {
    $search = $_POST['search'];
    $sql .= " AND `name` LIKE ?";

    $key = '%' . $search . '%';

    $query = DB::connect()->prepare($sql);
    $query->execute(array($key));
}else {
    $query = DB::connect()->prepare($sql);
    $query->execute();
}

$array = $query->fetchAll(PDO::FETCH_ASSOC);



echo json_encode($array);