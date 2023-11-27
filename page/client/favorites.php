<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Role.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Orders.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Favorite.php";

$role = new Role();

if ($role->Check('unauthorized')) {
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
    <title>Избранные</title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<!--Скрытый input активного меню-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_main" data-mini="menu_sidebar_active_uniq_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_analytics" data-mini="menu_sidebar_analytics_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops" data-mini="menu_sidebar_shops_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_product"-->
<!--       data-mini="menu_sidebar_product_mini">-->


<!--Скрытый input Шапки меню-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-orders">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-balance">-->
<input type="hidden" class="active_menu" data-type="header" value="a-header-favorites">
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-return_product">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-referral_program">-->

<input type="hidden" id="page" value="1">


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

                <?php
                $favorite = new Favorite();
                if(!$favorite->Select()){
                    ?>

                    <div class="col-12 mx-auto rounded-4 bg-silver p-4">
                        <div class="col-9 mx-auto d-flex justify-content-between align-items-center"">
                        <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5 4.21875C22.5 4.21875 26.2184 4.21875 29.6163 5.65596C29.6163 5.65596 32.8973 7.04369 35.4268 9.5732C35.4268 9.5732 37.9563 12.1027 39.344 15.3837C39.344 15.3837 40.7812 18.7816 40.7812 22.5C40.7812 22.5 40.7812 26.2184 39.344 29.6163C39.344 29.6163 37.9563 32.8973 35.4268 35.4268C35.4268 35.4268 32.8973 37.9563 29.6163 39.344C29.6163 39.344 26.2184 40.7812 22.5 40.7812C22.5 40.7812 18.7816 40.7812 15.3837 39.344C15.3837 39.344 12.1027 37.9563 9.5732 35.4268C9.5732 35.4268 7.04369 32.8973 5.65596 29.6163C5.65596 29.6163 4.21875 26.2184 4.21875 22.5C4.21875 22.5 4.21875 18.7816 5.65596 15.3837C5.65596 15.3837 7.04369 12.1027 9.57321 9.5732C9.57321 9.5732 12.1027 7.04369 15.3837 5.65596C15.3837 5.65596 18.7816 4.21875 22.5 4.21875ZM22.5 7.03125C22.5 7.03125 19.352 7.03125 16.4793 8.24628C16.4793 8.24628 13.7036 9.42032 11.5619 11.5619C11.5619 11.5619 9.42032 13.7036 8.24628 16.4793C8.24628 16.4793 7.03125 19.352 7.03125 22.5C7.03125 22.5 7.03125 25.648 8.24628 28.5207C8.24628 28.5207 9.42032 31.2964 11.5619 33.4381C11.5619 33.4381 13.7036 35.5797 16.4793 36.7537C16.4793 36.7537 19.352 37.9688 22.5 37.9688C22.5 37.9688 25.648 37.9688 28.5207 36.7537C28.5207 36.7537 31.2964 35.5797 33.4381 33.4381C33.4381 33.4381 35.5797 31.2964 36.7537 28.5207C36.7537 28.5207 37.9688 25.648 37.9688 22.5C37.9688 22.5 37.9688 19.352 36.7537 16.4793C36.7537 16.4793 35.5797 13.7036 33.4381 11.5619C33.4381 11.5619 31.2964 9.42031 28.5207 8.24628C28.5207 8.24628 25.648 7.03125 22.5 7.03125Z" fill="white"/>
                            <path d="M22.5 32.3438H23.9062C24.6829 32.3438 25.3125 31.7141 25.3125 30.9375C25.3125 30.1609 24.6829 29.5312 23.9062 29.5312V21.0938C23.9062 20.3171 23.2766 19.6875 22.5 19.6875H21.0938C20.3171 19.6875 19.6875 20.3171 19.6875 21.0938C19.6875 21.8704 20.3171 22.5 21.0938 22.5V30.9375C21.0938 31.7141 21.7234 32.3438 22.5 32.3438Z" fill="white"/>
                            <path d="M24.2578 14.7656C24.2578 15.9306 23.3133 16.875 22.1484 16.875C20.9835 16.875 20.0391 15.9306 20.0391 14.7656C20.0391 13.6006 20.9835 12.6562 22.1484 12.6562C23.3133 12.6562 24.2578 13.6006 24.2578 14.7656Z" fill="white"/>
                        </svg>

                        <div class="col-11">
                            У Вас пока нет Избранных Товаров.
                        </div>
                    </div>

                    <div class="col-12 mx-auto my-4">
                        <a class="bg_blue text-white border-0 text-16 text-center rounded-3 text-decoration-none d-block mx-auto col-3 py-1" href="/page/public/product/products">Перейти к просмотру товаров</a>
                    </div>

                    <?php
                }
                else {
                ?>


                <div class="col-12 bg-silver rounded-4 m-auto my-4 p-4 shadow_status">
                    <div class="col-12 d-flex justify-content-between align-items-center">

                        <div class="input-price-seller col-6" style="min-height: 28px; !important;">

                            <input type="hidden" id="page" value="1">

                            <input oninput="WriteProductEndPagination()" class="px-5 text-white col-12 input_search_product text-14 rounded-2 shadow-none border_input" type="text"
                                   style="background: url('/res/img/search.svg') no-repeat left;background-position: 3% 100%; background-position-y: center; background-size: 5% 55%; outline:none; background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                        </div>

                        <div class="col-3 d-flex justify-content-end">
                            <div class="select select_Filter_favorite input-price-seller rounded-2 w-75 text-13 bg_silver border_input" style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px !important; max-height: 28px; !important;">
                                <input class="select__input select__input_Filter_favorite" type="hidden" value="default">
                                <div class="select__head select__head_Filter_favorite text-white px-2 text-13 text-opacity-75 d-flex align-items-center" style="min-height: 28px; !important;"><h6 class="text-14 my-auto" >Фильтровать по</h6>
                                </div>
                                <ul class="select__list select__list_Filter_favorite p-1 bg-opacity-50 rounded-2" style="display: none;">
                                    <li id="ascending_price" class="select__item select__item_Filter_favorite py-1 mt-1 d-flex align-items-center">по цене &uarr;	</li>
                                    <li id="decreasing_price" class="select__item select__item_Filter_favorite py-1 d-flex align-items-center">по цене &darr;	</li>
                                    <li id="ascending_rating" class="select__item select__item_Filter_favorite py-1 mt-1 d-flex align-items-center">по рейтингу &uarr;	</li>
                                    <li id="decreasing_rating" class="select__item select__item_Filter_favorite py-1 d-flex align-items-center">по рейтингу &darr;	</li>
                                    <li id="ascending_name" class="select__item select__item_Filter_favorite py-1 d-flex align-items-center">по названию &uarr;	</li>
                                    <li id="decreasing_name" class="select__item select__item_Filter_favorite py-1 d-flex align-items-center">по названию &darr;	</li>
                                    <li id="ascending_quantity" class="select__item select__item_Filter_favorite py-1 d-flex align-items-center">по кол-ву &uarr;	</li>
                                    <li id="decreasing_quantity" class="select__item select__item_Filter_favorite py-1 d-flex align-items-center">по кол-ву &darr;	</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-3 d-flex justify-content-end">
                            <div class="div_svg_table opacity-50 mx-2 cursor svg_table">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5.5V3C1 1.89543 1.89543 1 3 1H5.5C6.60457 1 7.5 1.89543 7.5 3V5.5C7.5 6.60457 6.60457 7.5 5.5 7.5H3C1.89543 7.5 1 6.60457 1 5.5Z" stroke="white" />
                                    <path d="M9 13.5V11C9 9.89543 9.89543 9 11 9H13.5C14.6046 9 15.5 9.89543 15.5 11V13.5C15.5 14.6046 14.6046 15.5 13.5 15.5H11C9.89543 15.5 9 14.6046 9 13.5Z" stroke="white"/>
                                    <path d="M1 13.5V11C1 9.89543 1.89543 9 3 9H5.5C6.60457 9 7.5 9.89543 7.5 11V13.5C7.5 14.6046 6.60457 15.5 5.5 15.5H3C1.89543 15.5 1 14.6046 1 13.5Z" stroke="white"/>
                                    <path d="M9 5.5V3C9 1.89543 9.89543 1 11 1H13.5C14.6046 1 15.5 1.89543 15.5 3V5.5C15.5 6.60457 14.6046 7.5 13.5 7.5H11C9.89543 7.5 9 6.60457 9 5.5Z" stroke="white"/>
                                </svg>
                            </div>


                            <div class="cursor svg_spisok">
                                <svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5.5V3C1 1.89543 1.89543 1 3 1H5.5C6.60457 1 7.5 1.89543 7.5 3V5.5C7.5 6.60457 6.60457 7.5 5.5 7.5H3C1.89543 7.5 1 6.60457 1 5.5Z" stroke="white"/>
                                    <path d="M9 13V11C9 10.4477 9.44772 10 10 10H21C21.5523 10 22 10.4477 22 11V13C22 13.5523 21.5523 14 21 14H10C9.44772 14 9 13.5523 9 13Z" stroke="white"/>
                                    <path d="M1 13.5V11C1 9.89543 1.89543 9 3 9H5.5C6.60457 9 7.5 9.89543 7.5 11V13.5C7.5 14.6046 6.60457 15.5 5.5 15.5H3C1.89543 15.5 1 14.6046 1 13.5Z" stroke="white"/>
                                    <path d="M9 5V3C9 2.44772 9.44772 2 10 2H21C21.5523 2 22 2.44772 22 3V5C22 5.55228 21.5523 6 21 6H10C9.44772 6 9 5.55228 9 5Z" stroke="white"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-0">

                    <div class="col-12">

                        <input type="hidden" class="display_type" value="table_spisok">

                        <div class="col-12 div_print_product">

                        </div>

                        <button style="border: 1px solid #1877F2 !important;" class="d-block mx-auto my-4 mt-5 text-dark text-14 rounded-3 bg-transparent border-0 text-white py-1 ShowMore" onclick="ShowMoreProduct()">Показать еще</button>

                        <div class="col-12 d-flex justify-content-center mt-4">
                            <div id="pagination-container">
                                <!-- здесь будут отображаться элементы -->
                            </div>
                        </div>

                    </div>



                    <?php
                    }
                    ?>

                </div>

                <div class="col-12 d-flex justify-content-between my-4 rounded-4 bg-silver" style="min-height: 250px;">

                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/client/paginate.js"></script>
<script src="/js/client/favorite.js"></script>



<style>

    input[type=date]::-webkit-calendar-picker-indicator {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 24 24"><path fill="%23bbbbbb" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>');
    }
</style>

</body>
</html>