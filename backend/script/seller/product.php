<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Product.php";

if(isset($_POST['action'])){
    $action = $_POST['action'];

    if($action == "select_product") {
        select_product($_POST['id']);
    }
    if ($action == "select_one_product"){
        selectOneProduct($_POST['id']);
    }
    if ($action == "StatisticsProduct"){
        StatisticsProduct();
    }
    if ($action == "copy_product"){
        copy_product($_POST['id']);
    }
    if ($action == "delete_product"){
        $delete = new Product();
        $delete->DeleteProduct($_POST['id']);
    }
    if ($action == "loading_product"){
        loading_product($_POST['id'], $_POST['txt']);
    }
    if ($action == "down_product"){
        down_product($_POST['id'], $_POST['num']);
    }
    if ($action == "search_product"){
        search_product($_POST['like']);
    }
    if ($action == "select_product_category"){
        select_product_category($_POST['id'], $_POST['category']);
    }
}

function select_product($id) {
    $sth = DB::connect()->prepare("SELECT product.name as product, subcategories.name as subcategories, global_categories.name as global_category, product.shop_id, product.price, product.quantity, product.id as id FROM `product` INNER JOIN `subcategories` ON subcategories.id = product.category INNER JOIN `global_categories` ON subcategories.id_global_categorie = global_categories.id WHERE product.shop_id = ?");
    $sth->execute([$id]);
    $array = $sth->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($array);
}

function select_product_category($id, $category) {
    $sth = DB::connect()->prepare("SELECT product.name as product, subcategories.name as subcategories, global_categories.name as global_category, product.shop_id, product.price, product.quantity, product.id as id FROM `product` INNER JOIN `subcategories` ON subcategories.id = product.category INNER JOIN `global_categories` ON subcategories.id_global_categorie = global_categories.id WHERE product.shop_id = ? AND `global_categories`.`id` = ?");
    $sth->execute([$id, $category]);
    $array = $sth->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($array);
}

function selectOneProduct($id) {
    $product = new Product();
    $product = $product->selectOneProduct($id);
    echo json_encode($product);
}

function StatisticsProduct() {
    $Product = new Product();
    $ProductQuantity = $Product->ProductQuantity();
    $ProductAmount = $Product->ProductAmount();

    $array = ['ProductQuantity' => $ProductQuantity, 'ProductAmount' => $ProductAmount];
    echo json_encode($array);
}

function copy_product($id) {
    $db = DB::connect();
    //Копироваие товара

    $sth = DB::connect()->prepare("SELECT * FROM `product` WHERE `id` = ?");
    $sth->execute([$id]);
    $array = $sth->fetch(PDO::FETCH_ASSOC);

    $new_name = $array['name']."-(копия)";


    $sth = $db->prepare("INSERT INTO `product` SET `shop_id` = ?, `name` = ?, `cover` = ?, `global_category` = ?, `category` = ?, `price` = ?, `description` = ?, `quantity` = ?, `rating` = ?, `fake_rating` = ?, `type_rating` = ?, `discount` = ?, `date_of_creation` = ?");
    $sth->execute([$array['shop_id'], $new_name, $array['cover'], $array['global_category'], $array['category'], $array['price'], $array['description'], 0, 0, NULL, 0, $array['discount'], $array['date_of_creation']]);

    $newID = $db->lastInsertId();

    //Копирование всех параметров
    $sth = DB::connect()->prepare("SELECT * FROM `parameter_table` WHERE `id_product` = ?");
    $sth->execute([$id]);
    $array = $sth->fetchAll(PDO::FETCH_ASSOC);


    if($array){
        foreach ($array as $parameter){

            $sth = DB::connect()->prepare(
                "INSERT INTO `parameter_table` SET `id_product` = ?, `parameters_product` = ?, `name` = ?, `value` = ?"
            );
            $sth->execute([$newID, $parameter['parameters_product'], $parameter['name'], $parameter['value']]);
        }
    }
    echo true;
}

function loading_product($id, $txt) {
    $product = new Product();

    if($txt) {
        $array_account = explode("\n",$txt);
        $count = count($array_account);

        $sql = "INSERT INTO accounts (`id_product`, `value`, `status`) VALUES ";
        $array_prepare = "";
        $array_execute = [];
        foreach ($array_account as $item) {
            $array_prepare = $array_prepare."(?, ?, ?),";
            array_push($array_execute, $id);
            array_push($array_execute, $item);
            array_push($array_execute, "new");
        }
        $array_prepare = substr($array_prepare, 0, -1);

        $sth = DB::connect()->prepare($sql.$array_prepare);
        $sth->execute($array_execute);

        $sth = DB::connect()->prepare("UPDATE `product` SET `quantity` = `quantity` + ? WHERE `id` = ?");
        $sth->execute([$count, $id]);

        $array = [];
        $array[] = $product->ProductQuantity();
        $array[] = $product->ProductAmount();

        echo json_encode($array);
    }
}

function down_product($id, $num) {
    require_once $_SERVER['DOCUMENT_ROOT']."/backend/DB.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/backend/Product.php";

    $name = $id."_".time();

    $file_name = $_SERVER['DOCUMENT_ROOT']."/res/file/".$name.".txt";
    file_put_contents($file_name, '');


    $sth = DB::connect()->prepare("SELECT * FROM `accounts`  WHERE `id_product` = $id AND `status` = 'new' LIMIT ? ");
    $sth->bindValue(1, $num, PDO::PARAM_INT);
    $sth->execute();
    $array = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach ($array as $text){
        $fp = fopen($file_name, 'a');
        fwrite($fp, $text['value'] . PHP_EOL);
        fclose($fp);
    }

    $sth = DB::connect()->prepare("DELETE FROM `accounts`  WHERE `id_product` = $id LIMIT ? ");
    $sth->bindValue(1, $num, PDO::PARAM_INT);
    $sth->execute();

    $sth = DB::connect()->prepare("UPDATE `product` SET `quantity` = quantity- ? WHERE `id` = ?");
    $sth->execute([$num, $id]);

    echo json_encode($name.".txt");
}


function search_product($like) {
    $query = "SELECT product.name as product, subcategories.name as subcategories, global_categories.name as global_category, product.id, product.price, product.quantity FROM `product` INNER JOIN `subcategories` ON subcategories.id = product.category INNER JOIN `global_categories` ON subcategories.id_global_categorie = global_categories.id 
    WHERE product.name LIKE ? OR product.id LIKE ?";
    $params = array("%$like%", "%$like%");
    $sth = DB::connect()->prepare($query);
    $sth->execute($params);
    $array = $sth->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($array);
}