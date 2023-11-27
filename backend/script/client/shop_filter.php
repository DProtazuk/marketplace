<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/MyFunction.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Subcategories.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/GlobalCategories.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/ParametersProduct.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === "write_start") {
        echo write_start($_POST['IdShop'], $_POST['global_categories']);
    }
    if ($action === "filter_product") {
        filter_product();
    }
    if($action === "WriteSubcategory"){
        $Subcategories = new Subcategories();
        echo json_encode($Subcategories->SelectAll($_POST['id']));
    }
    if($action === "WriteFilter"){
        WriteFilter();
    }
    if($action === "StartGlCategory"){
        $SelectStartIdGlobal_categories = new GlobalCategories();
        echo $SelectStartIdGlobal_categories->SelectStartIdGlobal_categories();
    }
}

function WriteFilter() {
    $db = DB::connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $IdShop = $_POST['IdShop'];
    $global_categories = $_POST['global_categories'];

    //Минимальная и максимальная стоимость
    $sql = "SELECT MAX(`price`) as MaxPrice, MIN(`price`) as MinPrice FROM `product`WHERE `product`.`global_category` = ? AND `product`.`shop_id` = ?";
    $price = DB::connect()->prepare($sql);
    $price->execute(array($global_categories, $IdShop));
    $price = $price->fetch(PDO::FETCH_ASSOC);


    if($price['MaxPrice']){
        $MaxPrice = $price['MaxPrice'];
    }
    else $MaxPrice = 0;

    if($price['MinPrice']){
        $MinPrice = $price['MinPrice'];
    }
    else $MinPrice = 0;

    //Подкатегории
    $subcategories = new Subcategories();
    $subcategories = $subcategories->SelectAll($global_categories);


    //Параметры категории
    $ParametersProduct = new ParametersProduct();
    $ParametersProduct = $ParametersProduct->SelectParametersCategory($global_categories);

    $array = [
        "MaxPrice" => $MaxPrice,
        "MinPrice" => $MinPrice,
        "subcategories" => $subcategories,
        "ParametersProduct" => $ParametersProduct
    ];


    echo json_encode($array);
}

function write_start($IdShop, $global_categories)
{
    $db = DB::connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $IdShop = $_POST['IdShop'];
    $global_categories = $_POST['global_categories'];

    //Минимальная и максимальная стоимость
    $sql = "SELECT MAX(`price`) as MaxPrice, MIN(`price`) as MinPrice FROM `product`WHERE `product`.`global_category` = ? AND `product`.`shop_id` = ?";
    $price = DB::connect()->prepare($sql);
    $price->execute(array($global_categories, $IdShop));
    $price = $price->fetch(PDO::FETCH_ASSOC);

    $MaxPrice = $price['MaxPrice'];
    $MinPrice = $price['MinPrice'];

    //Подкатегории
    $subcategories = new Subcategories();
    $subcategories = $subcategories->SelectAll($global_categories);


    //Параметры категории
    $ParametersProduct = new ParametersProduct();
    $ParametersProduct = $ParametersProduct->SelectParametersCategory($global_categories);

    $sql = "SELECT `product`.`id` as product_id, `shop`.`id` as shop_id, `product`.`cover` as product_cover, `product`.`name` as product_name, `product`.`quantity`, `product`.`price`, `product`.`rating`, `product`.`fake_rating`, `shop`.`name` as shop_name, `global_categories`.`img` as global_categories_img
        FROM `shop` 
            INNER JOIN `product` ON `shop`.`id` = `product`.`shop_id` 
            INNER JOIN `global_categories` ON `product`.`global_category` = `global_categories`.`id`
        WHERE `product`.`global_category` = ? AND `product`.`shop_id` = ?";

    $productStandart = DB::connect()->prepare($sql);
    $productStandart->execute(array($global_categories, $IdShop));
    $productStandart = $productStandart->fetchAll(PDO::FETCH_ASSOC);
    $count = count($productStandart);

    $page = 1;
    $limit = 4;
    $offset = $page * $limit;


    $sql .= " LIMIT ?";
    $productStandart = $db->prepare($sql);
    $productStandart->execute(array($global_categories, $IdShop, $limit));
    $productStandart = $productStandart->fetchAll(PDO::FETCH_ASSOC);


    if (!empty($productStandart)) {
        $MyFunction = new MyFunction();

        foreach ($productStandart as &$value) {

            if ($value['fake_rating'] !== NULL) {
                $value["rating_value"] = $value['fake_rating'];
                $value["rating"] = $MyFunction->create_rating($value['fake_rating']);
            } else {
                $value["rating_value"] = $value['rating'];
                $value["rating"] = $MyFunction->create_rating($value['rating']);
            }
            unset($value["fake_rating"]);
        }
    }
    else echo 0;

    $mass = [
        "count" => $count,
        "data" => $productStandart
    ];

    $array = [
        "MaxPrice" => $MaxPrice,
        "MinPrice" => $MinPrice,
        "subcategories" => $subcategories,
        "ParametersProduct" => $ParametersProduct,
        "product" => $mass
    ];


    return json_encode($array);
}


function filter_product()
{
    $db = DB::connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $limit = 4;
    $page = $_POST['page'];
    $IdShop = $_POST['IdShop'];
    $global_categories = $_POST['global_categories'];
    $min = $_POST['min'];
    $max = $_POST['max'];

    $parameters = [];

    $sql = "SELECT `product`.`id` as product_id, `shop`.`id` as shop_id, `product`.`cover` as product_cover, `product`.`name` as product_name, `product`.`quantity`, `product`.`price`, `product`.`rating`, `product`.`fake_rating`, `shop`.`name` as shop_name, `global_categories`.`img` as global_categories_img
        FROM `shop` 
            INNER JOIN `product` ON `shop`.`id` = `product`.`shop_id` 
            INNER JOIN `global_categories` ON `product`.`global_category` = `global_categories`.`id`
        WHERE `product`.`shop_id` = ? AND `product`.`global_category` = ? AND `product`.`price` BETWEEN ? AND ?";

    array_push($parameters, $IdShop);
    array_push($parameters, $global_categories);
    array_push($parameters, $min);
    array_push($parameters, $max);

    if(!empty($_POST['Subcategories'])){
        $Subcategories = $_POST['Subcategories'];

        $placeholders = implode(',', array_fill(0, 1, '?'));
        $sql .= " AND `product`.`category` IN ($placeholders)";
        array_push($parameters, $Subcategories);

//        foreach ($Subcategories as $item) {
//            array_push($parameters, $item);
//        }
    }
    if(!empty($_POST['ArrayParameters'])) {
        $ArrayParameters = $_POST['ArrayParameters'];

        foreach ($ArrayParameters as $item) {
            $sql .= " AND EXISTS (SELECT * FROM `parameter_table` where `parameter_table`.`id_product` = `product`.`id` and `parameter_table`.`parameters_product` = ?)";
            array_push($parameters, $item);
        }
    }
    if(!empty($_POST['ArrayParametersUniq'])) {
        $ArrayParametersUniq = $_POST['ArrayParametersUniq'];

        foreach ($ArrayParametersUniq as $item) {
            $placeholders = implode(',', array_fill(0, count($item[1]), '?'));

            $sql .= " AND EXISTS (SELECT * FROM `parameter_table` where `parameter_table`.`id_product` = `product`.`id` and `parameter_table`.`parameters_product` = ? and `parameter_table`.`value` in ($placeholders))";
            array_push($parameters, $item[0]);

            foreach ($item[1] as $array) {
                array_push($parameters, $array);
            }
        }
    }
    if (!empty($_POST['search'])) {
        $search = $_POST['search'];
        $sql .= " AND `product`.`name` LIKE ?";
        $key = '%' . $search . '%';
        array_push($parameters, $key);
    }
    if (!empty($_POST['sort'])) {
        $sort = $_POST['sort'];
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



