<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php";

if (isset($_POST['id'])) {
    if (isset($_POST['search'])) {
        $parameters = [];

        $sql = "SELECT `accounts`.`id`, `accounts`.`value` FROM `orders` 
        INNER JOIN `account_on_order` ON `orders`.`id` = `account_on_order`.`order_id`
        INNER JOIN `accounts` ON `account_on_order`.`account_id` = `accounts`.`id`
        WHERE `orders`.`id` = ?  AND (`accounts`.`id` LIKE ?)";

        $key = '%' . $_POST['search'] . '%';
        array_push($parameters, $_POST['id']);
        array_push($parameters, $key);

        if (!empty($_POST['hiddenInputValue'])) {
            $hiddenInputValue = explode(",", $_POST['hiddenInputValue']);

            foreach ($hiddenInputValue as $item) {
                $sql .= " AND `accounts`.`id` <> ?";
                array_push($parameters, $item);
            }
        }

        $pdo = DB::connect()->prepare($sql);
        $pdo->execute($parameters);
        $arraySearch = $pdo->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($_POST['hiddenInputValue'])) {
            $parameters = [];

            $sql = "SELECT `accounts`.`id`, `accounts`.`value` FROM `orders` 
        INNER JOIN `account_on_order` ON `orders`.`id` = `account_on_order`.`order_id`
        INNER JOIN `accounts` ON `account_on_order`.`account_id` = `accounts`.`id`
        WHERE `orders`.`id` = ? AND `accounts`.`id` IN (";
            array_push($parameters, $_POST['id']);

            $hiddenInputValue = explode(",", $_POST['hiddenInputValue']);
            $placeholders = implode(',', array_fill(0, count($hiddenInputValue), '?'));
            $sql .= $placeholders . ")";


            foreach ($hiddenInputValue as $item) {
                array_push($parameters, $item);
            }

            $pdo = DB::connect()->prepare($sql);
            $pdo->execute($parameters);
            $arrayCheck = $pdo->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            $arrayCheck = [];
        }

        $mass = [
            'search' => $arraySearch,
            'check' => $arrayCheck
        ];

        echo json_encode($mass);
    } else {
        $id = $_POST['id'];

        $sql = "SELECT `accounts`.`id`, `accounts`.`value` FROM `orders` 
        INNER JOIN `account_on_order` ON `orders`.`id` = `account_on_order`.`order_id`
        INNER JOIN `accounts` ON `account_on_order`.`account_id` = `accounts`.`id`
        WHERE `orders`.`id` = ?";

        $pdo = DB::connect()->prepare($sql);
        $pdo->execute(array($id));
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($array);
    }
} else return false;