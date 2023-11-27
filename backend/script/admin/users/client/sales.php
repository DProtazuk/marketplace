<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
$role = new Role();

if (!$role->Check('admin')) {
    header("Location: /");
}


    require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";


    $db = DB::connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $limit = 4;
    $page = $_POST['page'];
    $unique_id = $_POST['id'];

    $start_data = $_POST['start_data'];
    $finish_data = $_POST['finish_data'];
    $start_data = date('Y-m-d 00:00:00', strtotime($start_data));
    $finish_data = date('Y-m-d 23:59:59', strtotime($finish_data));

    $parameters = [];
    array_push($parameters, $unique_id);
    array_push($parameters, $start_data);
    array_push($parameters, $finish_data);

    $sql = "SELECT `orders`.`id`, `orders`.`price`, `orders`.`amount`, `orders`.`quantity`, `orders`.`data`, `product`.`name`, `subcategories`.`name` as subcategories, `global_categories`.`name` as global_categories FROM `orders`
        INNER JOIN `product` ON `orders`.`product_id` = `product`.`id`
        INNER JOIN `subcategories` ON `product`.`category` = `subcategories`.`id`
        INNER JOIN `global_categories` ON `subcategories`.`id_global_categorie` = `global_categories`.`id`
        WHERE `orders`.`unique_id` = ? AND `data` >= ? AND `data` <= ?";

    if (!empty($_POST['search'])) {
        $search = $_POST['search'];
        $sql .= " AND (`orders`.`id` LIKE ? OR `product`.`name` LIKE ?)";
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
    $array =$db->prepare($sql);
    $array->execute($parameters);
    $array = $array->fetchAll(PDO::FETCH_ASSOC);
    $count = count($array);

    $sql .= " LIMIT ? OFFSET ?";
    array_push($parameters, $limit);
    array_push($parameters, $offset);

    $array =$db->prepare($sql);
    $array->execute($parameters);
    $array = $array->fetchAll(PDO::FETCH_ASSOC);

    $mass = [
        'count' => $count,
        'data' => $array
    ];

    echo json_encode($mass);
