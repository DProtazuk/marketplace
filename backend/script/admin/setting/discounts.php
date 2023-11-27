<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/MyFunction.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Shop.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Discounts.php";

if (isset($_POST['action'])) {
    if ($_POST['action'] === "create") {
        create();
    }
    if ($_POST['action'] === "select") {
        select();
    }
    if ($_POST['action'] === "delete") {
        delete();
    }
    if ($_POST['action'] === "selectOne") {
        selectOne();
    }
    if ($_POST['action'] === "update") {
        update();
    }
}


function create()
{
    $quantity = NULL;
    $start = NULL;
    $finish = NULL;

    $role = new Role();
    if (!$role->Check('admin')) {
        echo false;
    }

    $function = new MyFunction();
    $shop = $_POST['shop'];
    $Discount = new Discounts();


    {
        $post = ['name', 'shop', 'percent', 'type'];

        if (!$function->checking_array_post($post)) {
            echo "error";
            return false;
        }
    }


    {
        if ($shop !== "all") {
            $Shop = new Shop();
            if (!is_array($Shop->SelectShop($shop))) {
                echo "shop";
                return false;
            }
        }
    }

    //Проверка типа и данных скидки
    {
        $type = $_POST['type'];

        if ($type === "quantity") {
            $post = ['quantity_discount'];
            if (!$function->checking_array_post($post)) {
                echo "error";
                return false;
            }

            $quantity = $_POST['quantity_discount'];
        }
        if ($type === "time") {
            $post = ['start_data', 'finish_data'];
            if (!$function->checking_array_post($post)) {
                echo "data";
                return false;
            } else {

                //Проверка текущей даты
                {
                    $start = date('Y-m-d 00:00:00', strtotime($_POST['start_data']));

                    $currentDateTime = new DateTime();

                    $date = new DateTime($start);

                    if ($date->format('Y-m-d') !== $currentDateTime->format('Y-m-d')) {
                        echo "data";
                        return false;
                    }
                }

                //Сравнение двух дат
                {
                    $finish = date('Y-m-d 23:59:59', strtotime($_POST['finish_data']));

                    if ($finish < $start) {
                        echo "data";
                        return false;
                    }
                }
            }
        }
    }

    //Проверка скожества name
    {
        $name = $_POST['name'];
        if (is_array($Discount->selectName($name))) {
            echo "no save";
            return false;
        }
    }

    //Сохранение скидки
    {
        $array = [
            'type' => $type,
            'name' => $name,
            'quantity' => $quantity,
            'data_start' => $start,
            'data_finish' => $finish,
            'shop' => $shop,
            'percent' => $_POST['percent'],
            'status' => 1
        ];

        $Discount->create($array);

        echo "save";
    }
}

function select()
{

    $role = new Role();
    if (!$role->Check('admin')) {
        echo false;
    }

    $db = DB::connect();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $parameters = [];

    $sql = "SELECT 
        `discounts`.`id` as discounts_id,
        `discounts`.`type` as discounts_type,
        `discounts`.`name` as discounts_name,
        `discounts`.`quantity` as discounts_quantity,
        `discounts`.`data_start` as discounts_data_start,
        `discounts`.`data_finish` as discounts_data_finish,
        `discounts`.`percent` as discounts_percent,
        `shop`.`name` as shop_name
        
    FROM `discounts`
        LEFT JOIN `shop` ON `discounts`.`shop` = `shop`.`id` 
        WHERE `discounts`.`status` = 1";

    if (!empty($_POST['search'])) {
        $search = $_POST['search'];
        $sql .= " AND (`discounts`.`id` LIKE ? OR `discounts`.`name` LIKE ? OR `shop`.`name` LIKE ?)";
        $key = '%' . $search . '%';
        array_push($parameters, $key);
        array_push($parameters, $key);
        array_push($parameters, $key);
    }

    if (!empty($_POST['filter'])) {
        $filter = $_POST['filter'];

        if ($filter !== "all") {
            if ($filter === "ascending_percent") {
                $sql .= " ORDER BY `discounts`.`percent` ASC";
            }
            if ($filter === "decreasing_percent") {
                $sql .= " ORDER BY `discounts`.`percent` DESC";
            }
        }
    }

    $query = $db->prepare($sql);
    $query->execute($parameters);
    $array = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($array);
}

function delete()
{

    $role = new Role();
    if (!$role->Check('admin')) {
        return false;
    }

    if (!empty($_POST['discounts_id'])) {
        echo false;
    }

    $discount = new Discounts();
    if (!is_array($discount->selectId($_POST['discounts_id']))) {
        return false;
    }

    $discount->delete($_POST['discounts_id']);

    echo "delete";
}

function selectOne() {
    if (empty($_POST['discounts_id'])) {
        echo false;
        return false;
    }
    else {
        $sql = "SELECT 
        `discounts`.`id` as discounts_id,
        `discounts`.`type` as discounts_type,
        `discounts`.`name` as discounts_name,
        `discounts`.`quantity` as discounts_quantity,
        `discounts`.`data_start` as discounts_data_start,
        `discounts`.`data_finish` as discounts_data_finish,
        `discounts`.`percent` as discounts_percent,
        `shop`.`name` as shop_name,
        `shop`.`id` as shop_id
        
    FROM `discounts`
        LEFT JOIN `shop` ON `discounts`.`shop` = `shop`.`id` 
        WHERE `discounts`.`id` = ?";
        $query = DB::connect()->prepare($sql);
        $query->execute(array($_POST['discounts_id']));
        $array = $query->fetch();

        echo json_encode($array);
    }
}


function update() {
    $quantity = NULL;
    $start = NULL;
    $finish = NULL;

    $role = new Role();
    if (!$role->Check('admin')) {
        echo false;
    }

    $function = new MyFunction();
    $shop = $_POST['shop'];
    $Discount = new Discounts();

    {
        $post = ['name', 'shop', 'percent', 'type'];

        if (!$function->checking_array_post($post)) {
            echo "error";
            return false;
        }
    }


    {
        if ($shop !== "all") {
            $Shop = new Shop();
            if (!is_array($Shop->SelectShop($shop))) {
                echo "shop";
                return false;
            }
        }
    }

    //Проверка типа и данных скидки
    {
        $type = $_POST['type'];

        if ($type === "quantity") {
            $post = ['quantity_discount'];
            if (!$function->checking_array_post($post)) {
                echo "error";
                return false;
            }

            $quantity = $_POST['quantity_discount'];
        }
        if ($type === "time") {
            $post = ['start_data', 'finish_data'];
            if (!$function->checking_array_post($post)) {
                echo "data";
                return false;
            } else {

                //Проверка текущей даты
                {
                    $start = date('Y-m-d 00:00:00', strtotime($_POST['start_data']));

                    $currentDateTime = new DateTime();

                    $date = new DateTime($start);

                    if ($date->format('Y-m-d') !== $currentDateTime->format('Y-m-d')) {
                        echo "data";
                        return false;
                    }
                }

                //Сравнение двух дат
                {
                    $finish = date('Y-m-d 23:59:59', strtotime($_POST['finish_data']));

                    if ($finish < $start) {
                        echo "data";
                        return false;
                    }
                }
            }
        }
    }

    //Проверка скожества name И наличия скидки
    {
        $id = $_POST['id'];
        if (!is_array($Discount->selectId($id))) {
            echo "no save";
            return false;
        }

        if(!$Discount->checkingForUniqueness($_POST['name'], $id)){
            echo "no name";
            return false;
        }
    }

    //Сохранение скидки
    {
        $array = [
            'id' => $id,
            'type' => $type,
            'name' => $_POST['name'],
            'quantity' => $quantity,
            'data_start' => $start,
            'data_finish' => $finish,
            'shop' => $shop,
            'percent' => $_POST['percent']
        ];

        $Discount->update($array);

        echo "save";
    }
}