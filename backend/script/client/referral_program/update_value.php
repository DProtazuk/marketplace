<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php";

if (isset($_POST['value'])) {
    if (isset($_COOKIE['unique_id'])) {
        $sql = "UPDATE `payment_details` SET `type` = ?, `value`= ? WHERE `unique_id` = ?";
        $sql = DB::connect()->prepare($sql);
        $sql->execute(array($_POST['type'], $_POST['value'], $_COOKIE['unique_id']));
        header( "Location: /page/client/referral_program.php");
    }
    else header( "Location: /");
}
else header( "Location: /");