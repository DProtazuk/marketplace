<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
$role = new Role();

if (!$role->Check('admin')) {
    header("Location: /");
}

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

if(isset($_GET['id'])) {
    $sql = "DELETE FROM `global_categories` WHERE `id` = ?";
    $query = DB::connect()->prepare($sql);
    $query->execute(array($_GET['id']));
    header("Location: /page/admin/setting/search.php");
}
else header("Location: /");