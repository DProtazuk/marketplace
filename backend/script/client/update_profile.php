<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php";

if (isset($_COOKIE['unique_id'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $parameters = [];
    array_push($parameters, $name);
    array_push($parameters, $email);

    $sql = "UPDATE `user` SET `name` = ?, `email` = ?";

    if (!empty($_POST['password'])) {
        $sql .= ", `password` = ?";
    }

    $sql .= " WHERE `unique_id` = ?";
    array_push($parameters, $_COOKIE['unique_id']);

    $sql = DB::connect()->prepare($sql);
    $sql->execute($parameters);


    if (!empty($_POST['telegram']) || !empty($_POST['too_fa'])) {
        $parameters = [];


        $sql = "UPDATE `contacts` SET ";

        if (!empty($_POST['telegram'])) {
            $sql .= "`telegram` = ?, ";
            array_push($parameters, $_POST['telegram']);
        }

        if (!empty($_POST['too_fa'])) {
            $sql .= "`2FA` = ?, ";
            array_push($parameters, $_POST['too_fa']);
        }

        $sql = trim($sql);
        $sql = substr($sql, 0, -1);
        $sql = DB::connect()->prepare($sql);
        $sql->execute($parameters);
    }
}
header("Location: /page/client/profile.php");


