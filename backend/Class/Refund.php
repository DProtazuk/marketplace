<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
class Refund
{
    function CheckAccountOrder($array, $id): bool
    {
        $orderIds = $array;

        $parameters = [];

        $placeholders = implode(',', array_fill(0, count($orderIds), '?'));

        $sql = "SELECT `accounts`.`id`, `accounts`.`value` FROM `orders` 
        INNER JOIN `account_on_order` ON `orders`.`id` = `account_on_order`.`order_id`
        INNER JOIN `accounts` ON `account_on_order`.`account_id` = `accounts`.`id`
        WHERE `orders`.`unique_id` = ? AND `orders`.`id` = ? AND `accounts`.`id` IN ($placeholders)";
        $stmt = DB::connect()->prepare($sql);

        array_push($parameters, $_COOKIE['unique_id']);
        array_push($parameters, $id);

        foreach ($orderIds as $item) {
            array_push($parameters, $item);
        }



        $stmt->execute($parameters);

        $foundOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($foundOrders) === count($orderIds)) {
            return true;
        }
        else return false;
    }

    function ReturnAccounts($array)
    {
        $accounts = $array;

        $placeholders = implode(',', array_fill(0, count($accounts), '?'));
        $sql = "SELECT * FROM `accounts` WHERE `id` IN ($placeholders)";

        $stm = DB::connect()->prepare($sql);
        $stm->execute($accounts);

        $accounts = $stm->fetchAll(PDO::FETCH_ASSOC);

        if($accounts){
            return $accounts;
        }
        else return false;
    }

}