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
    <title>Категории</title>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>



<!--Скрытый input активного меню-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_main" data-mini="menu_sidebar_active_uniq_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_analytics" data-mini="menu_sidebar_analytics_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops" data-mini="menu_sidebar_shops_mini">-->


<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_setting"
       data-mini="menu_sidebar_sales_mini" data-submenu="h4-categories">

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
                        <div class="col-6 d-flex justify-content-between align-items-center">
                            <h6 class="text-14 my-auto">Категории</h6>
                            <div class="input-price-seller col-9" style="min-height: 28px; !important;">
                                <input oninput="rendering()"
                                       class="px-5 text-white col-12 input_search_category text-14 rounded-2 shadow-none border_input clear_input"
                                       type="text"
                                       style="background: url('/res/img/search.svg') no-repeat left;background-position: 3% 100%; background-position-y: center; background-size: 5% 55%; outline:none; background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                            </div>
                        </div>


                        <div class="col-2">
                            <a href="/page/admin/setting/categories/create" style="min-height: 28px" class="bg-white text-decoration-none text-white d-flex justify-content-center align-items-center w-75 mx-auto text-center bg-opacity-10 rounded-3 cursor text-14">Добавить</a>
                        </div>

                    </div>

                    <hr class="my-4 opacity-0">

                    <div class="col-12">

                        <div class="col-12 d-flex text-12 text-secondary border-secondary border-bottom py-2 align-items-center">
                            <div class="col-1">Логотив</div>
                            <div class="col-1"></div>
                            <div class="col-2">Имя категории</div>
                            <div class="col-2"></div>
                        </div>

                        <div class="col-12 div_category">


                            <div class="col-12 d-flex text-14 text-white border-secondary border-bottom py-2 align-items-center">
                                <div class="col-1 py-3">
                                    <img src="/res/img/img-category/facebook.png" class="col-10">
                                </div>
                                <div class="col-1"></div>
                                <div class="col-2">Имя категории</div>


                                <div class="col-1 d-flex">
                                    <div class="div_button border border-secondary rounded-2">
                                        <img width="11" src="/res/img/btn_update.svg" alt="">
                                    </div>

                                    <div class="div_button border border-secondary rounded-2 mx-2">
                                        <img width="11" src="/res/img/btn_del.svg" alt="">
                                    </div>
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
<script src="/js/admin/category.js"></script>

</body>
</html>

