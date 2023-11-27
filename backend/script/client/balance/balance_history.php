<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";


if (!isset($_POST['type'])){
    header("Location: /");
}

$start = $_POST['start'];
$start = date('Y-m-d', strtotime($start));

$finish = $_POST['finish'];
$finish = date('Y-m-d', strtotime($finish . ' +1 day'));



if($_POST['type'] == "coming") {

    $sql = "SELECT `status`.`name`, `balance_history_client_coming`.`data`, `balance_history_client_coming`.`payment_details`, `balance_history_client_coming`.`amount` 
        FROM `balance_history_client_coming` INNER JOIN `status` ON `balance_history_client_coming`.`status` = `status`.`id` 
        WHERE data >= :start_date AND data <= :end_date AND `balance_history_client_coming`.`unique_id` = :unique_id";
    $stmt = DB::connect()->prepare($sql);

    // Выполнение запроса и получение результатов
    $stmt->execute(array(
        "start_date" => $start,
        "end_date" => $finish,
        "unique_id" => $_COOKIE['unique_id']
    ));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
}
if($_POST['type'] == "expenditure") {
    $sql = "SELECT `status`.`name`, `balance_history_client_expenditure`.`data`, `balance_history_client_expenditure`.`content` as payment_details, `balance_history_client_expenditure`.`amount` , `balance_history_client_expenditure`.`type`
        FROM `balance_history_client_expenditure` INNER JOIN `status` ON `balance_history_client_expenditure`.`status` = `status`.`id` 
        WHERE data >= :start_date AND data <= :end_date AND `balance_history_client_expenditure`.`unique_id` = :unique_id";
    $stmt = DB::connect()->prepare($sql);

    // Выполнение запроса и получение результатов
    $stmt->execute(array(
        "start_date" => $start,
        "end_date" => $finish,
        "unique_id" => $_COOKIE['unique_id']
    ));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
}
