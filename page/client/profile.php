<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Role.php";


$role = new Role();

if ($role->Check('unauthorized')) {
    header("Location: /");
}

?>

<?php
$sql = "SELECT `unique_id`, `name`, `email` FROM `user` WHERE `unique_id` = ?";
$sql = DB::connect()->prepare($sql);
$sql->execute(array($_COOKIE['unique_id']));
$arrayUser = $sql->fetch(PDO::FETCH_ASSOC);
?>

<?php
$sql = "SELECT `telegram`, `2FA` FROM `contacts` WHERE `unique_id` = ?";
$sql = DB::connect()->prepare($sql);
$sql->execute(array($_COOKIE['unique_id']));
$arrayContatcs = $sql->fetch(PDO::FETCH_ASSOC);

if ($arrayContatcs) {
    $telegram = $arrayContatcs['telegram'];
    $FA = $arrayContatcs['2FA'];
} else {
    $telegram = "";
    $FA = "";
}
?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Мой профиль</title>
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
    if ($role)
        require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/sidebar/client.php");
    else require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/sidebar/public.php");
    ?>

    <div class="my-content">
        <?php
        if ($role)
            require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/header/client.php");
        else require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/header/public.php");
        ?>

        <div class="col-12 content-body">
            <div class="myContainer mx-auto my-2">

                <div class="col-12 bg-silver rounded-4 m-auto my-4 p-4 shadow_status">

                    <form action="/backend/script/client/update_profile.php" method="post">


                        <div class="col-10 d-flex align-items-center justify-content-between mt-4 px-3">
                            <div class="col-7 border border-secondary px-4 py-2 rounded-4 border-opacity-50"
                                 style="background: rgba(255, 255, 255, 0.1);">
                                <span class="opacity-50 text-14">Имя</span>
                                <br>

                                <div class="col-10">
                                    <input require_onced name="name" value="<?php echo $arrayUser['name']; ?>"
                                           class="text-white  col-12 input_search_product bg-transparent text-16 fw-medium  rounded-2 border-0 bg-transparent"
                                           type="text"
                                           style=" outline:none;">
                                </div>
                            </div>

                            <div class="col-5 px-5">
                                <h6 class="opacity-50 text-14">Имя отображаемое в системе</h6>
                            </div>
                        </div>

                        <div class="col-10 d-flex align-items-center justify-content-between mt-4 px-3">
                            <div class="col-7 border border-secondary px-4 py-2 rounded-4 border-opacity-50"
                                 style="background: rgba(255, 255, 255, 0.1);">
                                <span class="opacity-50 text-14">Email</span>
                                <br>

                                <div class="col-10">
                                    <input require_onced name="email" value="<?php echo $arrayUser['email']; ?>"
                                           class="text-white  col-12 input_search_product text-16  rounded-2 border-0 bg-transparent"
                                           type="text"
                                           style=" outline:none;">
                                </div>
                            </div>

                            <div class="col-5 px-5">
                                <h6 class="opacity-50 text-14">Email для логина на сайте</h6>
                            </div>
                        </div>

                        <div class="col-10 d-flex align-items-center justify-content-between mt-4 px-3">
                            <div class="col-7 border border-secondary px-4 py-2 rounded-4 border-opacity-50"
                                 style="background: rgba(255, 255, 255, 0.1);">
                                <span class="opacity-50 text-14">Пароль</span>
                                <br>

                                <div class="col-10">
                                    <input name="password" class="text-white  col-12 input_search_product text-16  rounded-2 border-0 bg-transparent"
                                           type="text"
                                           style=" outline:none;">
                                </div>
                            </div>

                            <div class="col-5 px-5">
                                <h6 class="opacity-50 text-14">Пароль для логина на сайте</h6>
                            </div>
                        </div>

                        <div class="col-10 d-flex align-items-center justify-content-between mt-4 px-3">
                            <div class="col-7 border border-secondary px-4 py-2 rounded-4 border-opacity-50"
                                 style="background: rgba(255, 255, 255, 0.1);">
                                <span class="opacity-50 text-14">Telegram</span>
                                <br>

                                <div class="col-10">
                                    <input name="telegram" value="<?php echo $telegram; ?>"
                                           class="text-white  col-12 input_search_product text-13  rounded-2 border-0 bg-transparent"
                                           type="text"
                                           style=" outline:none;">
                                </div>
                            </div>

                            <div class="col-5 px-5">
                                <h6 class="opacity-50 text-14">Контакт для связи</h6>
                            </div>
                        </div>

                        <div class="col-10 d-flex align-items-center justify-content-between mt-4 px-3">
                            <div class="col-7 border border-secondary px-4 py-2 rounded-4 border-opacity-50"
                                 style="background: rgba(255, 255, 255, 0.1);">
                                <span class="opacity-50 text-14">2FA</span>
                                <br>

                                <div class="col-10">
                                    <input  name="too_fa" value="<?php echo $FA; ?>"
                                            class="text-white  col-12 input_search_product text-13  rounded-2 border-0 bg-transparent"
                                            type="text"
                                            style=" outline:none;">
                                </div>
                            </div>

                            <div class="col-5 px-5">
                                <h6 class="opacity-50 text-14">Контакт для связи</h6>
                            </div>
                        </div>

                        <div class="col-6">
                            <button type="submit" style="border: 1px solid #1877F2 !important;"
                                    class="d-block mx-auto my-4 mt-5 text-dark text-14 rounded-3 bg-transparent border-0 text-white py-1 px-4">
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-12 d-flex justify-content-between my-4 rounded-4 bg-silver" style="min-height: 250px;">

                </div>

            </div>
        </div>
    </div>
</div>



</body>
</html>