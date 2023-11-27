<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
$role = new Role();

if (!$role->Check('admin')) {
    header("Location: /");
}


?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Клиенты</title>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>


<!--Скрытый input активного меню-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_main" data-mini="menu_sidebar_active_uniq_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_analytics" data-mini="menu_sidebar_analytics_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops" data-mini="menu_sidebar_shops_mini">-->

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_users"
       data-mini="menu_sidebar_sales_mini" data-submenu="h4-client">


<!--Скрытый input Шапки меню-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-orders">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-balance">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-favorites">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-return_product">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-referral_program">-->


<div class="col-12 d-flex h-100">
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/sidebar/admin.php");
    ?>

    <div class="my-content">

        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/header/admin.php");
        ?>

        <div class="col-12 content-body">
            <div class="myContainer mx-auto my-2">


                <div class="col-12 bg-silver rounded-4 m-auto p-4 shadow_status">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div class="input-price-seller col-8" style="min-height: 28px; !important;">
                            <input oninput="rendering()"
                                   class="px-5 text-white col-12 input_search_seller text-14 rounded-2 shadow-none border_input clear_input"
                                   type="text"
                                   style="background: url('/res/img/search.svg') no-repeat left;background-position: 3% 100%; background-position-y: center; background-size: 5% 55%; outline:none; background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                        </div>


                        <div class="col-2 d-flex justify-content-end">
                            <div class="select select_Filter_shops input-price-seller rounded-2 w-100 text-13 bg_silver border_input"
                                 style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px !important; max-height: 28px; !important;">
                                <input class="select__input select__input_Filter_shops" type="hidden" value="default">
                                <div class="select__head select__head_Filter_shops text-white px-2 text-13 text-opacity-75 d-flex align-items-center"
                                     style="min-height: 28px; !important;"><h6 class="text-14 my-auto">Фильтровать
                                        по</h6>
                                </div>
                                <ul class="select__list select__list_Filter_shops p-1 bg-opacity-50 rounded-2"
                                    style="display: none;">
                                    <li id="ascending_price"
                                        class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">
                                        по цене &uarr;
                                    </li>
                                    <li id="decreasing_price"
                                        class="select__item select__item_Filter_shops py-1 d-flex align-items-center">по
                                        цене &darr;
                                    </li>
                                    <li id="ascending_rating"
                                        class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">
                                        по рейтингу &uarr;
                                    </li>
                                    <li id="decreasing_rating"
                                        class="select__item select__item_Filter_shops py-1 d-flex align-items-center">по
                                        рейтингу &darr;
                                    </li>
                                    <li id="ascending_name"
                                        class="select__item select__item_Filter_shops py-1 d-flex align-items-center">по
                                        названию &uarr;
                                    </li>
                                    <li id="decreasing_name"
                                        class="select__item select__item_Filter_shops py-1 d-flex align-items-center">по
                                        названию &darr;
                                    </li>
                                    <li id="ascending_quantity"
                                        class="select__item select__item_Filter_shops py-1 d-flex align-items-center">по
                                        кол-ву &uarr;
                                    </li>
                                    <li id="decreasing_quantity"
                                        class="select__item select__item_Filter_shops py-1 d-flex align-items-center">по
                                        кол-ву &darr;
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-0">

                    <div class="col-12">

                        <div class="col-12 d-flex text-12 text-secondary border-secondary border-bottom py-2 align-items-center">
                            <div class="col-1">ID</div>
                            <div class="col-2">Логин</div>
                            <div class="col-2">Email</div>
                            <div class="col-1">TG</div>
                            <div class="col-2">Кол-во заказов</div>
                            <div class="col-2">Сумма заказов</div>
                            <div class="col-1">Баланс</div>
                            <div class="col-1"></div>
                        </div>

                        <div class="col-12 div_seller">

                            <div class="col-12 d-flex text-14 text-white border-secondary border-bottom  align-items-center py-4">


                                <div class="col-1 py-2">24536236</div>
                                <div class="col-2">Пользователь1</div>
                                <div class="col-2">email@gmail.com</div>
                                <div class="col-1">fsdfds</div>
                                <div class="col-2">dasdasd</div>
                                <div class="col-2">10050</div>
                                <div class="col-1">10500</div>

                                <div class="col-1 d-flex justify-content-end">
                                    <button class="py-1 px-3 border border-secondary rounded-3 text-white text-center bg-transparent">Открыть</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="/js/client/paginate.js"></script>
<script type="text/javascript" src="/js/admin/users/client/search.js"></script>

<style>
    input[type=date]::-webkit-calendar-picker-indicator {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 24 24"><path fill="%23bbbbbb" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>');
    }
</style>

</body>
</html>