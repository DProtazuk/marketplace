<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

//Единиц продано
function ReturnUnitsSold() {
    $sql = "SELECT  SUM(`orders`.`quantity`) AS 'total_quantity' FROM `orders`
        INNER JOIN `product` ON `orders`.`product_id` = `product`.`id`
        INNER JOIN `shop` ON `product`.`shop_id` = `shop`.`id` 
        WHERE `shop`.`seller_id` = ? AND `orders`.`data` <= DATE_SUB(NOW(), INTERVAL 1 DAY)";
    $query = DB::connect()->prepare($sql);
    $query->execute(array($_COOKIE['unique_id']));
    $result = $query->fetch();
    $totalQuantity = $result['total_quantity'];

    if($totalQuantity != 0) {
        return  $totalQuantity;
    }
    else return 0;
}

function ReturnUnitsSoldAdmin($id) {
    $sql = "SELECT  SUM(`orders`.`quantity`) AS 'total_quantity' FROM `orders`
        INNER JOIN `product` ON `orders`.`product_id` = `product`.`id`
        INNER JOIN `shop` ON `product`.`shop_id` = `shop`.`id` 
        WHERE `shop`.`seller_id` = ? AND `orders`.`data` <= DATE_SUB(NOW(), INTERVAL 1 DAY)";
    $query = DB::connect()->prepare($sql);
    $query->execute(array($id));
    $result = $query->fetch();
    $totalQuantity = $result['total_quantity'];

    if($totalQuantity != 0) {
        return  $totalQuantity;
    }
    else return 0;
}

function ReturnNumberOfPurchases() {
    $days = 1;

// SQL-запрос с подсчетом количества покупок, где "data" прошло указанное количество суток
    $sql = "SELECT COUNT(*) AS 'purchase' FROM `orders` INNER JOIN `product` ON `orders`.`product_id` = `product`.`id`
        INNER JOIN `shop` ON `product`.`shop_id` = `shop`.`id` 
        WHERE `shop`.`seller_id` = ? AND `orders`.`data` <= DATE_SUB(NOW(), INTERVAL 1 DAY)" ;
    $query = DB::connect()->prepare($sql);
    $query->execute(array($_COOKIE['unique_id']));
    $result = $query->fetch();
    $purchaseCount = $result['purchase'];

    if($purchaseCount != 0) {
        return  $purchaseCount;
    }
    else return 0;
}

function ReturnNumberOfPurchasesAdmin($id) {
    $days = 1;

// SQL-запрос с подсчетом количества покупок, где "data" прошло указанное количество суток
    $sql = "SELECT COUNT(*) AS 'purchase' FROM `orders` INNER JOIN `product` ON `orders`.`product_id` = `product`.`id`
        INNER JOIN `shop` ON `product`.`shop_id` = `shop`.`id` 
        WHERE `shop`.`seller_id` = ? AND `orders`.`data` <= DATE_SUB(NOW(), INTERVAL 1 DAY)" ;
    $query = DB::connect()->prepare($sql);
    $query->execute(array($id));
    $result = $query->fetch();
    $purchaseCount = $result['purchase'];

    if($purchaseCount != 0) {
        return  $purchaseCount;
    }
    else return 0;
}

function ReturnRevenue(){
    $sql = "SELECT  SUM(`orders`.`amount`) AS 'amount' FROM `orders`
        INNER JOIN `product` ON `orders`.`product_id` = `product`.`id`
        INNER JOIN `shop` ON `product`.`shop_id` = `shop`.`id` 
        WHERE `shop`.`seller_id` = ? AND `orders`.`data` <= DATE_SUB(NOW(), INTERVAL 1 DAY)";
    $query = DB::connect()->prepare($sql);
    $query->execute(array($_COOKIE['unique_id']));
    $result = $query->fetch();
    $amount = $result['amount'];

    if($amount != 0) {
        return  $amount;
    }
    else return 0;
}

function ReturnRevenueAdmin($id){
    $sql = "SELECT  SUM(`orders`.`amount`) AS 'amount' FROM `orders`
        INNER JOIN `product` ON `orders`.`product_id` = `product`.`id`
        INNER JOIN `shop` ON `product`.`shop_id` = `shop`.`id` 
        WHERE `shop`.`seller_id` = ? AND `orders`.`data` <= DATE_SUB(NOW(), INTERVAL 1 DAY)";
    $query = DB::connect()->prepare($sql);
    $query->execute(array($id));
    $result = $query->fetch();
    $amount = $result['amount'];

    if($amount != 0) {
        return  $amount;
    }
    else return 0;
}