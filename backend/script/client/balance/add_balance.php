<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/balance/Balance.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/balance/BalanceHistoryClientComing.php";

if(!isset($_POST['amount'])){
    return false;
}
else {

    try {
        $balance = new Balance();
        $history = new BalanceHistoryClientComing();


        $amount = $_POST['amount'];
        date_default_timezone_set('Europe/Moscow');

        $array = array(
            'unique_id' => $_COOKIE['unique_id'],
            'type' => 'replenishment',
            'data' => date('Y-m-d H:i:s'),
            'payment_details' => 'USDT     666vh654gcjtrhhc64cfhkjghjhvf65fhgvyt677877thjb',
            'amount' => $amount,
            'status' => 1
        );

        $balance->AddBalanceClient($amount, $_COOKIE['unique_id']);
        $history->Create($array);

        header('Location: /page/client/balance');

    } catch (PDOException $e){
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
