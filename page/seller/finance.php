<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Role.php";


$role = new Role();

if (!$role->Check('seller')) {
    header("Location: /");
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Shop.php");

?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Финнансы</title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<!--Скрытый input активного меню-->

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_finance" data-mini="menu_sidebar_finance_mini">



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


                <div class="col-12">
                    <div class="col-12 d-flex justify-content-between text-dark">
                        <div class="w-48">
                            <div class="col-12 d-flex justify-content-between ">
                                <div class="w-48 p-3 px-4 rounded-4" style="background-color: #E3F5FF;">
                                    <h6 class="fw-bolder my-2">Общая выручка</h6>
                                    <h3 class="my-3 fw-bolder">37 812</h3>
                                </div>

                                <div class="w-48 p-3 px-4 rounded-4" style="background-color: #F7F9FB;">
                                    <h6 class="fw-bolder my-2">Общее кол-во покупок</h6>
                                    <h3 class="my-3 fw-bolder">3 219</h3>
                                </div>
                            </div>

                            <div class="col-12 d-flex mt-4 justify-content-between">
                                <div class="w-48 p-3 px-4 rounded-4" style="background-color: #F7F9FB;">
                                    <h6 class="fw-bolder my-2">Общая сумма на вывод</h6>
                                    <h3 class="my-3 fw-bolder">37 812</h3>
                                </div>

                                <div class="w-48 p-3 px-4 rounded-4" style="background-color: #E5ECF6">
                                    <h6 class="fw-bolder my-2">Доступно для вывода</h6>
                                    <h3 class="my-3 fw-bolder">3 219</h3>
                                </div>
                            </div>
                        </div>

                        <div class="w-48 bg-silver rounded-4 shadow_status">
                            <?php include($_SERVER['DOCUMENT_ROOT'] . "/layouts/chartJs/analitics-lineChart.php"); ?>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between mt-4">
                        <div class="w-48 bg-silver rounded-4 px-3 shadow_status position-relative">
                            <h6 class="my-1 text-14 fw-bolder text-white border-bottom border-secondary py-3">Платежные данные</h6>

                            <div class="d-flex my-4 align-items-center ">
                                <h6 class="text-white my-auto text-14 fw-bolder">USDT</h6>

                                <input type="text" class="d-none input-price-seller mx-3 col-9 border-0 px-2 text-white input_payment">
                                <h6 class="text-white mx-3 my-auto h6_payment ">666vh654gcjtrhhc64cfhkjghjhvf65fhgvyt677877thjb</h6>
                            </div>

                            <button onclick="update_payment_1.call(this)" class="btn btn-bg-seller px-3 text-white position-absolute bottom-0 my-3 update_payment_1 small_shadow">изменить
                            </button>

                            <button onclick="update_payment_2.call(this)" class="btn btn-bg-seller col-3 px-3 text-white position-absolute bottom-0 my-3 d-none update_payment_2 small_shadow">сохранить
                            </button>
                            <button onclick="update_payment_3.call(this)" class="btn btn-dg-danger col-3 px-3 text-white position-absolute bottom-0 my-3 d-none update_payment_3 small_shadow" style="left: 170px;">отмена
                            </button>
                        </div>

                        <div class="w-48 bg-silver rounded-4 px-3 shadow_status position-relative" style="min-height: 250px">

                            <h6 class="my-1 text-14 text-white border-bottom border-secondary py-3 fw-bolder">Оформить заявку на вывод средств</h6>

                            <div class="d-flex my-4">
                                <h6 class="text-white col-4 text-14 fw-bolder">Доступная сумма - </h6>
                                <h6 class="text-white text-14 fw-bolder">$12 434</h6>
                            </div>

                            <div class="d-flex my-4">
                                <h6 class="text-white col-4 text-14 fw-bolder">Впишите сумму</h6>
                                <input type="number" class="text-white border-0 col-4 input-price-seller px-3 tex-14 fw-bolder">
                            </div>

                            <button class="btn btn-bg-seller my-3 px-3 text-white position-absolute bottom-0 small_shadow">оформить</button>
                        </div>
                    </div>

                    <div class="col-12 bg-silver mt-4 p-3 rounded-4 shadow_status">
                        <div class="col-12 d-flex justify-content-between">
                            <div class="col-9 text-white d-flex align-items-center">
                                <span class="text-14 fw-bolder">Ордера на вывод средств</span>
                                <span class="mx-5 text-secondary">|</span>
                                <span class="text-14">Даты</span>

                                <input value="2023-01-01" type="date" class="fw-bolder text-14 border-0 text-white mx-3 input-price-seller px-2">

                                <input value="2023-01-10" type="date" class="text-white text-14 border-0 mx-3 input-price-seller px-2">
                            </div>

                            <div class="dropdown">
                    <span class="text-white fs-6 fw-bolder cursor" id="dropdownMenuButton2"
                          data-bs-toggle="dropdown" aria-expanded="false">&bull;&bull;&bull;</span>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item active" href="#">Топ продаж по сумме</a></li>
                                    <li><a class="dropdown-item" href="#">Топ продаж по кол-ву</a></li>
                                </ul>
                            </div>
                        </div>

                        <table class="col-12 my-3">
                            <tr class="border-bottom border-secondary text-secondary text-12 fw-bolder">
                                <td class="col-1 lh-lg">ID</td>
                                <td class="col-2 lh-lg">Дата</td>
                                <td class="col-5 p-2">Платежные данные</td>
                                <td class="col-2 text-center">Сумма</td>
                                <td class="col-2 text-center">Исполнение</td>
                            </tr>

                            <tr class="text-white" style="font-weight: 400; font-size: 14px; line-height: 20px;">
                                <td class="col-1 lh-lg py-3">196874</td>
                                <td class="col-2 lh-lg">12.12.2022</td>
                                <td class="col-5">USDT 666vh654gcjtrhhc64cfhkjghjhvf65fhgvyt677877thjb</td>
                                <td class="col-2 text-center">$123 930</td>
                                <td class="col-2 text-center">
                                    <div class="col-8 m-auto status_Competed d-flex  align-items-center  my-2">
                                        <div class="elipse_status_Competed p-1 mx-2"></div>
                                        <span>Competed</span>
                                    </div>
                                </td>
                            </tr>

                            <tr class="text-white" style="font-weight: 400; font-size: 14px; line-height: 20px;">
                                <td class="col-1 lh-lg py-2">196874</td>
                                <td class="col-2 lh-lg">12.12.2022</td>
                                <td class="col-5">USDT 666vh654gcjtrhhc64cfhkjghjhvf65fhgvyt677877thjb</td>
                                <td class="col-2 text-center">$123 930</td>
                                <td class="col-2 text-center">
                                    <div class="col-8 m-auto status_In_Progress d-flex align-items-center  my-2">
                                        <div class="elipse_status_In_Progress p-1 mx-2"></div>
                                        <span>In Progress</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <script src="/js/seller/finance.js"></script>
    <script>
        LineChart_week();
        LineChart_month();
        LineChart_year();
    </script>

</body>
</html>