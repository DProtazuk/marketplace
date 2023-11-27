<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Role.php";


$role = new Role();

if ($role->Check('unauthorized')) {
    header("Location: /");
}
if ($role->Check('seller')) {
    header("Location: /page/seller/dashboard");
}

?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Макет</title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<!--Скрытый input активного меню-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_main" data-mini="menu_sidebar_active_uniq_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_analytics" data-mini="menu_sidebar_analytics_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops" data-mini="menu_sidebar_shops_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_product"-->
<!--       data-mini="menu_sidebar_product_mini">-->


<!--Скрытый input Шапки меню-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-orders">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-balance">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-favorites">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-return_product">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-referral_program">-->



<div class="col-12 d-flex h-100">

    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/sidebar/client.php");
    ?>

    <div class="my-content">
        <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/header/client.php");
        ?>

        <div class="col-12 content-body">
            <div class="myContainer mx-auto my-2">

                Тут текст чтоб стать поставщиком
                <br>
                <br>
                <a href="/page/seller/test">Стать поставщиком!</a>


            </div>
        </div>
    </div>
</div>



</body>
</html>