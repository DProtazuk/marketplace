<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

if(isset($_POST['action'])){
    if($_POST['action'] === "sales") {
        sales();
    }
}

function SelectInfo() {
    $sql = "SELECT SUM(orders.quantity) AS quantity, COUNT(orders.id) AS count, SUM(orders.quantity * orders.price) AS sum
        FROM shop
        INNER JOIN product ON shop.id = product.shop_id
        INNER JOIN orders ON product.id = orders.product_id
        WHERE shop.seller_id = ?
";

    $query = DB::connect()->prepare($sql);
    $query->execute(array($_COOKIE['unique_id']));

    return $query->fetch();
}

function SelectInfoAdmin($id) {
    $sql = "SELECT SUM(orders.quantity) AS quantity, COUNT(orders.id) AS count, SUM(orders.quantity * orders.price) AS sum
        FROM shop
        INNER JOIN product ON shop.id = product.shop_id
        INNER JOIN orders ON product.id = orders.product_id
        WHERE shop.seller_id = ?
";

    $query = DB::connect()->prepare($sql);
    $query->execute(array($id));

    return $query->fetch();
}


function sales() {
    $db = DB::connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $limit = 5;
    $page = $_POST['page'];

    $start_data = $_POST['start_data'];
    $finish_data = $_POST['finish_data'];

    $start_data = date('Y-m-d 00:00:00', strtotime($start_data));
    $finish_data = date('Y-m-d 23:59:59', strtotime($finish_data));

    $parameters = [];

    array_push($parameters, $start_data);
    array_push($parameters, $finish_data);

        $sql = "SELECT
            orders.id,
            orders.data,
            orders.quantity,
            orders.amount,
            product.name AS product_name,
            user.name AS user_name,
            global_categories.name AS global_category_name,
            subcategories.name AS subcategory_name
            FROM shop
            INNER JOIN product ON shop.id = product.shop_id
            INNER JOIN orders ON product.id = orders.product_id
            INNER JOIN user ON orders.unique_id = user.unique_id
            INNER JOIN global_categories ON product.global_category = global_categories.id
            INNER JOIN subcategories ON product.category = subcategories.id
        WHERE `orders`.`data` >= ? AND `orders`.`data` <= ?
    ";

    if (!empty($_POST['search'])) {
        $search = $_POST['search'];
        $sql .= " AND (`orders`.`id` LIKE ? OR `product`.`name` LIKE ?)";
        $key = '%' . $search . '%';
        array_push($parameters, $key);
        array_push($parameters, $key);
    }


    $query = $db->prepare($sql);
    $query->execute($parameters);

    $array = $query->fetchAll(PDO::FETCH_ASSOC);

    $count = count($array);


    if ($page === 1) {
        $offset = 0;
    } else {
        $page = $page-1;
        $offset = $page * $limit;
    }

    $sql .= " LIMIT ? OFFSET ?";
    array_push($parameters, $limit);
    array_push($parameters, $offset);


    $array =$db->prepare($sql);
    $array->execute($parameters);
    $array = $array->fetchAll(PDO::FETCH_ASSOC);


    $mass = [
        'data' => $array,
        'count'=> $count
    ];
    echo json_encode($mass);


}

