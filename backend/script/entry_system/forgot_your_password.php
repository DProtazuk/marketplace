<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/User.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/MyFunction.php");

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");

$my_function = new MyFunction();
$User = new User();

$arrayPost = [
    'email'
];

if ($my_function->checking_array_post($arrayPost)) {
    $email = $_POST['email'];

    $link_error = "/page/entry_system/forgot_your_password?email=" . $email . "&error=";

    $result = $User->PasswordReset($email);

    switch ($result) {
        case "time":
        case "email":
            header('Location: ' . $link_error . $result);
            break;
        case "send":
            header('Location: /page/entry_system/forgot_your_password?status=send');
            break;
    }
} else {
    header('Location: /page/entry_system/forgot_your_password?error=info');
}