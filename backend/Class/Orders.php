<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

class Orders
{
    public function Select() {
        $sql = "SELECT * FROM `orders` 
        WHERE `orders`.`unique_id` = ? ";

        $query = DB::connect()->prepare($sql);
        $query->execute(array($_COOKIE['unique_id']));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function ReturnOrderNum($id) {
        $stmt = DB::connect()->prepare("SELECT COUNT(*) as count FROM orders WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function Create($array): bool|string
    {
        $db = DB::connect();
        $sth = $db->prepare("INSERT INTO `orders` SET `unique_id` = :unique_id, `product_id` = :product_id, `price` = :price, `amount` = :amount, `amount_seller` = :amount_seller, `quantity` = :quantity, `data` = :data, `status` = :status");

        $sth->execute($array);
        return $db->lastInsertId();
    }

    public function OrderVerification($id)
    {
        $unique_id = $_COOKIE['unique_id'];
        $sql = "SELECT `data` FROM `orders` WHERE `unique_id` = ? AND `id` = ?";
        $pdo =  DB::connect()->prepare($sql);
        $pdo->execute(array($unique_id, $id));
        $array = $pdo->fetch(PDO::FETCH_ASSOC);

        if (!$array) {
            return false;
        }
        else {
            $currentDatetime = time();
            $dateString = $array['data'];
            $variableDatetime = strtotime($dateString);

            $difference = $currentDatetime - $variableDatetime;
            $secondsInDay = 24 * 60 * 60;

            if ($difference <= $secondsInDay) {
                return true;
            } else {
                return false;
            }
        }
    }

    //продажи сегодня
    public function salesToday() {
        $parameters = [];
        $start =  date('Y-m-d 00:00:00');
        $finish =  date('Y-m-d 23:59:59');

        array_push($parameters, $start);
        array_push($parameters, $finish);

        $db = DB::connect();
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $sql = "SELECT 
                SUM(`quantity`) as quantity,
                COUNT(*) as count,
                SUM(`amount`) as amount
                FROM `orders` 
                WHERE `data` >= ? AND `data` <= ?";

        $query = $db->prepare($sql);
        $query->execute($parameters);
        return $query->fetch();
    }
}