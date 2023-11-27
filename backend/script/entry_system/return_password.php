<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/MyFunction.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/User.php");

$my_function = new MyFunction();
$Class = new User();


$arrayPost = [
    'password',
    'second_password',
    'link'
];


if ($my_function->checking_array_post($arrayPost)) {
    $link_error = "/page/entry_system/return_password?key=" . $_POST['link'] . "&error=";

    $password = $_POST['password'];
    $second_password = $_POST['second_password'];
    $link = $_POST['link'];

    $link_error = "/page/entry_system/return_password?key=" . $link . "&error=";

    $result = $Class->SaveNewPassword($link, $password, $second_password);

    switch ($result) {
        case "password":
        case "link":
            header('Location: '.$link_error.$result);
            break;
        case "save":
            header('Location: /page/entry_system/authorization?status=forgot_save');
            break;
    }
}
else header("Location: /page/entry_system/return_password?key=" . $_POST['link'] . "&error=info");