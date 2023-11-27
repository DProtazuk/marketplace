<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php";
$role = new Role();

if (!$role->Check('admin')) {
    header("Location: /");
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Orders.php";
$orders = new Orders();
$orders = $orders->salesToday();
?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Магазины</title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops"
       data-mini="menu_sidebar_shops_mini">

<div class="col-12 d-flex h-100">

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/sidebar/admin.php"); ?>

    <div class="my-content">
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/header/admin.php"); ?>

        <div class="col-12 content-body">
            <div class="myContainer mx-auto my-2">

                <div class="col-12 bg-silver rounded-4 m-auto my-4 p-4 shadow_status">
                    <div class="col-12 d-flex justify-content-between align-items-center">

                        <div class="col-5 d-flex justify-content-between align-items-center">
                            <h6 class="text-14 fw-bolder my-auto">Магазины</h6>

                            <div class="input-price-seller col-9" style="min-height: 28px; !important;">
                                <input oninput="rendering()" class="px-5 text-white col-12 input_search_shops text-14 rounded-2 shadow-none border_input"
                                       type="text"
                                       style="background: url('/res/img/search.svg') no-repeat left;background-position: 3% 100%; background-position-y: center; background-size: 5% 55%; outline:none; background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                            </div>
                        </div>

                        <div class="col-3 d-flex justify-content-end">
                            <div class="select select_Filter_shops input-price-seller rounded-2 w-75 text-13 bg_silver border_input"
                                 style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px !important; max-height: 28px; !important;">
                                <input class="select__input select__input_Filter_shops" type="hidden" value="default">
                                <div class="select__head select__head_Filter_shops text-white px-2 text-13 text-opacity-75 d-flex align-items-center"
                                     style="min-height: 28px; !important;"><h6 class="text-14 my-auto">Фильтровать
                                        по</h6>
                                </div>
                                <ul class="select__list select__list_Filter_shops p-1 bg-opacity-50 rounded-2"
                                    style="display: none;">
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
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3 opacity-0">

                    <table class="col-12 main-table">
                        <tr class="border-bottom border-secondary text-secondary text-12 fw-bolder">
                            <td class="col-1 lh-lg">ID</td>
                            <td class="col-9">
                                <table class="col-12">
                                    <tr>
                                        <td class="col-2">Шоп</td>
                                        <td class="col-2">Владелец</td>
                                        <td class="col-2">Кол-во продаж</td>
                                        <td class="col-2">Рейтинг</td>
                                        <td class="col-2">Баланс</td>
                                        <td class="col-2">Доступно</td>
                                    </tr>
                                </table>
                            </td>
                            <td class="col-12 d-flex justify-content-center">
                                <a href="" class="col-7 py-1 a_shops rounded-3 text-center text-decoration-none border text-white border-secondary">
                                    Открыть
                                </a>
                            </td>
                        </tr>
                    </table>

                    <div class="col-12">

                        <div class="col-12 d-flex justify-content-center mt-4">
                            <div id="pagination-container">
                                <!-- здесь будут отображаться элементы -->
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script src="/js/client/paginate.js"></script>
<script src="/js/admin/shops.js"></script>
<style>
    input[type=date]::-webkit-calendar-picker-indicator {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 24 24"><path fill="%23bbbbbb" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>');
    }
    .a_shops:hover {
        color: var(--blue-color) !important;
        border-color: var(--blue-color) !important;
    }


</style>

</body>
</html>