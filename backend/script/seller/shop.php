<?php
require_once($_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php");
require_once($_SERVER['DOCUMENT_ROOT']."/backend/Class/Shop.php");
require_once($_SERVER['DOCUMENT_ROOT']."/backend/Class/MyFunction.php");

if(isset($_POST['action'])) {
    $action = $_POST['action'];

    if($action == "create_shop") {
        Create();
    }
    if($action == "update_shop") {
        Update();
    }
}

function Create(): void
{
    $my_function = new MyFunction();
    $shop = new Shop();

    $array = [
        'name',
        'heading',
        'txt_description_shop',
        'txt_lower_description_shop'
    ];


    if($my_function->checking_array_post($array)){
        $name = $_POST['name'];
        $heading = $_POST['heading'];
        $imgCover = $_FILES['imgCover'];
        $imgLogo = $_FILES['imgLogo'];
        $description_shop = $_POST['txt_description_shop'];
        $lower_description = $_POST['txt_lower_description_shop'];
        $directory = $_SERVER['DOCUMENT_ROOT'].'/res/img/imgShop/';

        $nameImg = $my_function->getExtension($imgCover['name']);
        $name_imgCover = $my_function->random().".".pathinfo($nameImg)['filename'];
        move_uploaded_file($_FILES['imgCover']['tmp_name'], $directory.$name_imgCover);

        $nameImg = $my_function->getExtension($imgLogo['name']);
        $name_imgLogo = $my_function->random().".".pathinfo($nameImg)['filename'];
        move_uploaded_file($_FILES['imgLogo']['tmp_name'], $directory.$name_imgLogo);

        $array = [
            "seller_id" => $_COOKIE['unique_id'],
            "name" => $name,
            "heading" => $heading,
            "cover" => $name_imgCover,
            "logo" => $name_imgLogo,
            "description" => $description_shop,
            "lower_description" => $lower_description,
            "rating" => 0,
            "type_rating" => "rating"
        ];

        $shop->Create($array);
        header('Location: /page/seller/decoration');
    }
}


function Update() {
    $db = DB::connect();
    $my_function = new MyFunction();
    $shop = new Shop();

    $unique_id = $_COOKIE['unique_id'];
    $name = $_POST['name'];
    $heading = $_POST['heading'];
    $imgCover = $_FILES['imgCover'];
    $imgLogo = $_FILES['imgLogo'];
    $description_shop = $_POST['txt_description_shop'];
    $lower_description = $_POST['txt_lower_description_shop'];

    $directory = $_SERVER['DOCUMENT_ROOT'].'/res/img/imgShop/';

    if($_FILES['imgCover']['name'] == "" &&  $_FILES['imgLogo']['name'] == "") {
        $sth = $db->prepare("UPDATE `shop` SET `name` = ?, `heading` = ?, `description` = ?, `lower_description` = ? WHERE `seller_id` = ?");
        $sth->execute(array($name, $heading, $description_shop, $lower_description, $unique_id));
    }
    if($_FILES['imgCover']['name'] != "" &&  $_FILES['imgLogo']['name'] == "") {
        $name = $my_function->getExtension($imgCover['name']);
        $name_imgCover = $my_function->random().".".pathinfo($name)['filename'];
        move_uploaded_file($_FILES['imgCover']['tmp_name'], $directory.$name_imgCover);

        $sth = $db->prepare("UPDATE `shop` SET `name` = ?, `heading` = ?, `cover` = ?, `description` = ?, `lower_description` = ? WHERE `seller_id` = ?");
        $sth->execute(array($name, $heading, $name_imgCover, $description_shop, $lower_description, $unique_id));
    }
    if($_FILES['imgCover']['name'] == "" &&  $_FILES['imgLogo']['name'] != "") {
        $name = $my_function->getExtension($imgLogo['name']);
        $name_imgLogo = $my_function->random().".".pathinfo($name)['filename'];
        move_uploaded_file($_FILES['imgLogo']['tmp_name'], $directory.$name_imgLogo);

        $sth = $db->prepare("UPDATE `shop` SET `name` = ?, `heading` = ?, `logo` = ?, `description` = ?, `lower_description` = ? WHERE `seller_id` = ?");
        $sth->execute(array($name, $heading, $name_imgLogo, $description_shop, $lower_description, $unique_id));
    }

    if($_FILES['imgCover']['name'] != "" &&  $_FILES['imgLogo']['name'] != "") {
        $name = $my_function->getExtension($imgCover['name']);
        $name_imgCover = $my_function->random().".".pathinfo($name)['filename'];
        move_uploaded_file($_FILES['imgCover']['tmp_name'], $directory.$name_imgCover);

        $name = $my_function->getExtension($imgLogo['name']);
        $name_imgLogo = $my_function->random().".".pathinfo($name)['filename'];
        move_uploaded_file($_FILES['imgLogo']['tmp_name'], $directory.$name_imgLogo);

        $sth = $db->prepare("UPDATE `shop` SET `name` = ?, `heading` = ?, `cover` = ?, `logo` = ?, `description` = ?, `lower_description` = ? WHERE `seller_id` = ?");
        $sth->execute(array($name, $heading, $name_imgCover, $name_imgLogo, $description_shop, $lower_description, $unique_id));
    }

    header('Location: /page/seller/decoration');
}

