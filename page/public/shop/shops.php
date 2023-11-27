<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/print.php");

$role = new Role();
$role = $role->Check('client');
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Шопы</title>
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/link/link.php"); ?>
</head>
<body>

<!--Скрытый input активного меню-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_main" data-mini="menu_sidebar_active_uniq_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_analytics" data-mini="menu_sidebar_analytics_mini">-->

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops" data-mini="menu_sidebar_shops_mini">

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_product" data-mini="menu_sidebar_product_mini">-->


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
                <div class="d-flex my-2">
                    <a class="text-14 text-white text-decoration-none opacity-75 white-hover" href="/page/client/shop/shops">Шопы</a>
                    <span class="mx-2">/</span>
                    <a class="text-14 text-white text-decoration-none opacity-75 white-hover text_filter_shops" href="#">Все категории</a>
                </div>

                <input type="hidden" id="filterCategory" value="all">
                <input type="hidden" id="page" value="1">
                <input type="hidden" id="totalPages" value="10">

                <?php advertisement(); ?>

                <div class="col-12 bg-silver rounded-4 m-auto my-4 p-4 shadow_status">
                    <div class="col-12 d-flex justify-content-between align-items-center">

                        <div class="input-price-seller col-6" style="min-height: 28px; !important;">
                            <input class="px-5 text-white col-12 input_search_shops text-14 rounded-2 shadow-none border_input" type="text"
                                   style="background: url('/res/img/search.svg') no-repeat left;background-position: 3% 100%; background-position-y: center; background-size: 5% 55%; outline:none; background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                        </div>

                        <div class="col-3 d-flex justify-content-end">
                            <div class="select select_Filter_shops input-price-seller rounded-2 w-75 text-13 bg_silver border_input" style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px !important; max-height: 28px; !important;">
                                <input class="select__input select__input_Filter_shops" type="hidden" value="default">
                                <div class="select__head select__head_Filter_shops text-white px-2 text-13 text-opacity-75 d-flex align-items-center" style="min-height: 28px; !important;"><h6 class="text-14 my-auto" >Фильтровать по</h6>
                                </div>
                                <ul class="select__list select__list_Filter_shops p-1 bg-opacity-50 rounded-2" style="display: none;">
                                    <li id="ascending_rating" class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">по рейтингу &uarr;	</li>
                                    <li id="decreasing_rating" class="select__item select__item_Filter_shops py-1 d-flex align-items-center">по рейтингу &darr;	</li>
                                    <li id="ascending_name" class="select__item select__item_Filter_shops py-1 d-flex align-items-center">по названию &uarr;	</li>
                                    <li id="decreasing_name" class="select__item select__item_Filter_shops py-1 d-flex align-items-center">по названию &darr;	</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3 opacity-0">

                    <div class="col-12 d-flex flex-wrap div-write-shops" style="gap: 2.5%">

                    </div>

                    <div class="col-12">

                        <button style="border: 1px solid #1877F2 !important;" class="d-block mx-auto my-4 mt-5 text-dark text-14 rounded-3 bg-transparent border-0 text-white py-1 ShowMore">Показать еще</button>

                        <div class="col-12 d-flex justify-content-center mt-4">
                            <div id="pagination-container">
                                <!-- здесь будут отображаться элементы -->
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-12 d-flex justify-content-between my-4 rounded-4 bg-silver" style="min-height: 250px;">

                </div>

                <div class="col-12 rounded-4 bg-silver p-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <h6 class="text-white text-16 my-auto">Похожие товары</h6>
                        </div>

                        <div class="dropdown">
                                <span class="text-white d-block text-14 fw-bolder cursor" id="dropdownMenuButton3"
                                      data-bs-toggle="dropdown" aria-expanded="false">&bull;&bull;&bull;</span>
                            <ul class="dropdown-menu dropdown-menu-dark border-light border-opacity-25"
                                aria-labelledby="dropdownMenuButton3">
                                <li><a class="dropdown-item active_point_menu" href="#">Категория</a></li>
                                <li><a class="dropdown-item" href="#">Категория</a></li>
                            </ul>
                        </div>
                    </div>


                    <div class="col-12 mx-auto carousel-product my-5">
                        <div class="col-12 d-flex flex-wrap justify-content-between">
<!--                            --><?php //print_product(4); ?>
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between">
<!--                            --><?php //print_product(4); ?>
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between">
<!--                            --><?php //print_product(4); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="/js/client/paginate.js"></script>
<script type="text/javascript" src="/js/client/shops.js"></script>


<script>

    $(function(){
        $('.single-item').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows : false,
        });

        $('.single-item').on('afterChange', function() {
        });

        $(".single-item").removeClass("opacity-0")

        $('.carousel-product').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            arrows : false,
            dots: true,
        });

        $( ".div-product" )
            .on("mouseover", function() {
                $(this).css("min-height", "329px");
                $(this).css("max-height", "329px");

                $(this).find(".div-product-description").css("margin-top", "97px");

                $(this).find(".div_none").css("height", "73px");
                $(this).find(".div-product-h6").css("max-height", "50px");
                $(this).find(".div-product-h6").css("overflow", "hidden");

                $(this).find(".div-product-img .div-product-img-img").css("transform", "scale(1.3)");
                $(this).find(".div-product-description").css("background", "#343434");
            } )
            .on("mouseout", function() {
                $(this).css("min-height", "314px");
                $(this).css("max-height", "314px");

                $(this).find(".div_none").css("height", "88px");

                $(this).find(".div-product-description").css("margin-top", "82px");
                $(this).find(".div-product-h6").css("max-height", "35px");
                $(this).find(".div-product-h6").css("overflow", "hidden");

                $(this).find(".div-product-img img").css("transform", "scale(1)");
                $(this).find(".div-product-description").css("background", "transparent");
            } );
    });
</script>

</body>
</html>