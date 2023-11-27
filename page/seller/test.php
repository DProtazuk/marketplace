<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/ApplicationsForSeller.php");

$role = new Role();
$ApplicationsForSeller = new ApplicationsForSeller();

if ($role->Check('unauthorized') || $role->Check('seller')) {
    header("Location: /");
}

if(!$ApplicationsForSeller->check()){
    header("Location: /");
}

$array = [
    'unique_id' => $_COOKIE['unique_id'],
    'data' => date('Y-m-d H:i:s'),
    'payment' => 2,
    'status' => 2
];

$ApplicationsForSeller->create($array);



header('Location: /page/public/main');