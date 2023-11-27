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
    `contacts`.`telegram`,
    `balance`.`balance_client` as balance_client,
    (SELECT COUNT(*) FROM `orders` WHERE `user`.`unique_id` = `orders`.`unique_id`) as order_count,
    (SELECT SUM(`amount`) FROM `orders` WHERE `user`.`unique_id` = `orders`.`unique_id`) as order_sum
FROM `user`
INNER JOIN `balance` ON `user`.`unique_id` = `balance`.`unique_id`
INNER JOIN `role` ON `user`.`unique_id` = `role`.`unique_id`
INNER JOIN `contacts` ON `user`.`unique_id` = `contacts`.`unique_id`
WHERE `role`.`client` = 1
";



$query = DB::connect()->prepare($sql);
$query->execute();
$array = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);

