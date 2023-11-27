<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Favorite.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/MyFunction.php";

if(isset($_POST['action'])){
    $action = $_POST['action'];
    $Favorite = new Favorite();

    if($action === "add"){
        $Favorite->Add($_POST['id_product']);
    }
    if($action === "delete"){
        $Favorite->Delete($_POST['id_product']);
    }
    if($action === "filter_favorite") {
        FilterFavorite();
    }
}

if(isset($_GET['id'])){
    $Favorite = new Favorite();
    $Favorite->Delete($_GET['id']);
    header("Location: /page/client/favorites.php");
}


function FilterFavorite() {
    $db = DB::connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $limit = 4;

    $id_product = $_COOKIE['unique_id'];
    $page = $_POST['page'];

    $parameters = [];

    array_push($parameters, $id_product);

    $sql = "SELECT `product`.`id` as product_id, `shop`.`id` as shop_id, `product`.`cover` as product_cover, `product`.`name` as product_name, `product`.`quantity`, `product`.`price`, `product`.`rating`, `product`.`fake_rating`, `shop`.`name` as shop_name
        FROM `favorite` 
            INNER JOIN `product` ON `favorite`.`id_product` = `product`.`id`
            INNER JOIN `shop` ON `product`.`shop_id` = `shop`.`id`
        WHERE `favorite`.`unique_id` = ? ";

    if (!empty($_POST['search'])) {
        $search = $_POST['search'];
        $sql .= " AND `product`.`name` LIKE ?";
        $key = '%' . $search . '%';
        array_push($parameters, $key);
    }
    if (!empty($_POST['filter'])) {
        $sort = $_POST['filter'];
        if ($sort === "ascending_price") {
            $sql .= " ORDER BY `product`.`price` ASC";
        }
        if ($sort === "decreasing_price") {
            $sql .= " ORDER BY `product`.`price` DESC";
        }
        if ($sort === "ascending_name") {
            $sql .= " ORDER BY `product`.`name` ASC";
        }
        if ($sort === "decreasing_name") {
            $sql .= " ORDER BY `product`.`name` DESC";
        }
        if ($sort === "ascending_rating") {
            $sql .= " ORDER BY IFNULL(`product`.`fake_rating`, `product`.`rating`) ASC";
        }
        if ($sort === "decreasing_rating") {
            $sql .= " ORDER BY IFNULL(`product`.`fake_rating`, `product`.`rating`) DESC";
        }
        if ($sort === "ascending_quantity") {
            $sql .= " ORDER BY `product`.`quantity` ASC";
        }
        if ($sort === "decreasing_quantity") {
            $sql .= " ORDER BY `product`.`quantity` DESC";
        }
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

    if (!empty($array)) {
        $MyFunction = new MyFunction();

        foreach ($array as &$value) {

            if ($value['fake_rating'] !== NULL) {
                $value["rating_value"] = $value['fake_rating'];
                $value["rating"] = $MyFunction->create_rating($value['fake_rating']);
            } else {
                $value["rating_value"] = $value['rating'];
                $value["rating"] = $MyFunction->create_rating($value['rating']);
            }
            unset($value["fake_rating"]);
        }

        $mass = [
            'count' => $count,
            'data' => $array
        ];

        echo json_encode($mass);
    }
    else echo 0;

}