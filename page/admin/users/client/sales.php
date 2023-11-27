<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
$role = new Role();

if (!$role->Check('admin')) {
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
    <title>Покупки</title>
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

                <div class="col-12 d-flex text-secondary fw-bolder mb-4">
                    <a href="/page/admin/users/client/main?id=<?php echo $_GET['id'] ?>" class="text-14 cursor text-secondary text-decoration-none white-hover mx-3">Общее</a>
                    <a href="/page/admin/users/client/sales.php?id=<?php echo $_GET['id'] ?>" class="text-14 cursor text-white text-decoration-none mx-3 white-hover">Покупки</a>
                    <a href="/page/admin/users/client/referral_program?id=<?php echo $_GET['id'] ?>" class="text-14 cursor text-secondary text-decoration-none mx-3 white-hover">Рефералы</a>
                </div>


                <div class="col-12 bg-silver rounded-4 m-auto my-4 p-4 shadow_status">

                    <div class="col-12 d-flex justify-content-between">
                        <div class="col-9 text-white d-flex align-items-center">

                            <div class="input-price-seller col-5" style="min-height: 28px; !important;">

                                <?php
                                $num = NULL;

                                if (isset($_GET['id'])) {
                                    $num = $_GET['id'];
                                }
                                ?>

                                <input value="" oninput="WriteOrders()"
                                       class="px-5 text-white col-12 input_search_orders text-14 rounded-2 shadow-none border_input"
                                       type="text"
                                       style="background: url('/res/img/search.svg') no-repeat left;background-position: 3% 100%; background-position-y: center; background-size: 5% 55%; outline:none; background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                            </div>

                            <span class="text-14 mx-5">Даты</span>

                            <input oninput="WriteOrders()" id="start_data"
                                   value="<?php echo date('Y-m-d', strtotime('-1 month')); ?>" type="date"
                                   class="text-14 text-white mx-3 input-price-seller px-2 py-1 rounded-2 border_input input-data"
                                   style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">

                            <input oninput="WriteOrders()" id="finish_data" value="<?php echo date('Y-m-d'); ?>"
                                   type="date"
                                   class="text-14 text-white mx-3 input-price-seller px-2 py-1 rounded-2 border_input input-data"
                                   style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                        </div>

                        <div class="dropdown">

                        </div>
                    </div>

                    <div class="col-12 my-3 table_orders">
                        <div class="border-bottom border-secondary py-1 col-12 d-flex text-secondary text-12 fw-bolder align-items-center table_orders_main">
                            <div class="col-1 lh-lg">Ордер</div>
                            <div class="col-1 lh-lg">Дата</div>
                            <div class="col-5">Наименование</div>
                            <div class="col-5">
                                <div class="col-12 d-flex justify-content-between">
                                    <div class="col-4">Категория</div>
                                    <div class="col-3">Кол-во</div>
                                    <div class="col-2">Сумма</div>
                                    <div class="col-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!---->
                    <!--                    <button onclick="ShopMore()" style="border: 1px solid #1877F2 !important;"-->
                    <!--                            class="d-block mx-auto my-4 mt-5 text-dark text-14 rounded-3 bg-transparent border-0 text-white py-1 ShowMore">-->
                    <!--                        Показать еще-->
                    <!--                    </button>-->

                    <div class="col-12 d-flex justify-content-center mt-4">
                        <div id="pagination-container">
                            <!-- здесь будут отображаться элементы -->
                        </div>
                    </div>



            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script src="/js/client/paginate.js"></script>
<script type="text/javascript" src="/js/admin/users/client/sales.js"></script>

<style>
    input[type=date]::-webkit-calendar-picker-indicator {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 24 24"><path fill="%23bbbbbb" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>');
    }
</style>

</body>
</html>