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
    <title>Продажи</title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_sales"
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

                <div class="col-12 mt-3 d-flex justify-content-between text-dark">

                    <div class="w-23 p-3 px-4 rounded-4" style="background-color: #E3F5FF;">
                        <h6 class="fw-bolder my-2">Едениц продано</h6>
                        <h3 class="my-3 fw-bolder quantity_h3">
                            <h3 class="my-3 fw-bolder"><?php echo !empty($orders['quantity']) ? $orders['quantity'] : 0; ?></h3>
                        </h3>
                    </div>

                    <div class="w-23 p-3 px-4 rounded-4" style="background-color: #F7F9FB;">
                        <h6 class="fw-bolder my-2">Покупок</h6>
                        <h3 class="my-3 fw-bolder price_h3">
                            <?php echo $orders['count']; ?>
                        </h3>
                    </div>

                    <div class="w-23 p-3 px-4 rounded-4" style="background-color: #E3F5FF;">
                        <h6 class="fw-bolder my-2">Сумма продаж</h6>
                        <h3 class="my-3 fw-bolder"><?php echo !empty($orders['amount']) ? $orders['amount'] : 0; ?></h3>
                    </div>

                    <div class="w-23 p-3 px-4 rounded-4" style="background-color: #F7F9FB;">
                        <h6 class="fw-bolder my-2">Возвраты</h6>
                        <h3 class="my-3 fw-bolder">0</h3>
                    </div>
                </div>

                <div class="col-12 bg-silver rounded-4 m-auto my-5 p-4 shadow_status">

                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div class="col-3 d-flex align-items-center">
                            <h6 data-type="sales" class="fw-bolder text-14 h6_type text-secondary cursor my-auto"
                                onclick="clickType(this)">Продажи</h6>
                            <h6 class="mx-4 my-auto text-secondary fw-bolder">|</h6>
                            <h6 data-type="refunds" class="fw-bolder text-14 h6_type text-secondary cursor my-auto"
                                onclick="clickType(this)">Возвраты</h6>
                        </div>

                        <div class="col-9 text-white d-flex align-items-center">

                            <div class="input-price-seller col-5" style="min-height: 28px; !important;">

                                <input value="" oninput="rendering()"
                                       class="px-5 text-white col-12 input_search text-14 rounded-2 shadow-none border_input"
                                       type="text"
                                       style="background: url('/res/img/search.svg') no-repeat left;background-position: 3% 100%; background-position-y: center; background-size: 5% 55%; outline:none; background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                            </div>

                            <span class="text-14 mx-5 fw-bolder">Даты</span>

                            <input oninput="rendering()" id="start_data"
                                   value="<?php echo date('Y-m-d', strtotime('-1 month')); ?>" type="date"
                                   class="text-14 text-white mx-3 input-price-seller px-2 py-1 rounded-2 border_input input-data"
                                   style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">

                            <input oninput="rendering()" id="finish_data" value="<?php echo date('Y-m-d'); ?>"
                                   type="date"
                                   class="text-14 text-white mx-3 input-price-seller px-2 py-1 rounded-2 border_input input-data"
                                   style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                        </div>
                    </div>

                    <table class="col-12 my-4">

                    </table>

                    <div class="col-12 table_sales">

                        <div class="col-12 d-flex border-bottom border-secondary text-secondary text-12 fw-bolder">
                            <div class="col-1 lh-lg">Ордер</div>
                            <div class="col-1 lh-lg">Дата</div>
                            <div class="col-4">Наименование</div>
                            <div class="col-6 d-flex">
                                <div class="col-12 d-flex justify-content-between">
                                    <div class="col-2">Шоп</div>
                                    <div class="col-2">Клиент</div>
                                    <div class="col-2">Кол-во</div>
                                    <div class="col-2">Сумма</div>
                                    <div class="col-2">Прибыль мп</div>
                                    <div class="col-2"></div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="col-12 d-flex justify-content-center mt-5">
                        <div id="pagination-container">
                            <!-- здесь будут отображаться элементы -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/client/paginate.js"></script>
<script src="/js/admin/sales.js"></script>
<style>
    input[type=date]::-webkit-calendar-picker-indicator {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 24 24"><path fill="%23bbbbbb" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>');
    }
</style>

</body>
</html>