<?php


if(isset($_POST['action'])){
    $action = $_POST['action'];

    if($action === "ajax_status"){
        ajax_status();
    }
}



function ajax_status() {
    if (isset($_COOKIE['statusMenu']))
    {
        if($_COOKIE['statusMenu'] === "closed") {
            setcookie("statusMenu", "open", time()+3600, "/");
            echo "open";
        }
        else {
            setcookie("statusMenu", "closed", time()+3600, "/");
            echo "closed";
        }
    }
    else {
        setcookie("statusMenu", "closed", time()+3600, "/");
        echo "closed";
    }
}


function status_menu() {
    if (isset($_COOKIE['statusMenu']))
    {
        if($_COOKIE['statusMenu'] === "closed") {
            return "closed";
        }
        else {
            return "open";
        }
    }
    else {
        return "open";
    }
}