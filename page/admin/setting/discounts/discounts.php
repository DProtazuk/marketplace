<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
$role = new Role();

if (!$role->Check('admin')) {
    header("Location: /");
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Shop.php");
$Shop = new Shop();
$shop = $Shop->select();

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Скидки</title>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>


<!--Скрытый input активного меню-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_main" data-mini="menu_sidebar_active_uniq_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_analytics" data-mini="menu_sidebar_analytics_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops" data-mini="menu_sidebar_shops_mini">-->

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_setting"
       data-mini="menu_sidebar_sales_mini" data-submenu="h4-discounts">


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
                        <h6 class="text-14 my-auto">Скидки</h6>
                        <div class="input-price-seller col-4" style="min-height: 28px; !important;">
                            <input oninput="rendering()"
                                   class="px-5 text-white col-12 input_search_discounts text-14 rounded-2 shadow-none border_input clear_input"
                                   type="text"
                                   style="background: url('/res/img/search.svg') no-repeat left;background-position: 3% 100%; background-position-y: center; background-size: 5% 55%; outline:none; background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                        </div>

                        <div class="col-3 d-flex justify-content-end">
                            <div class="select select_Filter_shops input-price-seller rounded-2 w-75 text-13 bg_silver border_input"
                                 style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px !important; max-height: 28px; !important;">
                                <input class="select__input select__input_Filter_shops" type="hidden" value="all">
                                <div class="select__head select__head_Filter_shops text-white px-2 text-13 text-opacity-75 d-flex align-items-center"
                                     style="min-height: 28px; !important;"><h6 class="text-14 my-auto">Фильтровать
                                        по</h6>
                                </div>
                                <ul class="select__list select__list_Filter_shops p-1 bg-opacity-50 rounded-2"
                                    style="display: none;">
                                    <li id="ascending_percent"
                                        class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">
                                        по проценту &uarr;
                                    </li>
                                    <li id="decreasing_percent"
                                        class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">
                                        по проценту &darr;
                                    </li>

                                    <li id="all"
                                        class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">
                                        по покупкам &uarr;
                                    </li>
                                    <li id="all"
                                        class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">
                                        по покупкам &darr;
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-2">
                            <div style="min-height: 28px"
                                 class="bg-white d-flex justify-content-center align-items-center w-75 mx-auto text-center bg-opacity-10 rounded-3 cursor text-14"
                                 data-bs-toggle="modal" data-bs-target="#exampleModal">Добавить
                            </div>
                        </div>

                    </div>

                    <hr class="my-4 opacity-0">

                    <div class="col-12">

                        <div class="col-12 d-flex text-12 text-secondary border-secondary border-bottom py-2 align-items-center">
                            <div class="col-1">ID скидки</div>
                            <div class="col-2">Наименование</div>
                            <div class="col-2">Тип</div>
                            <div class="col-2">Магазин</div>
                            <div class="col-2">Период</div>
                            <div class="col-1">Процент</div>
                            <div class="col-1">Покупок</div>
                            <div class="col-1"></div>
                        </div>

                        <div class="col-12 table_write">


<!--                            <div class="col-12 d-flex text-14 text-white border-secondary border-bottom py-4">-->
<!--                                <div class="col-1 py-2">327657</div>-->
<!--                                <div class="col-2">NEWSALE2000</div>-->
<!--                                <div class="col-2">По времени</div>-->
<!--                                <div class="col-2">Название / все</div>-->
<!--                                <div class="col-2">26.11.2023 <br>-->
<!--                                    26.11.2023</div>-->
<!--                                <div class="col-1">12%</div>-->
<!--                                <div class="col-1">765</div>-->
<!---->
<!--                                <div class="col-1 d-flex justify-content-around">-->
<!--                                    <div class="div_button border border-secondary rounded-2">-->
<!--                                        <img width="11" src="/res/img/btn_update.svg" alt="">-->
<!--                                    </div>-->
<!---->
<!--                                    <div class="div_button border border-secondary rounded-2">-->
<!--                                        <img width="11" src="/res/img/btn_del.svg" alt="">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="/js/client/paginate.js"></script>
<script type="text/javascript" src="/js/admin/setting/discounts/discounts.js"></script>


</body>
</html>


<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent text-white">
            <div class="modal-header modal_bg border-0 p-0 d-block">
                <div class="col-12 d-flex justify-content-end px-4 pt-4">
                    <svg class="cursor" data-bs-dismiss="modal" width="20" height="20" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.2929 0.292893L0.292893 18.2929C0.105357 18.4804 0 18.7348 0 19C0 19.2652 0.105357 19.5196 0.292893 19.7071C0.48043 19.8946 0.734783 20 1 20C1.26522 20 1.51957 19.8946 1.70711 19.7071L19.7071 1.70711C19.8946 1.51957 20 1.26522 20 1C20 0.734784 19.8946 0.48043 19.7071 0.292894C19.5196 0.105357 19.2652 0 19 0C18.7348 0 18.4804 0.105357 18.2929 0.292893Z"
                              fill="white"/>
                        <path d="M1.70711 0.292893C1.51957 0.105357 1.26522 0 1 0C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1C0 1.26522 0.105357 1.51957 0.292893 1.70711L18.2929 19.7071C18.4804 19.8946 18.7348 20 19 20C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19C20 18.7348 19.8946 18.4804 19.7071 18.2929L1.70711 0.292893Z"
                              fill="white"/>
                    </svg>

                </div>

                <div class="col-10 m-auto d-flex justify-content-center">
                    <h1 class="fs-5 fw-bold my-4">Добавить скидку</h1>
                </div>
            </div>

            <div class="modal-body modal_bg p-0 border-0 rounded-bottom pt-3">
                <div class="col-10 mx-auto my-4">

                    <h6 class="text-danger text-error text-opacity-75"></h6>

                    <div class="col-12 d-flex justify-content-between my-3">
                        <h6 class="text-14 my-auto text-white-50">Наименование</h6>

                        <div class="input-price-seller col-8" style="min-height: 28px; !important;">
                            <input id="create_name" required
                                   class="px-5 fw-bolder bg-transparent text-center text-white col-12 text-14 rounded-2 shadow-none border_input"
                                   style=" outline:none; min-height: 28px; !important;">
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between my-3">
                        <h6 class="text-14 my-auto text-white-50">Магазин</h6>


                        <div class="col-8 d-flex justify-content-end">
                            <div class="select select_Filter_shops input-price-seller rounded-2 col-12 text-13 border_input"
                                 style="!important; min-height: 28px !important; max-height: 28px; !important;">
                                <input id="shop" class="select__input select__input_Filter_shops" type="hidden" value="all">
                                <div class="select__head select__head_Filter_shops text-white px-2 text-13 text-opacity-75 d-flex align-items-center"
                                     style="min-height: 28px; !important;"><h6 class="text-14 my-auto">Для всех</h6>
                                </div>
                                <ul class="select__list select__list_Filter_shops p-1 bg-opacity-50 rounded-2"
                                    style="display: none;">
                                    <li id="all"
                                        class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">
                                        Для всех
                                    </li>

                                    <?php
                                    foreach ($shop as $item) {
                                        echo '<li id="' . $item['id'] . '"
                                        class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">
                                        ' . $item['name'] . '
                                    </li>';
                                    }
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between my-3">
                        <h6 class="text-14 my-auto text-white-50">Процент</h6>

                        <div class="input-price-seller col-8 percentage-input-container"
                             style="min-height: 28px; !important;">
                            <input type="number" id="create_percent"
                                   class="px-5 bg-transparent fw-bolder text-center text-white col-12 text-14 rounded-2 shadow-none border_input"
                                   style=" outline:none; min-height: 28px; !important;">
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between my-3">
                        <h6 class="text-14 my-auto text-white-50">Тип</h6>

                        <div class="col-8 d-flex justify-content-end">
                            <div class="select select_Filter_type input-price-seller rounded-2 col-12 text-13 bg_silver border_input"
                                 style="min-height: 28px !important; max-height: 28px; !important;">
                                <input id="type" class="select__input select__input_Filter_type" type="hidden"
                                       value="quantity">
                                <div class="select__head select__head_Filter_type text-white px-2 text-13 text-opacity-75 d-flex align-items-center"
                                     style="min-height: 28px; !important;"><h6 class="text-14 my-auto">По кол-ву</h6>
                                </div>
                                <ul class="select__list select__list_Filter_type p-1 bg-opacity-50 rounded-2"
                                    style="display: none;">
                                    <li id="quantity"
                                        class="select__item select__item_Filter_type py-1 mt-1 d-flex align-items-center">
                                        По кол-ву
                                    </li>

                                    <li id="time"
                                        class="select__item select__item_Filter_type py-1 mt-1 d-flex align-items-center">
                                        На период
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 div_time d-none">
                        <div class="col-12 d-flex justify-content-end">
                            <div class="col-8 d-flex justify-content-between my-1">
                                <h6 class="text-14 my-auto text-white-50">Начало Скидки</h6>

                                <input id="start_data"
                                       value="<?php echo date('Y-m-d'); ?>" type="date"
                                       class="text-14 text-white input-price-seller px-2 py-1 rounded-2 border_input input-data"
                                       style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                            </div>
                        </div>


                        <div class="col-12 d-flex justify-content-end">
                            <div class="col-8 d-flex justify-content-between my-1">
                                <h6 class="text-14 my-auto text-white-50">Конец Скидки</h6>

                                <input id="finish_data"
                                       value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" type="date"
                                       class="text-14 text-white input-price-seller px-2 py-1 rounded-2 border_input input-data"
                                       style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 my-1 d-flex justify-content-end div_quantity">
                        <div class="col-8 d-flex justify-content-between my-1">
                            <h6 class="text-14 my-auto text-white-50">Колличество:</h6>

                            <div class="input-price-seller col-6 percentage-input-container"
                                 style="min-height: 28px; !important;">
                                <input id="quantity_discount" type="number"
                                       class="px-5 bg-transparent fw-bolder text-center text-white col-12 text-14 rounded-2 shadow-none border_input"
                                       style=" outline:none; min-height: 28px; !important;">
                            </div>
                        </div>
                    </div>

                    <button onclick="createDiscounts()"
                            class="bg_blue col-12 cursor py-1 my-5 text-white rounded-3 border-0">Добавить
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="deleteDiscount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent text-white">
            <div class="modal-header modal_bg border-0 p-0 d-block">
                <div class="col-12 d-flex justify-content-end px-4 pt-4">
                    <svg class="cursor" data-bs-dismiss="modal" width="20" height="20" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.2929 0.292893L0.292893 18.2929C0.105357 18.4804 0 18.7348 0 19C0 19.2652 0.105357 19.5196 0.292893 19.7071C0.48043 19.8946 0.734783 20 1 20C1.26522 20 1.51957 19.8946 1.70711 19.7071L19.7071 1.70711C19.8946 1.51957 20 1.26522 20 1C20 0.734784 19.8946 0.48043 19.7071 0.292894C19.5196 0.105357 19.2652 0 19 0C18.7348 0 18.4804 0.105357 18.2929 0.292893Z"
                              fill="white"/>
                        <path d="M1.70711 0.292893C1.51957 0.105357 1.26522 0 1 0C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1C0 1.26522 0.105357 1.51957 0.292893 1.70711L18.2929 19.7071C18.4804 19.8946 18.7348 20 19 20C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19C20 18.7348 19.8946 18.4804 19.7071 18.2929L1.70711 0.292893Z"
                              fill="white"/>
                    </svg>

                </div>

                <div class="col-10 m-auto d-flex justify-content-center">
                    <h1 class="fs-5 fw-bold my-4">Изменить скидку</h1>
                </div>
            </div>

            <div class="modal-body modal_bg p-0 border-0 rounded-bottom pt-3">
                <div class="col-10 mx-auto my-4">

                    <input id="discount_id" type="hidden" value="">

                    <h6 class="text-danger text-error text-opacity-75"></h6>

                    <div class="col-12 d-flex justify-content-between my-3">
                        <h6 class="text-14 my-auto text-white-50">Наименование</h6>

                        <div class="input-price-seller col-8" style="min-height: 28px; !important;">
                            <input id="update_name" required
                                   class="px-5 fw-bolder bg-transparent text-center text-white col-12 text-14 rounded-2 shadow-none border_input"
                                   style=" outline:none; min-height: 28px; !important;">
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between my-3">
                        <h6 class="text-14 my-auto text-white-50">Магазин</h6>


                        <div class="col-8 d-flex justify-content-end">
                            <div class="select select_Filter_shops input-price-seller rounded-2 col-12 text-13 border_input"
                                 style="!important; min-height: 28px !important; max-height: 28px; !important;">
                                <input id="update_shop" class="select__input select__input_Filter_shops" type="hidden" value="all">
                                <div class="select__head select__head_Filter_shops text-white px-2 text-13 text-opacity-75 d-flex align-items-center"
                                     style="min-height: 28px; !important;"><h6 class="text-14 my-auto text_update_shop">Для всех</h6>
                                </div>
                                <ul class="select__list select__list_Filter_shops p-1 bg-opacity-50 rounded-2"
                                    style="display: none;">
                                    <li id="all"
                                        class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">
                                        Для всех
                                    </li>

                                    <?php
                                    foreach ($shop as $item) {
                                        echo '<li id="' . $item['id'] . '"
                                        class="select__item select__item_Filter_shops py-1 mt-1 d-flex align-items-center">
                                        ' . $item['name'] . '
                                    </li>';
                                    }
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between my-3">
                        <h6 class="text-14 my-auto text-white-50">Процент</h6>

                        <div class="input-price-seller col-8 percentage-input-container"
                             style="min-height: 28px; !important;">
                            <input type="number" id="update_percent"
                                   class="px-5 bg-transparent fw-bolder text-center text-white col-12 text-14 rounded-2 shadow-none border_input"
                                   style=" outline:none; min-height: 28px; !important;">
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between my-3">
                        <h6 class="text-14 my-auto text-white-50">Тип</h6>

                        <div class="col-8 d-flex justify-content-end">
                            <div class="select select_Filter_type_update input-price-seller rounded-2 col-12 text-13 bg_silver border_input"
                                 style="min-height: 28px !important; max-height: 28px; !important;">
                                <input id="type_update" class="select__input select__input_Filter_type_update" type="hidden"
                                       value="quantity">
                                <div class="select__head select__head_Filter_type_update text-white px-2 text-13 text-opacity-75 d-flex align-items-center"
                                     style="min-height: 28px; !important;"><h6 class="text-14 my-auto type_name_update">По кол-ву</h6>
                                </div>
                                <ul class="select__list select__list_Filter_type_update p-1 bg-opacity-50 rounded-2"
                                    style="display: none;">
                                    <li id="quantity"
                                        class="select__item select__item_Filter_type_update py-1 mt-1 d-flex align-items-center">
                                        По кол-ву
                                    </li>

                                    <li id="time"
                                        class="select__item select__item_Filter_type_update py-1 mt-1 d-flex align-items-center">
                                        По периоду
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 div_time d-none">
                        <div class="col-12 d-flex justify-content-end">
                            <div class="col-8 d-flex justify-content-between my-1">
                                <h6 class="text-14 my-auto text-white-50">Начало Скидки</h6>

                                <input id="start_data_update"
                                       value="<?php echo date('Y-m-d'); ?>" type="date"
                                       class="text-14 text-white input-price-seller px-2 py-1 rounded-2 border_input input-data"
                                       style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                            </div>
                        </div>


                        <div class="col-12 d-flex justify-content-end">
                            <div class="col-8 d-flex justify-content-between my-1">
                                <h6 class="text-14 my-auto text-white-50">Конец Скидки</h6>

                                <input id="finish_data_update"
                                       value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" type="date"
                                       class="text-14 text-white input-price-seller px-2 py-1 rounded-2 border_input input-data"
                                       style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 my-1 d-flex justify-content-end div_quantity">
                        <div class="col-8 d-flex justify-content-between my-1">
                            <h6 class="text-14 my-auto text-white-50">Колличество:</h6>

                            <div class="input-price-seller col-6 percentage-input-container"
                                 style="min-height: 28px; !important;">
                                <input id="quantity_discount_update" type="number"
                                       class="px-5 bg-transparent fw-bolder text-center text-white col-12 text-14 rounded-2 shadow-none border_input"
                                       style=" outline:none; min-height: 28px; !important;">
                            </div>
                        </div>
                    </div>

                    <button onclick="updateDiscounts()"
                            class="bg_blue col-12 cursor py-1 my-5 text-white rounded-3 border-0">Изменить
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>



<style>
    .select__list_Filter_shops {
        max-height: 200px;
        overflow-y: auto;
        scrollbar-width: thin; /* Добавляет полосу прокрутки только веб-кит браузерам */
    }

    .select__list_Filter_shops::-webkit-scrollbar {
        width: 0.2em; /* Ширина полосы прокрутки */
    }

    .select__list_Filter_shops::-webkit-scrollbar-thumb {
        background-color: white; /* Цвет полосы прокрутки */
    }

    input[type=date]::-webkit-calendar-picker-indicator {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 24 24"><path fill="%23bbbbbb" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>');
    }
</style>





