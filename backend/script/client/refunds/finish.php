<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Refund.php";

if(isset($_POST['array'])) {
    ReturnArray();
}


function ReturnArray() {
    $Refund = new Refund();

    $orderIdsString = $_POST['array'];
    $orderIdsArray = explode(',', $orderIdsString);
    $orderIdsArray = array_map('trim', $orderIdsArray);

    $accounts = $Refund->ReturnAccounts($orderIdsArray);
    echo json_encode($accounts);
}