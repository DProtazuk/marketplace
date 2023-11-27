<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php";

if (isset($_POST['value'])) {
    if (isset($_COOKIE['unique_id'])) {
        $sql = "INSERT INTO `payment_details`(`unique_id`, `type`, `value`) VALUES (?, ?, ?)";

        $sql = DB::connect()->prepare($sql);
        $sql->execute(array($_COOKIE['unique_id'],  $_POST['type'], $_POST['value']));
        header( "Location: /page/client/referral_program");
    }
    else header( "Location: /");
}
else header( "Location: /");