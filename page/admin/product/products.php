<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/GlobalCategories.php");

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Shop.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/print.php");

$SelectStartIdGlobal_categories = new GlobalCategories();
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
    <title>Товары</title>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<input type="hidden" id="page" value="1">

<?php echo '<input type="hidden" id="global_categories" value=' . $SelectStartIdGlobal_categories->SelectStartIdGlobal_categories() . '>'; ?>
<input type="hidden" id="subcategories" class="clear_input">

<input type="hidden" id="MaxPrice" value="">
<input type="hidden" id="MinPrice" value="">

<input type="hidden" id="array-parameters" class="clear_input">

<input type="hidden" id="array-parameters-uniq" class="clear_input">

<div class="div-array-select">

</div>

<!--Скрытый input активного меню-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_main" data-mini="menu_sidebar_active_uniq_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_analytics" data-mini="menu_sidebar_analytics_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops" data-mini="menu_sidebar_shops_mini">-->

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_products"
       data-mini="menu_sidebar_products_mini">


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
                        <h6 class="text-14">Товары</h6>
                        <div class="input-price-seller col-7" style="min-height: 28px; !important;">
                            <input oninput="WriteProductEndPagination()"
                                   class="px-5 text-white col-12 input_search_product text-14 rounded-2 shadow-none border_input clear_input"
                                   type="text"
                                   style="background: url('/res/img/search.svg') no-repeat left;background-position: 3% 100%; background-position-y: center; background-size: 5% 55%; outline:none; background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
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
                            <div class="col-1">ID товара</div>
                            <div class="col-4">Наименование</div>
                            <div class="col-6">
                                <div class="col-12 d-flex justify-content-between">
                                    <div class="col-2">Магазин</div>
                                    <div class="col-3">Категория</div>
                                    <div class="col-2">Кол-во</div>
                                    <div class="col-2">Цена</div>
                                    <div class="col-2">Сумма</div>
                                    <div class="col-2">Покупок</div>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>

                        <div class="col-12 ">


                            <div class="col-12 div_print_product">
                                <div class="col-12 d-flex text-14 text-white py-4 border-secondary border-bottom">
                                    <div class="col-1">ID товара</div>
                                    <div class="col-4">
                                        <h6 class="text-14 col-11 div_2_line">Facebook [ПЗРД] USA фарм 30д. Интересы+, coockie, UA, 2fa, +2BM USA фарм 30д. Интересы+, coockie, UA, 2fa, +2BM coockie, UA, 2fa, ПЗРД] USA фарм 30д. Интересы+, coockie, UA,</h6>
                                    </div>
                                    <div class="col-6">
                                        <div class="col-12 d-flex justify-content-between">
                                            <div class="col-2">Магазин</div>
                                            <div class="col-3">Категория</div>
                                            <div class="col-1">Кол-во</div>
                                            <div class="col-2">Цена</div>
                                            <div class="col-2">Сумма</div>
                                            <div class="col-2">Покупок</div>
                                        </div>
                                    </div>

                                    <div class="col-1 d-flex justify-content-around">
                                        <div class="div_button border border-secondary rounded-2">
                                            <img width="11" src="/res/img/btn_update.svg" alt="">
                                        </div>

                                        <div class="div_button border border-secondary rounded-2">
                                            <img width="11" src="/res/img/btn_del.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
    <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="/js/client/paginate.js"></script>
    <script type="text/javascript" src="/js/admin/product/products.js"></script>


</body>
</html>