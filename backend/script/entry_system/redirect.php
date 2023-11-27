<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");

if(isset($_COOKIE['unique_id'])){
    $sth = $pdo->prepare("SELECT * FROM `user` WHERE `unique_id` = ?");
    $sth->execute(array($_COOKIE['unique_id']));
    $array = $sth->fetch(PDO::FETCH_ASSOC);

    if(!$array){
        redirect();
    }
}
else redirect();

function redirect(){
    header("Location: /page/unauthorized/registration");
}