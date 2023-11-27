<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Role.php";
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
    <title>Дашборд</title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js" integrity="sha512-7U4rRB8aGAHGVad3u2jiC7GA5/1YhQcQjxKeaVms/bT66i3LVBMRcBI9KwABNWnxOSwulkuSXxZLGuyfvo7V1A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script></head>
<body>


<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_dashboard"
       data-mini="menu_sidebar_sales_mini">


<div class="col-12 d-flex h-100">

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/sidebar/admin.php"); ?>

    <div class="my-content">
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/header/admin.php"); ?>

        <div class="col-12 content-body">
            <div class="myContainer mx-auto my-2">

                <div class="col-12 px-3">
                    <h6 class="fw-bolder text-14">Сегодня</h6>
                </div>

                <div class="col-12 d-flex justify-content-between text-dark">
                    <div class="w-48">
                        <div class="col-12 d-flex justify-content-between">
                            <!--                                <div class="w-48 bg-mini-div-green p-3 px-4 rounded-4">-->
                            <!--                                    <h6 class="fw-bolder my-2">Единиц продано</h6>-->
                            <!--                                    <h3 class="my-3">37 812</h3>-->
                            <!--                                </div> -->

                            <div class="w-48 p-3 px-4 rounded-4" style="background-color: #E3F5FF;">
                                <h6 class="fw-bolder my-2">Единиц продано</h6>
                                <h3 class="my-3 fw-bolder"><?php echo 111; ?></h3>
                            </div>

                            <div class="w-48 p-3 px-4 rounded-4" style="background-color: #F7F9FB;">
                                <h6 class="fw-bolder my-2">Кол-во покупок</h6>
                                <h3 class="my-3 fw-bolder"><?php echo 111; ?></h3>
                            </div>
                        </div>

                        <div class="col-12 d-flex mt-4 justify-content-between">
                            <div class="w-48 p-3 px-4 rounded-4" style="background-color: #F7F9FB;">
                                <h6 class="fw-bolder my-2">Выручка</h6>
                                <h3 class="my-3 fw-bolder"><?php echo 11111; ?></h3>
                            </div>

                            <div class="w-48 p-3 px-4 rounded-4" style="background-color: #E5ECF6">
                                <h6 class="fw-bolder my-2">Доступно для вывода</h6>
                                <h3 class="my-3 fw-bolder">3 219</h3>
                            </div>
                        </div>
                    </div>

                    <div class="w-48 bg-silver rounded-4 shadow_status text-white p-2">
                        <div class="col-12 border border-0 border-bottom border-secondary d-flex justify-content-between border-opacity-50 py-3">
                            <div class="col-4 px-3 border border-secondary border-0 border-end border-opacity-50">
                                <h6 class="text-14">Выплаты пост.</h6>
                                <h6 class="mt-3 fs-5">500 000 р.</h6>
                            </div>


                            <div class="col-4 px-3 border border-secondary border-0 border-end border-opacity-50">
                                <h6 class="text-14">За сегоня</h6>
                                <h6 class="mt-3 fs-5">19,000 р.</h6>
                            </div>

                            <div class="col-5 px-3 ">

                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-between align-items-center px-3">
                            <canvas style="max-height: 100%" class="myLineChart LineChart_week" id="LineChart_week"></canvas>
                        </div>
                    </div>
                </div>


                <div class="col-12 d-flex justify-content-between text-dark my-4">
                    <div class="w-48 bg-silver rounded-4 shadow_status text-white p-2">
                        <div class="col-12 d-flex justify-content-between align-items-center p-3">
                            <span class="text-white fw-bolder text-14 text_LineChart">Выручка за неделю</span>
                            <span class="text-white opacity-25 fw-light fw-bolder">|</span>

                            <div class="d-flex align-items-center">
                                <div class="circle_violet"></div>
                                <span class="text-white text-12 mx-2">Продажи $<span class="current">10,000</span></span>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="circle_blue"></div>
                                <span class="text-white text-12 mx-2">Прибыль  $<span class="previous">9,078</span></span>
                            </div>

                            <div class="dropdown">
        <span class="lh-1 text-white fs-6 fw-bolder cursor" data-bs-toggle="dropdown"
              aria-expanded="false">&bull;&bull;&bull;</span>
                                <ul class="dropdown-menu dropdown-menu-dark border-light border-opacity-25">
                                    <li>
                                        <a data-current="4700" data-previous="5500" data-text="неделю" data-canvas="LineChart_week"
                                           onclick=""
                                           class="cursor dropdown-item point_menu_LineChart">Выручка за неделю</a>
                                    </li>

                                    <li>
                                        <a data-current="4500" data-previous="6000" data-text="месяц" data-canvas="LineChart_month"
                                           onclick="" class="cursor dropdown-item point_menu_LineChart active_point_menu">Выручка
                                            за месяц</a>
                                    </li>

                                    <li>
                                        <a data-current="8000" data-previous="9000" data-text="год" data-canvas="LineChart_year"
                                           onclick="" class="cursor dropdown-item point_menu_LineChart">Выручка
                                            за год</a>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div class="col-12 d-flex justify-content-between align-items-center px-3">
                            <canvas style="max-height: 100%" class="myLineChart" id="LineChart_revenue"></canvas>
                        </div>


                    </div>

                    <div class="w-48 bg-silver rounded-4 shadow_status text-white p-2">

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="/js/admin/dashboard.js"></script>

</body>
</html>