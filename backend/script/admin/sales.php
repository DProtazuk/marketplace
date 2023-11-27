<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";


if(isset($_POST['type'])){
    if($_POST['type'] === "sales"){
        sales();
    }
}


function sales() {
    $db = DB::connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


    $limit = 5;

    $page = $_POST['page'];

    if ($page == 1) {
        $offset = 0;
    } else {
        $page = $page-1;
        $offset = $page * $limit;
    }

    $start =  date('Y-m-d 00:00:00', strtotime($_POST['start']));
    $finish = date('Y-m-d 23:59:59', strtotime($_POST['finish']));

    {
        $parameters = [];

        $select = "COUNT(*) as count";

        $sql = "SELECT 
            ".$select."
                FROM `user` 
                INNER JOIN `orders` ON `user`.`unique_id` = `orders`.`unique_id`
                INNER JOIN `product` ON `orders`.`product_id` = `product`.`id`
                INNER JOIN `shop` ON `product`.`shop_id` = `shop`.`id`
                WHERE  `orders`.`data` >= ? AND `orders`.`data` <= ?";

        array_push($parameters, $start);
        array_push($parameters, $finish);

        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            $sql .= " AND (`orders`.`id` LIKE ? OR `product`.`name` LIKE ? OR `shop`.`name` LIKE ?)";
            $key = '%' . $search . '%';
            array_push($parameters, $key);
            array_push($parameters, $key);
            array_push($parameters, $key);
        }

        $query = $db->prepare($sql);
        $query->execute($parameters);
        $array =  $query->fetch();
        $count = $array['count'];
    }


    {
        $parameters = [];

        $select = "
        `orders`.`id` as orders_id,
        `orders`.`data` as orders_data,
        `orders`.`quantity` as orders_quantity,
        `orders`.`amount` as orders_amount,
        `shop`.`name` as shop_name,
        `shop`.`id` as shop_id,
        `product`.`name` as product_name,
        `product`.`id` as product_id,
        `user`.`unique_id` as user_unique_id,
        `user`.`name` as user_name"
        ;

        $sql = "SELECT 
            ".$select."
                FROM `user` 
                INNER JOIN `orders` ON `user`.`unique_id` = `orders`.`unique_id`
                INNER JOIN `product` ON `orders`.`product_id` = `product`.`id`
                INNER JOIN `shop` ON `product`.`shop_id` = `shop`.`id`
                WHERE  `orders`.`data` >= ? AND `orders`.`data` <= ?";

        array_push($parameters, $start);
        array_push($parameters, $finish);

        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            $sql .= " AND (`orders`.`id` LIKE ? OR `product`.`name` LIKE ? OR `shop`.`name` LIKE ?)";
            $key = '%' . $search . '%';
            array_push($parameters, $key);
            array_push($parameters, $key);
            array_push($parameters, $key);
        }
        $sql .= " ORDER BY `orders`.`data` DESC";

        $sql .= " LIMIT ? OFFSET ?";

        array_push($parameters, $limit);
        array_push($parameters, $offset);

        $query = $db->prepare($sql);
        $query->execute($parameters);
        $array =  $query->fetchAll(PDO::FETCH_ASSOC);


        $mass = [
            'count' => $count,
            'array' => $array
        ];

        echo json_encode($mass);
    }
}