<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");
class Reviews
{


    public function Create($array): bool|string
    {
        $DB = DB::connect();
        $sql = "INSERT INTO `reviews`(`unique_id`, `product_id`, `order_id`, `rating`, `dignities`, `disadvantages`, `comment`, `img`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $pdo = $DB->prepare($sql);
        $pdo->execute($array);
        return $DB->lastInsertId();
    }
}