<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/balance/Balance.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/WithdrawalOrders.php";

if(!isset($_COOKIE['unique_id'])) {
    header("Location: /");
}



if (!isset($_POST['value']) || empty($_POST['value'])) {
    // Переменная отсутствует или пустая
    header("Location: /");
}

$value = $_POST['value'];

if($value < 30) {
    header( "Location: /page/client/referral_program.php?min=true");
}

$balance = new Balance();

if($balance->ReturnBalance('balance_referral') >= $value) {
    $WithdrawalOrders = new WithdrawalOrders();

    $data = date('Y-m-d H:i:s');

    $sql = "SELECT * FROM `payment_details` WHERE `unique_id` = ?";
    $query = DB::connect()->prepare($sql);
    $query->execute(array($_COOKIE['unique_id']));
    $array = $query->fetch();

    if($array){
        $WithdrawalOrders->Create($_COOKIE['unique_id'], $data, $array['type'], $array['value'], $value, "Competed");
        $balance->WithdrawalOfReferralFunds($value);
        header( "Location: /page/client/referral_program.php");
    }
    else  header( "Location: /page/client/referral_program.php");

}
else header( "Location: /page/client/referral_program.php?max=true");


