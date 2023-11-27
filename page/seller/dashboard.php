<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Role.php";


$role = new Role();

if (!$role->Check('seller')) {
    header("Location: /");
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/script/seller/statistics.php");


?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Дашборд</title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<!--Скрытый input активного меню-->

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_dashboard" data-mini="menu_sidebar_dashboard_mini">


<div class="col-12 d-flex h-100">

    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/sidebar/seller.php");
    ?>

    <div class="my-content">
        <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/header/seller.php");
        ?>

        <div class="col-12 content-body">
            <div class="myContainer mx-auto my-2">


                <div class="col-12 d-flex justify-content-between text-dark">
                    <div class="w-48">
                        <div class="col-12 d-flex justify-content-between">
                            <!--                                <div class="w-48 bg-mini-div-green p-3 px-4 rounded-4">-->
                            <!--                                    <h6 class="fw-bolder my-2">Единиц продано</h6>-->
                            <!--                                    <h3 class="my-3">37 812</h3>-->
                            <!--                                </div> -->

                            <div class="w-48 p-3 px-4 rounded-4" style="background-color: #E3F5FF;">
                                <h6 class="fw-bolder my-2">Единиц продано</h6>
                                <h3 class="my-3 fw-bolder"><?php echo ReturnUnitsSold(); ?></h3>
                            </div>

                            <div class="w-48 p-3 px-4 rounded-4" style="background-color: #F7F9FB;">
                                <h6 class="fw-bolder my-2">Кол-во покупок</h6>
                                <h3 class="my-3 fw-bolder"><?php echo ReturnNumberOfPurchases(); ?></h3>
                            </div>
                        </div>

                        <div class="col-12 d-flex mt-4 justify-content-between">
                            <div class="w-48 p-3 px-4 rounded-4" style="background-color: #F7F9FB;">
                                <h6 class="fw-bolder my-2">Выручка</h6>
                                <h3 class="my-3 fw-bolder"><?php echo ReturnRevenue(); ?></h3>
                            </div>

                            <div class="w-48 p-3 px-4 rounded-4" style="background-color: #E5ECF6">
                                <h6 class="fw-bolder my-2">Доступно для вывода</h6>
                                <h3 class="my-3 fw-bolder">3 219</h3>
                            </div>
                        </div>
                    </div>

                    <div class="w-48 bg-silver rounded-4 shadow_status">
                        <div class="col-12 d-flex justify-content-between align-items-center p-3">
                            <span class="text-white fw-bolder text-14 text_LineChart">Выручка за месяц</span>
                            <span class="text-white opacity-25 fw-light fw-bolder">|</span>

                            <div class="d-flex align-items-center">
                                <div class="elipse_current"></div>
                                <span class="text-white text-12 mx-2">Текущая $<span class="current">10,000</span></span>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="elipse_previous"></div>
                                <span class="text-white text-12 mx-2">Предыдущая  $<span class="previous">9,078</span></span>
                            </div>

                            <div class="dropdown">
        <span class="lh-1 text-white fs-6 fw-bolder cursor" data-bs-toggle="dropdown"
              aria-expanded="false">&bull;&bull;&bull;</span>
                                <ul class="dropdown-menu dropdown-menu-dark border-light border-opacity-25">
                                    <li>
                                        <a data-current="4700" data-previous="5500" data-text="неделю" data-canvas="LineChart_week"
                                           onclick="point_menu_analytics_LineChart.call(this)"
                                           class="cursor dropdown-item point_menu_LineChart">Выручка за неделю</a>
                                    </li>

                                    <li>
                                        <a data-current="4500" data-previous="6000" data-text="месяц" data-canvas="LineChart_month"
                                           onclick="point_menu_analytics_LineChart.call(this)" class="cursor dropdown-item point_menu_LineChart active_point_menu">Выручка
                                            за месяц</a>
                                    </li>

                                    <li>
                                        <a data-current="8000" data-previous="9000" data-text="год" data-canvas="LineChart_year"
                                           onclick="point_menu_analytics_LineChart.call(this)" class="cursor dropdown-item point_menu_LineChart">Выручка
                                            за год</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-between align-items-center ">
                            <canvas class="myLineChart LineChart_week d-none" id="LineChart_week"></canvas>
                            <canvas class="myLineChart LineChart_month" id="LineChart_month"></canvas>
                            <canvas class="myLineChart LineChart_year d-none" id="LineChart_year"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4 d-flex justify-content-between text-14">
                    <div class="col-9 bg-silver p-3 rounded-4 shadow_status">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <span class="text-white fw-bolder text-BarChart">Кол-во продаж по категориям</span>

                            <div class="dropdown">
                        <span class="text-white d-block fs-6 fw-bolder cursor" id="dropdownMenuButton2"
                              data-bs-toggle="dropdown"">&bull;&bull;&bull;</span>
                                <ul class="dropdown-menu dropdown-menu-dark border-light border-opacity-25" aria-labelledby="dropdownMenuButton2">
                                    <li>
                                        <a onclick="point_menu_analytics_barChart.call(this)" data-text="Кол-во продаж по категориям" data-canvas="barChart_Number_of_sales_by_category" class="cursor dropdown-item point_menu_BarChart active_point_menu">Кол-во продаж по категориям</a>
                                    </li>
                                    <li>
                                        <a onclick="point_menu_analytics_barChart.call(this)" data-text="Сумма продаж по товарам" data-canvas="barChart_amount_of_sales_by_product" class="cursor dropdown-item point_menu_BarChart">Сумма продаж по товарам</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Сумма продаж по категориям</a></li>
                                    <li><a class="dropdown-item" href="#">Сумма продаж по категориям</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <canvas class="myBarChart barChart_Number_of_sales_by_category" id="barChart_Number_of_sales_by_category"></canvas>

                            <canvas class="myBarChart barChart_amount_of_sales_by_product d-none" id="barChart_amount_of_sales_by_product"></canvas>
                        </div>
                    </div>

                    <div class="col-3 d-flex justify-content-end">
                        <div class="col-11 bg-silver p-2 rounded-4 shadow_status">
                            <h6 class="text-center text-white my-3">Рейтинг шопа</h6>

                            <h6 class="text-white text-center text-48 my-2">5.0</h6>

                            <div class="col-12 d-flex justify-content-center">
                                <img src="/res/img/star.png">
                                <img src="/res/img/star.png">
                                <img src="/res/img/star.png">
                                <img src="/res/img/star.png">
                                <img src="/res/img/star.png">
                            </div>

                            <h6 class="text-white text-center fw-lighter my-1">Превосходно!</h6>

                            <h6 class="text-white text-center text-48 my-2 mt-4">2.7%</h6>
                            <h6 class="text-center text-white my-2 text-14">Процент возвратов товара</h6>
                        </div>
                    </div>
                </div>


                <div class="col-12 mt-4 d-flex justify-content-between ">
                    <div class="col-9 bg-silver p-3 rounded-4 shadow_status">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <span class="text-white fw-bolder text-14">Топ продаж по сумме</span>

                            <div class="dropdown">
                                <span class="text-white fw-bolder cursor id="dropdownMenuButton2"
                                data-bs-toggle="dropdown" aria-expanded="false">&bull;&bull;&bull;</span>
                                <ul class="dropdown-menu dropdown-menu-dark text-14" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item active" href="#">Топ продаж по сумме</a></li>
                                    <li><a class="dropdown-item" href="#">Топ продаж по кол-ву</a></li>
                                </ul>
                            </div>
                        </div>

                        <table class="col-12 my-3 text-12 ">
                            <tr class="border-bottom border-secondary text-secondary fw-bolder">
                                <td class="col-7 py-2">Наименование</td>
                                <td class="col-1 text-center">Цена</td>
                                <td class="col-2 text-center">Кол-во</td>
                                <td class="col-2 text-center">Сумма</td>
                            </tr>

                            <tr class="text-white">
                                <td class="col-7 lh-lg text-12 td_seller">
                                    <a class="text-decoration-none text-white" href="">Facebook [ПЗРД] USA фарм 30д.
                                        Интересы+,
                                        coockie, UA, 2fa, +2BM</a>
                                </td>
                                <td class="col-1 text-center td_seller">$15</td>
                                <td class="col-2 text-center td_seller">8262</td>
                                <td class="col-2 text-center td_seller">$123 930</td>
                            </tr>

                            <tr class="text-white">
                                <td class="col-7 lh-lg text-12 td_seller">
                                    <a class="text-decoration-none text-white" href="">Facebook [ПЗРД] USA фарм 30д.
                                        Интересы+,
                                        coockie, UA, 2fa, +2BM</a>
                                </td>
                                <td class="col-1 text-center td_seller">$15</td>
                                <td class="col-2 text-center td_seller">8262</td>
                                <td class="col-2 text-center td_seller">$123 930</td>
                            </tr>

                            <tr class="text-white">
                                <td class="col-7 lh-lg text-12 td_seller">
                                    <a class="text-decoration-none text-white" href="">Facebook [ПЗРД] USA фарм 30д.
                                        Интересы+,
                                        coockie, UA, 2fa, +2BM</a>
                                </td>
                                <td class="col-1 text-center td_seller">$15</td>
                                <td class="col-2 text-center td_seller">8262</td>
                                <td class="col-2 text-center td_seller">$123 930</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-3 d-flex justify-content-end">
                        <div class="col-11 bg-silver p-2 rounded-4 shadow_status">

                        </div>
                    </div>


            </div>
        </div>
    </div>
</div>



</body>
</html>