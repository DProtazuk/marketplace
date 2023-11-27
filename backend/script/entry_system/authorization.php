<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/User.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/MyFunction.php");

$my_function = new MyFunction();
$User = new User();

$arrayPost = [
    'email',
    'password'
];


if($my_function->checking_array_post($arrayPost)) {

    $link_error = "/page/entry_system/authorization?email=".$_POST['email']."&password=".$_POST['password']."&error=";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $User->Authorization($email, $password);

    switch ($result) {
        case "password":
        case "email":
            header('Location: '.$link_error.$result);
            break;
        case "authorization":
            header('Location: /page/public/main');
            break;
    }
}
else header('Location: /page/entry_system/authorization?error=info');