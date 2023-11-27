<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
$role = new Role();

if (!$role->Check('admin')) {
    header("Location: /");
}


require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");


$sql = "SELECT 
    `user`.`unique_id` as unique_id,
    `user`.`name` as user_name,
    `user`.`email` as email,
    `user`.`email` as email,
    `contacts`.`telegram`,
    `shop`.`name` as shop_name,
    `balance`.`balance_seller` as balance_seller
    FROM `user`
    INNER JOIN `balance` ON `user`.`unique_id` = `balance`.`unique_id`
    INNER JOIN `shop` ON `user`.`unique_id` = `shop`.`seller_id`
    INNER JOIN `role` ON `user`.`unique_id` = `role`.`unique_id`
    INNER JOIN `contacts` ON `user`.`unique_id` = `contacts`.`unique_id`
WHERE `role`.`seller` = 1
";



$query = DB::connect()->prepare($sql);
$query->execute();
$array = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);

