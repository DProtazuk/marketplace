<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/MyFunction.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/GlobalCategories.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Shop.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Product.php";

    $Global_categories = new GlobalCategories();
    $MyFunction = new MyFunction();
    $Shop = new Shop();
    $Product = new Product();
?>


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
    <title>Товары</title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<!--Скрытый input активного меню-->

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_products" data-mini="menu_sidebar_products_mini">


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

                <?php
                if(!$Shop->SelectMyShop($_COOKIE['unique_id'])) {
                echo '<div class="col-9 mx-auto rounded-4 bg-silver p-4">
                    <div class="col-12 d-flex justify-content-between"">
                    <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5 4.21875C22.5 4.21875 26.2184 4.21875 29.6163 5.65596C29.6163 5.65596 32.8973 7.04369 35.4268 9.5732C35.4268 9.5732 37.9563 12.1027 39.344 15.3837C39.344 15.3837 40.7812 18.7816 40.7812 22.5C40.7812 22.5 40.7812 26.2184 39.344 29.6163C39.344 29.6163 37.9563 32.8973 35.4268 35.4268C35.4268 35.4268 32.8973 37.9563 29.6163 39.344C29.6163 39.344 26.2184 40.7812 22.5 40.7812C22.5 40.7812 18.7816 40.7812 15.3837 39.344C15.3837 39.344 12.1027 37.9563 9.5732 35.4268C9.5732 35.4268 7.04369 32.8973 5.65596 29.6163C5.65596 29.6163 4.21875 26.2184 4.21875 22.5C4.21875 22.5 4.21875 18.7816 5.65596 15.3837C5.65596 15.3837 7.04369 12.1027 9.57321 9.5732C9.57321 9.5732 12.1027 7.04369 15.3837 5.65596C15.3837 5.65596 18.7816 4.21875 22.5 4.21875ZM22.5 7.03125C22.5 7.03125 19.352 7.03125 16.4793 8.24628C16.4793 8.24628 13.7036 9.42032 11.5619 11.5619C11.5619 11.5619 9.42032 13.7036 8.24628 16.4793C8.24628 16.4793 7.03125 19.352 7.03125 22.5C7.03125 22.5 7.03125 25.648 8.24628 28.5207C8.24628 28.5207 9.42032 31.2964 11.5619 33.4381C11.5619 33.4381 13.7036 35.5797 16.4793 36.7537C16.4793 36.7537 19.352 37.9688 22.5 37.9688C22.5 37.9688 25.648 37.9688 28.5207 36.7537C28.5207 36.7537 31.2964 35.5797 33.4381 33.4381C33.4381 33.4381 35.5797 31.2964 36.7537 28.5207C36.7537 28.5207 37.9688 25.648 37.9688 22.5C37.9688 22.5 37.9688 19.352 36.7537 16.4793C36.7537 16.4793 35.5797 13.7036 33.4381 11.5619C33.4381 11.5619 31.2964 9.42031 28.5207 8.24628C28.5207 8.24628 25.648 7.03125 22.5 7.03125Z" fill="white"/>
                        <path d="M22.5 32.3438H23.9062C24.6829 32.3438 25.3125 31.7141 25.3125 30.9375C25.3125 30.1609 24.6829 29.5312 23.9062 29.5312V21.0938C23.9062 20.3171 23.2766 19.6875 22.5 19.6875H21.0938C20.3171 19.6875 19.6875 20.3171 19.6875 21.0938C19.6875 21.8704 20.3171 22.5 21.0938 22.5V30.9375C21.0938 31.7141 21.7234 32.3438 22.5 32.3438Z" fill="white"/>
                        <path d="M24.2578 14.7656C24.2578 15.9306 23.3133 16.875 22.1484 16.875C20.9835 16.875 20.0391 15.9306 20.0391 14.7656C20.0391 13.6006 20.9835 12.6562 22.1484 12.6562C23.3133 12.6562 24.2578 13.6006 24.2578 14.7656Z" fill="white"/>
                    </svg>

                    <div class="col-11">
                        Прежде чем приступить к заполнению товаров, требуется создать шоп в вкладке Оформление
                    </div>

                </div>

                <div class="col-9 mx-auto">
                    <a class="bg_blue text-white border-0 text-16 text-center rounded-3 text-decoration-none d-block mx-auto col-3 py-1" href="/page/seller/decoration">Создать шоп</a>
                </div>
            </div>';
            return false;
            }
            ?>


                <input type="hidden" id="idShop" value="<?php echo $Shop->ReturnIdShop(); ?>">

                <div class="col-12 d-flex justify-content-between text-dark">

                    <div class="w-23 p-3 px-4 rounded-4" style="background-color: #E3F5FF;">
                        <h6 class="fw-bolder my-2">Кол-во товаров</h6>
                        <h3 class="my-3 fw-bolder countProducts">

                        </h3>
                    </div>

                    <div class="w-23 p-3 px-4 rounded-4" style="background-color: #F7F9FB;">
                        <h6 class="fw-bolder my-2">Товаров на сумму</h6>
                        <h3 class="my-3 fw-bolder sumProducts">

                        </h3>
                    </div>

                    <div class="w-23 p-3 px-4 rounded-4" style="background-color: #E3F5FF;">
                        <h6 class="fw-bolder my-2">Покупок сегодня</h6>
                        <h3 class="my-3 fw-bolder countOrders"></h3>
                    </div>

                    <div class="w-23 p-3 px-4 rounded-4" style="background-color: #F7F9FB;">
                        <h6 class="fw-bolder my-2">Сумма продаж</h6>
                        <h3 class="my-3 fw-bolder sumOrders"></h3>
                    </div>
                </div>

                <div class="col-12 bg-silver rounded-4 m-auto mt-4 p-4 shadow_status">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <span class="text-white fw-bolder text-14 cursor">Товары</span>
                        <span class="text-white opacity-25 fw-light fw-bolder">|</span>

                        <div class="input-price-seller col-4">
                            <input oninput="renderProducts()" placeholder="Введите название или id:"
                                   class="px-5 text-white border-0 col-12 input_search_product text-14" type="text"
                                   style="background: url('/res/img/search.svg') no-repeat left;background-position: 3% 100%; background-position-y: center; background-size: 5% 55%; outline:none;">
                        </div>

                        <span class="text-white opacity-25 fw-light fw-bolder">|</span>


                        <div class="col-3">

                            <div class=" selectGlCat input-price-seller w-75">
                                <input value="all" class="select__inputGlCat" type="hidden" name="global_category"
                                       id="global_category">
                                <div class=" select__headGlCat p-1 text-white px-2">Выбрать категорию</div>
                                <ul class=" select__listGlCat p-1 bg-opacity-50" style="display: none;">
                                    <?php
                                    foreach ($Global_categories->SelectGlobalCategories() as $arrayGlobCat) {
                                        echo '<li id="' . $arrayGlobCat['id'] . '" class=" select__itemGlCat p-1">' . $arrayGlobCat['name'] . '</li>';
                                    }
                                    //                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="col-2 d-flex justify-content-end">
                            <a class="text-decoration-none col-8 text-center bg-danger bg-transparent text-white rounded-2 bg_blue main_button" href="/page/seller/product/create_product">
                                Создать
                            </a>
                        </div>

                    </div>


                    <div class="col-12 mt-3 table_products">
                        <div class="col-12 d-flex border-bottom border-secondary text-secondary text-12 py-1">
                            <div class="col-1">ID товара</div>
                            <div class="col-3">Наименование</div>
                            <div class="col-2">Категория</div>
                            <div class="col-1">Кол-во</div>
                            <div class="col-1">Цена</div>
                            <div class="col-1">Сумма</div>
                            <div class="col-1">Покупок</div>
                            <div class="col-2"></div>
                        </div>

                        <div class="col-12 d-flex border-bottom border-secondary text-white text-14 py-3 table_products_select">
                            <div class="col-1 ">
                                <h6 class="text-14">ID товара</h6>
                            </div>

                            <div class="col-3">
                                <h6 class="div_2_line col-11 text-14">Facebook [ПЗРД] USA фарм 30д. Интересы+, coockie, UA, 2fa, +2BM USA фарм 30д. Интересы+, coockie, UA, 2fa, +2BM coockie, UA, 2fa, ПЗРД] USA фарм 30д. Интересы+, coockie, UA,</h6>
                            </div>

                            <div class="col-2">
                                <h6 class="text-14">кат</h6>
                            </div>

                            <div class="col-1 ">
                                <h6 class="text-14">Количество</h6>
                            </div>

                            <div class="col-1 ">
                                <h6 class="text-14">Цена</h6>
                            </div>

                            <div class="col-1 ">
                                <h6 class="text-14">Сумма</h6>
                            </div>

                            <div class="col-1 ">
                                <h6 class="text-14">Покупок</h6>
                            </div>

                            <div class="col-2 d-flex justify-content-around">
                                <div class="div_button border border-secondary rounded-2">
                                    <img width="11" src="/res/img/svg_down.svg" alt="">
                                </div>

                                <div class="div_button border border-secondary rounded-2">
                                    <img width="11" src="/res/img/btn_upload.svg" alt="">
                                </div>

                                <a href="/" class="div_button border border-secondary rounded-2">
                                    <img width="11" src="/res/img/btn_update.svg" alt="">
                                </a>

                                <div class="div_button border border-secondary rounded-2">
                                    <img width="11" src="/res/img/btn_copy.svg" alt="">
                                </div>

                                <div class="div_button border border-secondary rounded-2">
                                    <img width="11" src="/res/img/btn_del.svg" alt="">
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





    <!-- Modal -->
    <div class="modal fade" id="loading_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent text-white">
                <div class="modal-header modal_bg border-0 p-0 d-block">
                    <div class="col-12 d-flex justify-content-end px-4 pt-4">
                        <svg class="cursor" data-bs-dismiss="modal" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.2929 0.292893L0.292893 18.2929C0.105357 18.4804 0 18.7348 0 19C0 19.2652 0.105357 19.5196 0.292893 19.7071C0.48043 19.8946 0.734783 20 1 20C1.26522 20 1.51957 19.8946 1.70711 19.7071L19.7071 1.70711C19.8946 1.51957 20 1.26522 20 1C20 0.734784 19.8946 0.48043 19.7071 0.292894C19.5196 0.105357 19.2652 0 19 0C18.7348 0 18.4804 0.105357 18.2929 0.292893Z" fill="white"/>
                            <path d="M1.70711 0.292893C1.51957 0.105357 1.26522 0 1 0C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1C0 1.26522 0.105357 1.51957 0.292893 1.70711L18.2929 19.7071C18.4804 19.8946 18.7348 20 19 20C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19C20 18.7348 19.8946 18.4804 19.7071 18.2929L1.70711 0.292893Z" fill="white"/>
                        </svg>

                    </div>

                    <div class="col-10 m-auto">
                        <h1 class="fs-5 fw-bold">Догрузить товары</h1>
                    </div>
                </div>
                <div class="modal-body modal_bg p-0 border-0 rounded-bottom pt-3">
                    <div class="col-10 m-auto p-0">

                        <div class="col-12 bg-white py-2 my-3 bg-opacity-10 rounded-3 d-flex justify-content-around align-items-center ">
                            <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5 4.21875C22.5 4.21875 26.2184 4.21875 29.6163 5.65596C29.6163 5.65596 32.8973 7.04369 35.4268 9.5732C35.4268 9.5732 37.9563 12.1027 39.344 15.3837C39.344 15.3837 40.7812 18.7816 40.7812 22.5C40.7812 22.5 40.7812 26.2184 39.344 29.6163C39.344 29.6163 37.9563 32.8973 35.4268 35.4268C35.4268 35.4268 32.8973 37.9563 29.6163 39.344C29.6163 39.344 26.2184 40.7812 22.5 40.7812C22.5 40.7812 18.7816 40.7812 15.3837 39.344C15.3837 39.344 12.1027 37.9563 9.5732 35.4268C9.5732 35.4268 7.04369 32.8973 5.65596 29.6163C5.65596 29.6163 4.21875 26.2184 4.21875 22.5C4.21875 22.5 4.21875 18.7816 5.65596 15.3837C5.65596 15.3837 7.04369 12.1027 9.57321 9.5732C9.57321 9.5732 12.1027 7.04369 15.3837 5.65596C15.3837 5.65596 18.7816 4.21875 22.5 4.21875ZM22.5 7.03125C22.5 7.03125 19.352 7.03125 16.4793 8.24628C16.4793 8.24628 13.7036 9.42032 11.5619 11.5619C11.5619 11.5619 9.42032 13.7036 8.24628 16.4793C8.24628 16.4793 7.03125 19.352 7.03125 22.5C7.03125 22.5 7.03125 25.648 8.24628 28.5207C8.24628 28.5207 9.42032 31.2964 11.5619 33.4381C11.5619 33.4381 13.7036 35.5797 16.4793 36.7537C16.4793 36.7537 19.352 37.9688 22.5 37.9688C22.5 37.9688 25.648 37.9688 28.5207 36.7537C28.5207 36.7537 31.2964 35.5797 33.4381 33.4381C33.4381 33.4381 35.5797 31.2964 36.7537 28.5207C36.7537 28.5207 37.9688 25.648 37.9688 22.5C37.9688 22.5 37.9688 19.352 36.7537 16.4793C36.7537 16.4793 35.5797 13.7036 33.4381 11.5619C33.4381 11.5619 31.2964 9.42031 28.5207 8.24628C28.5207 8.24628 25.648 7.03125 22.5 7.03125Z" fill="white"/>
                                <path d="M22.5 32.3438H23.9062C24.6829 32.3438 25.3125 31.7141 25.3125 30.9375C25.3125 30.1609 24.6829 29.5312 23.9062 29.5312V21.0938C23.9062 20.3171 23.2766 19.6875 22.5 19.6875H21.0938C20.3171 19.6875 19.6875 20.3171 19.6875 21.0938C19.6875 21.8704 20.3171 22.5 21.0938 22.5V30.9375C21.0938 31.7141 21.7234 32.3438 22.5 32.3438Z" fill="white"/>
                                <path d="M24.2578 14.7656C24.2578 15.9306 23.3133 16.875 22.1484 16.875C20.9835 16.875 20.0391 15.9306 20.0391 14.7656C20.0391 13.6006 20.9835 12.6562 22.1484 12.6562C23.3133 12.6562 24.2578 13.6006 24.2578 14.7656Z" fill="white"/>
                            </svg>

                            <h6 class="text-14 col-9 my-auto">Функция "Догрузить" предназначена для быстрой загрузки (закачивания) строк в содержимое товара. Вы можете пополнить строки товара не заходя в его настройки.</h6>

                            <div class="col-1"></div>
                        </div>

                        <p class="text-14 my-fw opacity-75 product_id">ID 2534778</p>
                        <p class="text-14 opacity-75 product_name">Facebook [ПЗРД] USA фарм 30д. Интересы+, coockie, UA, 2fa,  +2BM</p>

                        <div class="d-flex justify-content-between col-5">
                            <div>
                                <p class="text-14 opacity-75 text-light fw-light product_quantity">В наличии 1689 шт.</p>
                                <p class="text-14 opacity-75 product_price">Цена  600р.</p>
                            </div>
                            <div>
                                <p class="text-14 opacity-75 text-light num_rating">Рейтинг 5.0.</p>

                                <div class="d-flex justify-content-center div_rating">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                </div>
                            </div>
                        </div>

                        <textarea class="col-12 input-price-seller text-white p-2 border-0" name="textarea" id="txt_loading" cols="30" rows="10"></textarea>

                        <div class="col-12 d-flex justify-content-center py-3">
                            <button data-bs-dismiss="modal" data-id="" onclick="loading_product.call(this)" type="button" class="bg_blue border-0 rounded-2 fw-bold small_shadow col-3 text-white button_loading_modal">ок</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="delete_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent text-white">
                <div class="modal-header modal_bg border-0 p-0 d-block">
                    <div class="col-12 d-flex justify-content-end px-4 pt-4">
                        <svg class="cursor" data-bs-dismiss="modal" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.2929 0.292893L0.292893 18.2929C0.105357 18.4804 0 18.7348 0 19C0 19.2652 0.105357 19.5196 0.292893 19.7071C0.48043 19.8946 0.734783 20 1 20C1.26522 20 1.51957 19.8946 1.70711 19.7071L19.7071 1.70711C19.8946 1.51957 20 1.26522 20 1C20 0.734784 19.8946 0.48043 19.7071 0.292894C19.5196 0.105357 19.2652 0 19 0C18.7348 0 18.4804 0.105357 18.2929 0.292893Z" fill="white"/>
                            <path d="M1.70711 0.292893C1.51957 0.105357 1.26522 0 1 0C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1C0 1.26522 0.105357 1.51957 0.292893 1.70711L18.2929 19.7071C18.4804 19.8946 18.7348 20 19 20C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19C20 18.7348 19.8946 18.4804 19.7071 18.2929L1.70711 0.292893Z" fill="white"/>
                        </svg>

                    </div>

                    <div class="col-10 m-auto">
                        <h1 class="fs-5 fw-bold">Удалить товар</h1>
                    </div>
                </div>
                <div class="modal-body modal_bg p-0 border-0 rounded-bottom pt-3">
                    <div class="col-10 m-auto p-0">

                        <div class="col-12 bg-white py-2 my-3 bg-opacity-10 rounded-3 d-flex justify-content-around align-items-center ">
                            <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5 4.21875C22.5 4.21875 26.2184 4.21875 29.6163 5.65596C29.6163 5.65596 32.8973 7.04369 35.4268 9.5732C35.4268 9.5732 37.9563 12.1027 39.344 15.3837C39.344 15.3837 40.7812 18.7816 40.7812 22.5C40.7812 22.5 40.7812 26.2184 39.344 29.6163C39.344 29.6163 37.9563 32.8973 35.4268 35.4268C35.4268 35.4268 32.8973 37.9563 29.6163 39.344C29.6163 39.344 26.2184 40.7812 22.5 40.7812C22.5 40.7812 18.7816 40.7812 15.3837 39.344C15.3837 39.344 12.1027 37.9563 9.5732 35.4268C9.5732 35.4268 7.04369 32.8973 5.65596 29.6163C5.65596 29.6163 4.21875 26.2184 4.21875 22.5C4.21875 22.5 4.21875 18.7816 5.65596 15.3837C5.65596 15.3837 7.04369 12.1027 9.57321 9.5732C9.57321 9.5732 12.1027 7.04369 15.3837 5.65596C15.3837 5.65596 18.7816 4.21875 22.5 4.21875ZM22.5 7.03125C22.5 7.03125 19.352 7.03125 16.4793 8.24628C16.4793 8.24628 13.7036 9.42032 11.5619 11.5619C11.5619 11.5619 9.42032 13.7036 8.24628 16.4793C8.24628 16.4793 7.03125 19.352 7.03125 22.5C7.03125 22.5 7.03125 25.648 8.24628 28.5207C8.24628 28.5207 9.42032 31.2964 11.5619 33.4381C11.5619 33.4381 13.7036 35.5797 16.4793 36.7537C16.4793 36.7537 19.352 37.9688 22.5 37.9688C22.5 37.9688 25.648 37.9688 28.5207 36.7537C28.5207 36.7537 31.2964 35.5797 33.4381 33.4381C33.4381 33.4381 35.5797 31.2964 36.7537 28.5207C36.7537 28.5207 37.9688 25.648 37.9688 22.5C37.9688 22.5 37.9688 19.352 36.7537 16.4793C36.7537 16.4793 35.5797 13.7036 33.4381 11.5619C33.4381 11.5619 31.2964 9.42031 28.5207 8.24628C28.5207 8.24628 25.648 7.03125 22.5 7.03125Z" fill="white"/>
                                <path d="M22.5 32.3438H23.9062C24.6829 32.3438 25.3125 31.7141 25.3125 30.9375C25.3125 30.1609 24.6829 29.5312 23.9062 29.5312V21.0938C23.9062 20.3171 23.2766 19.6875 22.5 19.6875H21.0938C20.3171 19.6875 19.6875 20.3171 19.6875 21.0938C19.6875 21.8704 20.3171 22.5 21.0938 22.5V30.9375C21.0938 31.7141 21.7234 32.3438 22.5 32.3438Z" fill="white"/>
                                <path d="M24.2578 14.7656C24.2578 15.9306 23.3133 16.875 22.1484 16.875C20.9835 16.875 20.0391 15.9306 20.0391 14.7656C20.0391 13.6006 20.9835 12.6562 22.1484 12.6562C23.3133 12.6562 24.2578 13.6006 24.2578 14.7656Z" fill="white"/>
                            </svg>

                            <h6 class="text-14 col-9 my-auto">Товар и все строки товара будут полностью удалены, восстановлению не подлежит.</h6>

                            <div class="col-1"></div>
                        </div>

                        <p class="text-14 my-fw opacity-75 product_id">ID 2534778</p>
                        <p class="text-14 opacity-75 product_name">Facebook [ПЗРД] USA фарм 30д. Интересы+, coockie, UA, 2fa,  +2BM</p>

                        <div class="d-flex justify-content-between col-5">
                            <div>
                                <p class="text-14 opacity-75 text-light fw-light product_quantity">В наличии 1689 шт.</p>
                                <p class="text-14 opacity-75 product_price">Цена  600р.</p>
                            </div>
                            <div>
                                <p class="text-14 opacity-75 text-light num_rating">Рейтинг 5.0.</p>

                                <div class="d-flex justify-content-center div_rating">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center py-3">
                            <button data-bs-dismiss="modal" data-id="" onclick="loading_product.call(this)" type="button" class="bg_blue border-0 rounded-2 small_shadow col-2 text-white button_loading_modal mx-3">ок</button>

                            <button data-bs-dismiss="modal" type="button" class="bg-secondary border-0 rounded-2 col-2 text-white mx-3">Отмена</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="copy_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent text-white">
                <div class="modal-header modal_bg border-0 p-0 d-block">
                    <div class="col-12 d-flex justify-content-end px-4 pt-4">
                        <svg class="cursor" data-bs-dismiss="modal" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.2929 0.292893L0.292893 18.2929C0.105357 18.4804 0 18.7348 0 19C0 19.2652 0.105357 19.5196 0.292893 19.7071C0.48043 19.8946 0.734783 20 1 20C1.26522 20 1.51957 19.8946 1.70711 19.7071L19.7071 1.70711C19.8946 1.51957 20 1.26522 20 1C20 0.734784 19.8946 0.48043 19.7071 0.292894C19.5196 0.105357 19.2652 0 19 0C18.7348 0 18.4804 0.105357 18.2929 0.292893Z" fill="white"/>
                            <path d="M1.70711 0.292893C1.51957 0.105357 1.26522 0 1 0C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1C0 1.26522 0.105357 1.51957 0.292893 1.70711L18.2929 19.7071C18.4804 19.8946 18.7348 20 19 20C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19C20 18.7348 19.8946 18.4804 19.7071 18.2929L1.70711 0.292893Z" fill="white"/>
                        </svg>

                    </div>

                    <div class="col-10 m-auto">
                        <h1 class="fs-5 fw-bold">Создать копию товара</h1>
                    </div>
                </div>
                <div class="modal-body modal_bg p-0 border-0 rounded-bottom pt-3">
                    <div class="col-10 m-auto p-0">


                        <p class="text-14 my-fw opacity-75 product_id">ID 2534778</p>
                        <p class="text-14 opacity-75 product_name">Facebook [ПЗРД] USA фарм 30д. Интересы+, coockie, UA, 2fa,  +2BM</p>

                        <div class="d-flex justify-content-between col-5">
                            <div>
                                <p class="text-14 opacity-75 text-light fw-light product_quantity">В наличии 1689 шт.</p>
                                <p class="text-14 opacity-75 product_price">Цена  600р.</p>
                            </div>
                            <div>
                                <p class="text-14 opacity-75 text-light num_rating">Рейтинг 5.0.</p>

                                <div class="d-flex justify-content-center div_rating">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center py-4">
                            <button data-bs-dismiss="modal" data-id="" onclick="loading_product.call(this)" type="button" class="bg_blue border-0 rounded-2 fw-bold small_shadow col-3 text-white button_loading_modal">ок</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="down_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent text-white">
                <div class="modal-header modal_bg border-0 p-0 d-block">
                    <div class="col-12 d-flex justify-content-end px-4 pt-4">
                        <svg class="cursor" data-bs-dismiss="modal" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.2929 0.292893L0.292893 18.2929C0.105357 18.4804 0 18.7348 0 19C0 19.2652 0.105357 19.5196 0.292893 19.7071C0.48043 19.8946 0.734783 20 1 20C1.26522 20 1.51957 19.8946 1.70711 19.7071L19.7071 1.70711C19.8946 1.51957 20 1.26522 20 1C20 0.734784 19.8946 0.48043 19.7071 0.292894C19.5196 0.105357 19.2652 0 19 0C18.7348 0 18.4804 0.105357 18.2929 0.292893Z" fill="white"/>
                            <path d="M1.70711 0.292893C1.51957 0.105357 1.26522 0 1 0C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1C0 1.26522 0.105357 1.51957 0.292893 1.70711L18.2929 19.7071C18.4804 19.8946 18.7348 20 19 20C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19C20 18.7348 19.8946 18.4804 19.7071 18.2929L1.70711 0.292893Z" fill="white"/>
                        </svg>

                    </div>

                    <div class="col-10 m-auto">
                        <h1 class="fs-5 fw-bold">Выгрузить товары</h1>
                    </div>
                </div>
                <div class="modal-body modal_bg p-0 border-0 rounded-bottom pt-3">
                    <div class="col-10 m-auto p-0">


                        <p class="text-14 my-fw opacity-75 product_id">ID 2534778</p>
                        <p class="text-14 opacity-75 product_name">Facebook [ПЗРД] USA фарм 30д. Интересы+, coockie, UA, 2fa,  +2BM</p>

                        <div class="d-flex justify-content-between col-5">
                            <div>
                                <p class="text-14 opacity-75 text-light fw-light product_quantity">В наличии 1689 шт.</p>
                                <p class="text-14 opacity-75 product_price">Цена  600р.</p>
                            </div>
                            <div>
                                <p class="text-14 opacity-75 text-light num_rating">Рейтинг 5.0.</p>

                                <div class="d-flex justify-content-center div_rating">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                    <img src="/res/img/star.png">
                                </div>
                            </div>
                        </div>

                        <input placeholder="Введите колличество:" class="col-8 input-price-seller text-white p-1 border-0" type="text">

                        <div class="col-12 d-flex justify-content-center py-3">
                            <button data-bs-dismiss="modal" data-id="" onclick="loading_product.call(this)" type="button" class="bg_blue border-0 rounded-2 fw-bold small_shadow col-3 text-white button_loading_modal">ок</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <style>
        .selectGlCat, .select_Cat, .select_standard2 {
            position: relative;
        }

        .select__headGlCat, .select__head_Cat, .select__head_standard2 {
            width: 100%;
            max-width: 100%;
            border-radius: 10px;
            font-size: 14px;
            line-height: 18px;
            color: rgba(66, 67, 72, 0.8);
            cursor: pointer;
        }

        .select__headGlCat::after, .select__head_Cat::after, .select__head_standard2::after {
            width: 8px;
            height: 8px;
            background: transparent url("/res/img/arrow.png") no-repeat center / cover;
            position: absolute;
            right: 20px;
            bottom: 50%;
            transform: translateY(50%);
            content: '';
            display: block;
            transition: .2s ease-in;
        }

        .select__headGlCat.open::after, .select__head_Cat.open::after, .select__head_standard2.open::after {
            transform: translateY(50%) rotate(180deg);
        }

        .select__listGlCat, .select__list_Cat, .select__list_standard2 {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            margin-top: 5px;
            overflow-x: hidden;
            overflow-y: auto;
            z-index: 100;
            margin: 0;
            padding: 0;
            font-size: 14px;
            color: #424348;
            scrollbar-width: thin;
            overscroll-behavior: contain;
        }

        .select__listGlCat::-webkit-scrollbar-thumb, .select__list_Cat::-webkit-scrollbar-thumb, .select__list_standard2::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background-color: #D9D9D9;
        }

        .select__listGlCat .select__itemGlCat, .select__list_Cat .select__item_Cat, .select__list_standard2 .select__item_standard2 {
            position: relative;
            border-top: 1px solid rgba(224, 229, 231, 0.5);
            cursor: pointer;
            list-style-type: none;
        }

        .select__listGlCat .select__itemGlCat:hover, .select__list_Cat .select__item_Cat:hover, .select__list_standard2 .select__item_standard2:hover {
            background-color: #282828;
            color: white;
            border-radius: 5px;
        }
    </style>

    <script src="/js/client/paginate.js"></script>
    <script src="/js/seller/products.js"></script>

</body>
</html>