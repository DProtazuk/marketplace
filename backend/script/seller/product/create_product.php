<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Subcategories.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/MyFunction.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Shop.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "select_category_end_parameters") {
        select_category_end_parameters($_POST['id_GlCat']);
    }
    if ($action == "create_product") {
        create_product();
    }
}


function select_category_end_parameters($id): void
{
    $Subcategories = new Subcategories();
    echo $Subcategories->SelectCategoryEndParameters($id);
}


function create_product() {
    $Subcategories= new Subcategories();
    $MyFunction = new MyFunction();
    $Shop = new Shop();

    $name = $_POST['name'];
    $imgCover = $_FILES['imgCover'];
    $global_category = $_POST['global_category'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['txt_description_product'];
    $discount = $_POST['discount'];

    //Отправка фото товара
    $directory = $_SERVER['DOCUMENT_ROOT'] . '/res/img/imgProducts/';
    $nameImg = $MyFunction->getExtension($imgCover['name']);
    $name_imgCover = $MyFunction->random() . "seller" . pathinfo($nameImg)['filename'];
    move_uploaded_file($_FILES['imgCover']['tmp_name'], $directory . $name_imgCover);

    $uniqueID = $Shop->ReturnIdShop();

    $db = DB::connect();

    $sth = $db->prepare("INSERT INTO `product` SET `shop_id` = ?, `name` = ?, `cover` = ?, `global_category` = ?, `category` = ?, `price` = ?, `description` = ?, `quantity` = ?, `rating` = ?, `fake_rating` = ?, `type_rating` = ?, `discount` = ?, `date_of_creation` = ?");
    $sth->execute([$uniqueID, $name, $name_imgCover, $global_category, $category, $price, $description, 0, 0, NULL, 0, $discount, date('Y-m-d H:i:s')]);
    $insert_id = $db->lastInsertId();

    //Вытащить все параметры под категорию
    $array_parameters = select_parameters($global_category);
    $count = count($array_parameters);

    for ($i = 0; $i < $count; $i++) {
        if ($array_parameters[$i]['type'] === "checkbox") {
            if (isset($_POST['parameter_' . $array_parameters[$i]['id']]) AND $_POST['parameter_' . $array_parameters[$i]['id']] !== '') {
                $sth = DB::connect()->prepare("INSERT INTO `parameter_table` SET `id_product` = ?, `parameters_product` = ?, `name` = ?, `value` = ?");
                $sth->execute([$insert_id, $array_parameters[$i]['id'], $array_parameters[$i]['name'], 1]);
            }
        }
        if ($array_parameters[$i]['type'] === "two_inputs") {
            $array = [];
            if ($_POST['parameter_' . $array_parameters[$i]['id']] !== '') {
                array_push($array, $_POST['parameter_' . $array_parameters[$i]['id']]);
            }
            if ($_POST['parameter_' . $array_parameters[$i]['id'] . "_1"] !== '') {
                array_push($array, $_POST['parameter_' . $array_parameters[$i]['id'] . '_1']);
            }

            if ($array) {
                $array = json_encode($array);
                $sth = DB::connect()->prepare("INSERT INTO `parameter_table` SET `id_product` = ?, `parameters_product` = ?, `name` = ?, `value` = ?");
                $sth->execute([$insert_id, $array_parameters[$i]['id'], $array_parameters[$i]['name'], $array]);
            }
        }
        if ($array_parameters[$i]['type'] === "select") {
            if ($_POST['parameter_' . $array_parameters[$i]['id']] !== '') {
                $sth = DB::connect()->prepare("INSERT INTO `parameter_table` SET `id_product` = ?, `parameters_product` = ?, `name` = ?, `value` = ?");
                $sth->execute([$insert_id, $array_parameters[$i]['id'], $array_parameters[$i]['name'], $_POST['parameter_' . $array_parameters[$i]['id']]]);
            }
        }
        if ($array_parameters[$i]['type'] === "input") {
            if ($_POST['parameter_' . $array_parameters[$i]['id']] !== '') {
                $sth = DB::connect()->prepare("INSERT INTO `parameter_table` SET `id_product` = ?, `parameters_product` = ?, `name` = ?, `value` = ?");
                $sth->execute([$insert_id, $array_parameters[$i]['id'], $array_parameters[$i]['name'], $_POST['parameter_' . $array_parameters[$i]['id']]]);
            }
        }
    }

    //Отправка аккантов в товар
    insert_account($_POST['textarea'], $insert_id);

    if ($_POST['textarea']) {
        $array_account = explode("\n", $_POST['textarea']);
        $count = count($array_account);
        $sth = DB::connect()->prepare("UPDATE `product` SET `quantity` = ? WHERE `shop_id` = ?");
        $sth->execute([$count, $uniqueID]);
    }

    header('Location: /page/seller/product/products');
}


function insert_account($array, $uniqueID)
{
    if ($array) {
        $array_account = explode("\n", $array);
        $count = count($array_account);

        $sql = "INSERT INTO accounts (`id_product`, `value`, `status`) VALUES ";
        $array_prepare = "";
        $array_execute = [];
        foreach ($array_account as $item) {
            $array_prepare = $array_prepare . "(?, ?, ?),";
            array_push($array_execute, $uniqueID);
            array_push($array_execute, $item);
            array_push($array_execute, "new");
        }
        $array_prepare = substr($array_prepare, 0, -1);

        $sth = DB::connect()->prepare($sql . $array_prepare);
        $sth->execute($array_execute);
    }
}

function select_parameters($id)
{
    $sth = DB::connect()->prepare("SELECT * FROM `parameters_product` WHERE `id_categories` = ?");
    $sth->execute([$id]);
    $array = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $array;
}