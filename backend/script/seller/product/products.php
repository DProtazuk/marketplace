<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Role.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/MyFunction.php";

if(isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === "statistics") {
        statistics();
    }
    if($action === "selectProduct") {
        selectProduct();
    }
    if($action === "renderModalLoading") {
        renderModalLoading();
    }
}

function statistics() {
    //Кол-во товаров и Товаров на сумму
    {
        $sql = "SELECT 
            COUNT(*) as count,
            SUM(`product`.`price` * `product`.`quantity`) AS sum
            FROM `user`
            INNER JOIN `shop` ON `user`.`unique_id` = `shop`.`seller_id`
            INNER JOIN `product` ON `shop`.`id` = `product`.`shop_id`
            WHERE `user`.`unique_id` = ?
        ";

        $query = DB::connect()->prepare($sql);
        $query->execute(array($_COOKIE['unique_id']));
        $array = $query->fetch(PDO::FETCH_ASSOC);

        $countProducts = $array['count'];
        $sumProducts = $array['sum'];
    }


    //Покупок сегодня и Сумма продаж
    {
        $start_data = date('Y-m-d 00:00:00');
        $finish_data = date('Y-m-d 23:59:59');

        $sql = "
       SELECT 
        COUNT(*) as count,
        SUM(`orders`.`amount_seller`) as sum
       FROM `user`
            INNER JOIN `shop` ON `user`.`unique_id` = `shop`.`seller_id`
            INNER JOIN `product` ON `shop`.`id` = `product`.`shop_id`
            INNER JOIN `orders` ON `product`.`id` = `orders`.`product_id`
            WHERE `user`.`unique_id` = ? AND `orders`.`data` >= ? AND `orders`.`data` <= ?
        ";

        $query = DB::connect()->prepare($sql);
        $query->execute(array($_COOKIE['unique_id'], $start_data, $finish_data));
        $array = $query->fetch(PDO::FETCH_ASSOC);

        $countOrders = $array['count'];
        $sumOrders = $array['sum'];
    }

    if(!$sumOrders){
        $sumOrders = 0;
    }


    $data = [
        'countProducts' => $countProducts,
        'sumProducts' => $sumProducts,
        'countOrders' => $countOrders,
        'sumOrders' => $sumOrders
    ];

    echo json_encode($data);
}


function selectProduct() {
    $db = DB::connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $limit = 4;

    $category = $_POST['category'];
    $page = $_POST['page'];


    {
        $parameters = [];

        $sql = "SELECT
    
        COUNT(*) AS count

        FROM shop
        INNER JOIN product ON shop.id = product.shop_id
        WHERE shop.seller_id = ?";

        array_push($parameters, $_COOKIE['unique_id']);

        if($category !== "all") {
            $sql .= " AND product.global_category = ?";
            array_push($parameters, $category);
        }

        if (isset($_POST['search']) && $_POST['search'] !== "") {
            $search = $_POST['search'];
            $sql .= " AND (`product`.`id` LIKE ? OR `product`.`name` LIKE ?)";
            $key = '%' . $search . '%';
            array_push($parameters, $key);
            array_push($parameters, $key);
        }

        $query = $db->prepare($sql);
        $query->execute($parameters);

        $array = $query->fetch();

        $count = $array['count'];
    }


    {
        $parameters = [];
        array_push($parameters, $_COOKIE['unique_id']);

        $sql = "SELECT
            `product`.`id` as product_id,
            `product`.`name` as product_name,
            `global_categories`.`name` as global_category,
            `subcategories`.`name` as subcategories,
            `product`.`quantity` as quantity,
            `product`.`price` as price,
            COUNT(orders.id) AS orders_count
        FROM
            shop
            INNER JOIN product ON shop.id = product.shop_id
            LEFT JOIN orders ON product.id = orders.product_id
            INNER JOIN global_categories ON global_categories.id = product.global_category
            INNER JOIN subcategories ON subcategories.id = product.category
        WHERE
            shop.seller_id = ?";


        if($category !== "all") {
            $sql .= " AND product.global_category = ?";
            array_push($parameters, $category);
        }

        if (isset($_POST['search']) && $_POST['search'] !== "") {
            $search = $_POST['search'];
            $sql .= " AND (`product`.`id` LIKE ? OR `product`.`name` LIKE ?)";
            $key = '%' . $search . '%';
            array_push($parameters, $key);
            array_push($parameters, $key);
        }

        if ($page === 1) {
            $offset = 0;
        } else {
            $page = $page-1;
            $offset = $page * $limit;
        }


        $sql .= " GROUP BY
            shop.id, product.id";

        $sql .= " LIMIT ? OFFSET ?";
        array_push($parameters, $limit);
        array_push($parameters, $offset);

        $query = $db->prepare($sql);
        $query->execute($parameters);

        $array = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    $data = [
      'array' => $array,
      'count' => $count
    ];

    echo json_encode($data);
}


function renderModalLoading() {
    if(isset($_POST['id'])) {
        $array = check($_POST['id']);
        if($array){
            echo json_encode($array);
        }
    }
}

//checking the rights to the product
function check($id) {
    if(isset($_COOKIE['unique_id'])){
        $sql = "SELECT 
            `product`.`id`,
            `product`.`name`,
            `product`.`rating`,
            `product`.`fake_rating`,
            `product`.`type_rating`,
            `product`.`quantity`,
            `product`.`price`
            
        FROM `shop` INNER JOIN `product` ON `shop`.`id` = `product`.`shop_id` WHERE `shop`.`seller_id` = ? AND `product`.`id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($_COOKIE['unique_id'], $id));

        $array = $query->fetch();

        $rating = "";

        if (!empty($array)) {
            $myFunction = new MyFunction();

            switch ($array['type_rating']) {
                case 'rating':
                    $rating = $array['rating'];
                    // Выполняем замену рейтинга rating1
                    // ваш код замены рейтинга rating1
                    break;
                case 'fake_rating':
                    $rating = $array['fake_rating'];
                    break;
            }

            $array['num_rating'] = $rating;

            $array['rating'] = $myFunction->create_ratingShop($rating); // Обновляем значение рейтинга в массиве


            return $array;
        }
        else return false;
    }
}