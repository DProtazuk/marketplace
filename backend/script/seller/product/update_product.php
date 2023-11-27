<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/MyFunction.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Shop.php";

if(isset($_POST['action'])){
    if($_POST['action'] === "all_product_information"){
        all_product_information();
    }
    if($_POST['action'] === "delete_account"){
        delete_account();
    }
    if($_POST['action'] === "update_write_account"){
        update_write_account();
    }
    if($_POST['action'] === "update_account"){
        update_account();
    }
    if($_POST['action'] === "update_product"){
        update_product();
    }
}

function all_product_information() {

    $idProduct = $_POST['idProduct'];
    $all_product_information = [];
    //Вытаскиваем всю осбновую информацию
    $sth = DB::connect()->prepare("SELECT
    global_categories.name as global_categories_name, global_categories.id as global_categories_id,
    subcategories.name as subcategories_name, subcategories.id as subcategories_id,
    product.name as product_name, product.price, product.cover, product.description, product.discount
    FROM `product` INNER JOIN `subcategories` ON subcategories.id = product.category INNER JOIN `global_categories` ON subcategories.id_global_categorie = global_categories.id WHERE product.id = ?");
    $sth->execute([$idProduct]);
    //Информация о товаре
    $array_product = $sth->fetch(PDO::FETCH_ASSOC);
    $all_product_information[] = $array_product;

    //Достаем все категории глобальной категории
    $sth = DB::connect()->prepare("SELECT * FROM `subcategories` WHERE `id_global_categorie` = ?");
    $sth->execute([$array_product['global_categories_id']]);
    $array_subcategories = $sth->fetchAll(PDO::FETCH_ASSOC);
    $all_product_information[] = $array_subcategories;

    //Вытаскиваем всю информацию по параметрам категории
    $sth = DB::connect()->prepare("SELECT * FROM `parameters_product` WHERE `id_categories` = ?");
    $sth->execute([$array_product['global_categories_id']]);
    $array_parameters_category = $sth->fetchAll(PDO::FETCH_ASSOC);
    $all_product_information[] = $array_parameters_category;

    //Вытаскиваем всю информацию по параметрам товара
    $sth = DB::connect()->prepare("SELECT * FROM `parameter_table` WHERE `id_product` = ?");
    $sth->execute([$idProduct]);
    $array_parameters_product = $sth->fetchAll(PDO::FETCH_ASSOC);
    $all_product_information[] = $array_parameters_product;

    //Вытаскиваем все аккаунты товара
    $sth = DB::connect()->prepare("SELECT * FROM `accounts` WHERE `id_product` = ?");
    $sth->execute([$idProduct]);
    $array_account_product = $sth->fetchAll(PDO::FETCH_ASSOC);
    $all_product_information[] = $array_account_product;

    echo json_encode($all_product_information);
}

function delete_account() {
    $sth = DB::connect()->prepare("SELECT * FROM `accounts` WHERE `id` = ?");
    $sth->execute([$_POST['id']]);
    $array = $sth->fetch(PDO::FETCH_ASSOC);
    $idProduct = $array['id_product'];

    $sth = DB::connect()->prepare("DELETE  FROM `accounts` WHERE `id` = ?");
    $sth->execute([$_POST['id']]);

    $sth = DB::connect()->prepare("UPDATE `product` SET `quantity` = `quantity` - ? WHERE `id` = ?");
    $sth->execute([1, $idProduct]);
}

function update_write_account() {
    $sth = DB::connect()->prepare("SELECT * FROM `accounts` WHERE `id` = ?");
    $sth->execute([$_POST['id']]);
    $array = $sth->fetch(PDO::FETCH_ASSOC);
    echo json_encode($array);
}

function update_account() {
    $sth = DB::connect()->prepare("UPDATE `accounts` SET `value` = ? WHERE `id` = ?");
    $sth->execute([$_POST['value'], $_POST['id']]);
}

function update_product() {
    echo 1;

    $MyFunction = new MyFunction();

    $id = $_POST['idProduct'];
    $name = $_POST['name'];
    $imgCover = $_FILES['imgCover'];
    $global_category = $_POST['global_category'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['txt_description_product'];
    $discount = $_POST['discount'];

    //Отправка фото товара
    if($imgCover['name']) {
        $directory = $_SERVER['DOCUMENT_ROOT'].'/res/img/imgProducts/';
        $nameImg = $MyFunction->getExtension($imgCover['name']);
        $name_imgCover = $MyFunction->random() . "seller" .pathinfo($nameImg)['filename'];
        move_uploaded_file($_FILES['imgCover']['tmp_name'], $directory.$name_imgCover);

        $sth = DB::connect()->prepare("UPDATE `product` SET `name` = ?, `cover` = ?, `global_category` = ?, `category` = ?, `price` = ?, `description` = ?, `discount` = ? WHERE `id` = ?");
        $sth->execute([$name, $name_imgCover, $global_category, $category, $price, $description, $discount, $id]);
    }
    else {
        $sth = DB::connect()->prepare("UPDATE `product` SET `name` = ?, `global_category` = ?, `category` = ?, `price` = ?, `description` = ?, `discount` = ? WHERE `id` = ?");
        $sth->execute([$name, $global_category, $category, $price, $description, $discount, $id]);
    }

    //Отправка аккантов в товар
    if($_POST['textarea']){
        $Shop = new Shop();
        $uniqueID = $Shop->ReturnIdShop();

        insert_account($_POST['textarea'], $id);
        $array_account = explode("\n", $_POST['textarea']);
        $count = count($array_account);
        $sth = DB::connect()->prepare("UPDATE `product` SET `quantity` = ? WHERE `shop_id` = ?");
        $sth->execute([$count, $uniqueID]);
    }

    //Удалить старые параметры
    $sth = DB::connect()->prepare("DELETE  FROM `parameter_table` WHERE `id_product` = ?");
    $sth->execute([$id]);

    //Вытащить все параметры под категорию
    $array_parameters = select_parameters($global_category);
    $count = count($array_parameters);

    for($i=0; $i<$count; $i++) {
        if($array_parameters[$i]['type'] === "checkbox"){
            if ($_POST['parameter_'.$array_parameters[$i]['id']] != '') {
                $sth = DB::connect()->prepare("INSERT INTO `parameter_table` SET `id_product` = ?, `parameters_product` = ?, `name` = ?, `value` = ?");
                $sth->execute([$id, $array_parameters[$i]['id'], $array_parameters[$i]['name'], 1]);
            }
        }
        if($array_parameters[$i]['type'] === "two_inputs"){
            $array = [];
            if($_POST['parameter_'.$array_parameters[$i]['id']] !== '') {
                array_push($array, $_POST['parameter_'.$array_parameters[$i]['id']]);
            }
            if($_POST['parameter_'.$array_parameters[$i]['id']."_1"] !== '') {
                array_push($array, $_POST['parameter_'.$array_parameters[$i]['id'].'_1']);
            }

            if($array) {
                $array = json_encode($array);
                $sth = DB::connect()->prepare("INSERT INTO `parameter_table` SET `id_product` = ?, `parameters_product` = ?, `name` = ?, `value` = ?");
                $sth->execute([$id, $array_parameters[$i]['id'], $array_parameters[$i]['name'], $array]);
            }
        }
        if($array_parameters[$i]['type'] === "select"){
            if ($_POST['parameter_'.$array_parameters[$i]['id']] !== '') {
                $sth = DB::connect()->prepare("INSERT INTO `parameter_table` SET `id_product` = ?, `parameters_product` = ?, `name` = ?, `value` = ?");
                $sth->execute([$id, $array_parameters[$i]['id'], $array_parameters[$i]['name'], $_POST['parameter_'.$array_parameters[$i]['id']]]);
            }
        }
        if($array_parameters[$i]['type'] === "input"){
            if ($_POST['parameter_'.$array_parameters[$i]['id']] !== '') {
                $sth = DB::connect()->prepare("INSERT INTO `parameter_table` SET `id_product` = ?, `parameters_product` = ?, `name` = ?, `value` = ?");
                $sth->execute([$id, $array_parameters[$i]['id'], $array_parameters[$i]['name'], $_POST['parameter_' . $array_parameters[$i]['id']]]);
            }
        }
    }
    header('Location: /page/seller/product/update?id='.$id);
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