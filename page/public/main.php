<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");
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
    <title>Главная</title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<!--Скрытый input активного меню-->

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_main" data-mini="menu_sidebar_active_uniq_mini">
<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops" data-mini="menu_sidebar_shops_mini">-->
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

                <?php advertisement(); ?>


                <div class="col-11 mx-auto carousel-category my-5 opacity-0">

                    <?php
                    $GL = new GlobalCategories();
                    $GL = $GL->SelectGlobalCategories();

                    if (!empty($GL)) {
                        foreach ($GL as $item) {
                            echo '<a href="" style="width: 75px !important;">
                        <img class="mx-auto" src="/res/img/img-category/' . $item['img'] . '">
                    </a>';
                        }
                    }
                    ?>
                </div>


                <div class="col-12 rounded-4 bg-silver p-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <h6 class="text-white text-16 my-auto">Топ товаров</h6>
                            <h6 class="text-white text-16 mx-3 my-auto cursor">за неделю</h6>
                            <h6 class="text-white opacity-25 my-auto">|</h6>
                            <h6 class="text-secondary text-16 mx-3 my-auto cursor" style="font-weight: 600 !important;">
                                за месяц</h6>
                        </div>

                        <!--                        <div class="dropdown">-->
                        <!--                                <span class="text-white d-block text-14 fw-bolder cursor" id="dropdownMenuButton3"-->
                        <!--                                      data-bs-toggle="dropdown" aria-expanded="false">&bull;&bull;&bull;</span>-->
                        <!--                            <ul class="dropdown-menu dropdown-menu-dark border-light border-opacity-25"-->
                        <!--                                aria-labelledby="dropdownMenuButton3">-->
                        <!--                                <li><a class="dropdown-item active_point_menu" href="#">Категория</a></li>-->
                        <!--                                <li><a class="dropdown-item" href="#">Категория</a></li>-->
                        <!--                            </ul>-->
                        <!--                        </div>-->
                    </div>


                    <div class="col-12 mx-auto carousel-product my-5">
                        <!--                        <div class="col-12 d-flex flex-wrap justify-content-between">-->
                        <!--                            --><?php //print_product(8); ?>
                        <!--                        </div>-->
                        <!---->
                        <!--                        <div class="col-12 d-flex flex-wrap justify-content-between">-->
                        <!--                            --><?php //print_product(8); ?>
                        <!--                        </div>-->
                        <!---->
                        <!--                        <div class="col-12 d-flex flex-wrap justify-content-between">-->
                        <!--                            --><?php //print_product(8); ?>
                        <!--                        </div>-->
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-between my-5">
                    <div class="w-48 p-5 rounded-4 bg-silver" style="min-height: 200px;">

                    </div>

                    <div class="w-48 p-5 rounded-4 bg-silver" style="min-height: 200px;">

                    </div>
                </div>

                <div class="col-12 rounded-4 bg-silver p-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <h6 class="text-white text-16 my-auto">Успей купить со скидкой</h6>
                        </div>

                        <!--                        <div class="dropdown">-->
                        <!--                                <span class="text-white d-block text-14 fw-bolder cursor" id="dropdownMenuButton3"-->
                        <!--                                      data-bs-toggle="dropdown" aria-expanded="false">&bull;&bull;&bull;</span>-->
                        <!--                            <ul class="dropdown-menu dropdown-menu-dark border-light border-opacity-25"-->
                        <!--                                aria-labelledby="dropdownMenuButton3">-->
                        <!--                                <li><a class="dropdown-item active_point_menu" href="#">Категория</a></li>-->
                        <!--                                <li><a class="dropdown-item" href="#">Категория</a></li>-->
                        <!--                            </ul>-->
                        <!--                        </div>-->
                    </div>


                    <div class="col-12 mx-auto carousel-product my-5">
                        <div class="col-12 d-flex flex-wrap justify-content-between">
                            <!--                            --><?php //print_product($Product->discount_products()); ?>
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between">
                            <!--                            --><?php //print_product($Product->discount_products()); ?>
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between">
                            <!--                            --><?php //print_product($Product->discount_products()); ?>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-between my-5 rounded-4 bg-silver" style="min-height: 250px;">

                </div>

                <div class="col-12 rounded-4 bg-silver p-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <h6 class="text-white text-16 my-auto">Новинки</h6>
                        </div>

                        <!--                        <div class="dropdown">-->
                        <!--                                <span class="text-white d-block text-14 fw-bolder cursor" id="dropdownMenuButton3"-->
                        <!--                                      data-bs-toggle="dropdown" aria-expanded="false">&bull;&bull;&bull;</span>-->
                        <!--                            <ul class="dropdown-menu dropdown-menu-dark border-light border-opacity-25"-->
                        <!--                                aria-labelledby="dropdownMenuButton3">-->
                        <!--                                <li><a class="dropdown-item active_point_menu" href="#">Категория</a></li>-->
                        <!--                                <li><a class="dropdown-item" href="#">Категория</a></li>-->
                        <!--                            </ul>-->
                        <!--                        </div>-->
                    </div>


                    <div class="col-12 mx-auto carousel-product my-5">
                        <div class="col-12 d-flex flex-wrap justify-content-between">
                            <!--                            --><?php //print_product($Product->new_products()); ?>
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between">
                            <!--                            --><?php //print_product($Product->new_products()); ?>
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between">
                            <!--                            --><?php //print_product($Product->new_products()); ?>
                        </div>
                    </div>
                </div>


                <div class="col-12 rounded-4 bg-silver p-3 mt-5">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <h6 class="text-white text-16 my-auto">Топ шопов по рейтингу</h6>
                        </div>

                        <!--                        <div class="dropdown">-->
                        <!--                                <span class="text-white d-block fs-6 fw-bolder cursor" id="dropdownMenuButton3"-->
                        <!--                                      data-bs-toggle="dropdown" aria-expanded="false">&bull;&bull;&bull;</span>-->
                        <!--                            <ul class="dropdown-menu dropdown-menu-dark border-light border-opacity-25"-->
                        <!--                                aria-labelledby="dropdownMenuButton3">-->
                        <!--                                <li><a class="dropdown-item active_point_menu" href="#">Категория</a></li>-->
                        <!--                                <li><a class="dropdown-item" href="#">Категория</a></li>-->
                        <!--                            </ul>-->
                        <!--                        </div>-->
                    </div>

                    <hr class="bg-secondary my-2 opacity-0">

                    <div class="col-11 mx-auto carousel-shops my-5">
                        <div class="w-10 text-center mx-3">
                            <img class="col-12" src="/res/img/Ellipse%204.png">
                            <h6 class="my-2">Fbgoods</h6>
                            <h4 class="">5.0</h4>
                        </div>

                        <div class="w-10 text-center mx-3">
                            <img class="col-12" src="/res/img/Ellipse%204.png">
                            <h6 class="my-2">Fbgoods</h6>
                            <h4 class="">5.0</h4>
                        </div>

                        <div class="w-10 text-center mx-3">
                            <img class="col-12" src="/res/img/Ellipse%204.png">
                            <h6 class="my-2">Fbgoods</h6>
                            <h4 class="">5.0</h4>
                        </div>

                        <div class="w-10 text-center mx-3">
                            <img class="col-12" src="/res/img/Ellipse%204.png">
                            <h6 class="my-2">Fbgoods</h6>
                            <h4 class="">5.0</h4>
                        </div>

                        <div class="w-10 text-center mx-3">
                            <img class="col-12" src="/res/img/Ellipse%204.png">
                            <h6 class="my-2">Fbgoods</h6>
                            <h4 class="">5.0</h4>
                        </div>

                        <div class="w-10 text-center mx-3">
                            <img class="col-12" src="/res/img/Ellipse%204.png">
                            <h6 class="my-2">Fbgoods</h6>
                            <h4 class="">5.0</h4>
                        </div>

                        <div class="w-10 text-center mx-3">
                            <img class="col-12" src="/res/img/Ellipse%204.png">
                            <h6 class="my-2">Fbgoods</h6>
                            <h4 class="">5.0</h4>
                        </div>

                        <div class="w-10 text-center mx-3">
                            <img class="col-12" src="/res/img/Ellipse%204.png">
                            <h6 class="my-2">Fbgoods</h6>
                            <h4 class="">5.0</h4>
                        </div>

                        <div class="w-10 text-center mx-3">
                            <img class="col-12" src="/res/img/Ellipse%204.png">
                            <h6 class="my-2">Fbgoods</h6>
                            <h4 class="">5.0</h4>
                        </div>

                    </div>
                </div>

                <div class="col-12 d-flex justify-content-between my-5 rounded-4 bg-silver" style="min-height: 250px;">

                </div>

                <div class="col-12 d-flex justify-content-between my-5">
                    <div class="w-30 p-5 rounded-4 bg-silver" style="min-height: 153px;">

                    </div>

                    <div class="w-30 p-5 rounded-4 bg-silver" style="min-height: 153px;">

                    </div>

                    <div class="w-30 p-5 rounded-4 bg-silver" style="min-height: 153px;">

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>


<script>

    $(function () {
        $('.single-item').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
        });

        $(".single-item").removeClass("opacity-0");

        $('.carousel-category').slick({
            slidesToShow: 7,
            slidesToScroll: 5,
            autoplay: false,
            autoplaySpeed: 2000,
            arrows: true,
            dots: true
        });

        $(".carousel-category").removeClass("opacity-0");
    });

    $('.carousel-product').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        arrows: false,
        dots: true,
    });

    $('.carousel-shops').slick({
        slidesToShow: 7,
        slidesToScroll: 3,
        autoplay: false,
        autoplaySpeed: 2000,
        arrows: false,
        dots: true,
    });

    $(".div-product")
        .on("mouseover", function () {
            $(this).css("min-height", "329px");
            $(this).css("max-height", "329px");

            $(this).find(".div-product-description").css("margin-top", "97px");

            $(this).find(".div_none").css("height", "73px");
            $(this).find(".div-product-h6").css("max-height", "50px");
            $(this).find(".div-product-h6").css("overflow", "hidden");

            $(this).find(".div-product-img .div-product-img-img").css("transform", "scale(1.3)");
            $(this).find(".div-product-description").css("background", "#343434");
        })
        .on("mouseout", function () {
            $(this).css("min-height", "314px");
            $(this).css("max-height", "314px");

            $(this).find(".div_none").css("height", "88px");

            $(this).find(".div-product-description").css("margin-top", "82px");
            $(this).find(".div-product-h6").css("max-height", "35px");
            $(this).find(".div-product-h6").css("overflow", "hidden");

            $(this).find(".div-product-img img").css("transform", "scale(1)");
            $(this).find(".div-product-description").css("background", "transparent");
        });
</script>

</body>
</html>