<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/User.php";

if(isset($_POST['action'])) {
    switch ($_POST['action']) {
        case "select_coming":
            select_coming();
            break;
        case "select_orders":
            select_orders();
            break;
        case 2:
            echo "i equals 2";
            break;
    }
}

function select_coming() {
    $connect = DB::connect();
    $user = new User();

    $start = $_POST['start'];
    $finish = $_POST['finish'];

    $sql = "SELECT `orders`.`amount` as 'orders_amount', `referral_transfers`.`amount` as 'amount', `referral_transfers`.`ReferralPercentage`, `referral_transfers`.`status`, `orders`.`data` FROM `referral_transfers` 
        INNER JOIN `orders` ON `referral_transfers`.`id_order` = `orders`.`id` 
         WHERE `referral_transfers`.`id_referral` = ? AND `orders`.`data` >= ? AND `data` <= ?";

    $query = $connect->prepare($sql);
    $query->execute(array($user->ReturnInfoUser('referral_link'), $start,  date("Y-m-d", strtotime($finish . " +1 day")) ));
    $array = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($array);
}

function select_orders() {
    $connect = DB::connect();

    $start = $_POST['start'];
    $finish = $_POST['finish'];

    $sql = "SELECT `withdrawal_orders`.`data`, `payment_details_type`.`name`, `withdrawal_orders`.`payment_details`, `withdrawal_orders`.`amount`, `withdrawal_orders`.`status` FROM `withdrawal_orders` 
    INNER JOIN `payment_details_type` ON `withdrawal_orders`.`payment_details_type` = `payment_details_type`.`id`
    WHERE `withdrawal_orders`.`unique_id` = ? AND `withdrawal_orders`.`data` >= ? AND `data` <= ?";

    $query = $connect->prepare($sql);
    $query->execute(array($_COOKIE['unique_id'], $start,  date("Y-m-d", strtotime($finish . " +1 day")) ));
    $array = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($array);
}

