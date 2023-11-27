<?php

//require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Shop.php");
// Карусель рекламы
function advertisement() {
    echo '<div class="col-12 mx-auto single-item opacity-0 text-danger">
                        <div class="rounded-4 my_silver" style=" min-height: 365px;">
                            
                        </div>

                        <div class="rounded-4 my_silver" style=" min-height: 365px;">
                            
                        </div>

                        <div class="rounded-4 my_silver" style=" min-height: 365px;">
                           
                        </div>
                    </div>';
}


function print_product($array)
{
    $MyFunction = new MyFunction();

    for ($i = 0; $i < count($array); $i++) {
        $rating = $MyFunction->create_rating($array[$i]['rating']);

        echo '<div class="w-22 d-flex align-items-center  mb-5" style="min-height: 334px; max-height: 334px;">
 <a href="/page/client/product/product?id='.$array[$i]['id'].'" class="text-decoration-none my-auto text-white col-12 rounded-4 div-product position-relative" style="min-height: 314px; max-height: 314px; background-color:  !important;">
                                <div class="col-12 position-absolute div-product-img  rounded-4" style="overflow:hidden;
width: 100%; height: 172px;">
                                    <img  src="/res/img/img-category/'.$array[$i]['img'].'" class="position-absolute fixed_product_img_category" style="z-index: 777">
                                    <img style="height:172px; " class="col-12 rounded-4  div-product-img-img" src="/res/img/imgProducts/'.$array[$i]['cover'].'">
                                </div>

                                <div class="col-12 px-3 rounded-4 div-product-description" style="border: 1px solid rgba(255, 255, 255, 0.1); margin-top: 82px; height: 220px;">
                                <div class="col-12 div_none" style="height: 88px"></div>
                                    <h6 class="text-13 mt-2 py-1 div-product-h6 Regular" style="max-height: 35px; overflow: hidden;">'.$array[$i]['name'].'</h6>

                                    <div class="d-flex my-2">
                                        <h5 class="text-20 my-auto">'.$array[$i]['price'].'₽</h5>
                                        <h6 class="text-12 mx-2 my-auto">'.$array[$i]['quantity'].' шт.</h6>
                                    </div>

                                    <div class="d-flex">
                                        <div class="col-6 d-flex">
                                            <button class="btn text-white text-center lh-1 d-flex col-12 my-auto text-14 bg-transparent border_blue btn_buy justify-content-center"><span>Купить</span></button>
                                        </div>

                                        <div class="col-6 px-3">
                                            <div class="col-12 d-flex justify-content-between">
                                                <img class="col-4 my-auto" src="/res/img/elipse.png">
                                                <h6 class="text-10  my-auto mx-1">'.$array[$i]['shop'].'</h6>
                                            </div>

                                            <div class="col-12 d-flex justify-content-between">
                                                <div class="col-4 text-center text-10 my-auto">
                                                    5.0
                                                </div>

                                                <div class="d-flex col-12 mx-1 my-auto justify-content-center">
                                                    '.$rating.'
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
</div>';
    }
}

//function print_product($count)
//{
//    for ($i = 0; $i < $count; $i++) {
//        echo '<a href="/page/client/product.php" class="text-decoration-none text-white w-22 mb-5 rounded-4 div-product position-relative" style="border: 1px solid rgba(255, 255, 255, 0.1);">
//                            <div class="col-12 position-relative">
//                                <img  src="/res/img/img-category/facebook.png" class="position-absolute fixed_product_img_category">
//                                <img style="height:160px; object-fit: cover;" class="col-12 rounded-4" src="/res/img/imgProducts/123961162499.jpg">
//                            </div>
//
//                            <div class="col-12 p-3">
//                                <h6 class="text-13">Facebook [ПЗРД] USA фарм 30д. +fp Интересы+, coockie, UA, 2fa
//                                    +2BM</h6>
//
//                                <div class="d-flex ">
//                                    <h5 class="text-20 my-auto">$12</h5>
//                                    <h6 class="text-12 mt-3 mx-3">1526 шт.</h6>
//                                </div>
//
//                                <div class="d-flex mt-2">
//                                    <div class="col-6 d-flex">
//                                        <button class="btn text-white text-center lh-1 d-flex col-12 my-auto text-14 bg-transparent border_blue btn_buy justify-content-center"><span>Купить</span></button>
//                                    </div>
//
//                                    <div class="col-6 px-3">
//                                        <div class="col-12 d-flex justify-content-between">
//                                            <img class="col-4 my-auto" src="/res/img/elipse.png">
//                                            <h6 class="text-10  my-auto mx-1">FBGOODS</h6>
//                                        </div>
//
//                                        <div class="col-12 d-flex justify-content-between">
//                                            <div class="col-4 text-center text-10 my-auto">
//                                                5.0
//                                            </div>
//
//                                            <div class="d-flex col-8 mx-1 my-auto">
//                                                <img class="w-22 my-auto" src="/res/img/star.png">
//                                                <img class="w-22" src="/res/img/star.png">
//                                                <img class="w-22" src="/res/img/star.png">
//                                                <img class="w-22" src="/res/img/star.png">
//                                                <img class="w-22" src="/res/img/star.png">
//                                            </div>
//                                        </div>
//                                    </div>
//                                </div>
//                            </div>
//                        </a>';
//    }
//}


function print_shops($num)
{
    for ($i = 0; $i < $num; $i++) {
        echo '<a href="/page/client/shop/shop" class="text-white text-decoration-none shops_mini w-18 rounded-3 my-2 pb-2" style="border: 1px solid rgba(255, 255, 255, 0.1);">
                            <div class="col-12 px-4 py-2">
                                <img src="/res/img/Ellipse 4.png" class="col-12 rounded-circle">
                                <h6 class="text-center text-16 my-2">Название шопа</h6>

                                <div class="col-12 d-flex justify-content-center">
                                    <h6 class="text-16 mx-2 my-auto">5.0</h6>
                                    <div class="d-flex my-auto">
                                        <img width="10" height="10" src="/res/img/star.png">
                                        <img width="10" height="10" src="/res/img/star.png">
                                        <img width="10" height="10" src="/res/img/star.png">
                                        <img width="10" height="10" src="/res/img/star.png">
                                        <img width="10" height="10" src="/res/img/star.png">
                                    </div>
                                </div>
                            </div>

                            <h6 class="text-14 mx-3 my-2 Regular">Магазин трастовых аккаунтов</h6>
                        </a>';
    }
}


function write($count)
{
    for ($i = 0; $i < $count; $i++) {
        if ($i + 1 < $count) {
            echo '<a href="/page/client/product/product" class="text-decoration-none text-white col-12 d-flex justify-content-between  border border-0 border-bottom border-secondary my-4 py-3 border-opacity-50">
                            <div class="col-1">
                                <div class="col-12">
                                    <div class="col-12 position-relative my-auto">
                                        <img src="/res/img/img-category/facebook.png" class="position-absolute col-5 mx-auto fixed_product_img_category">
                                        <img style="height:70px; object-fit: cover;" class="col-12 rounded-4" src="/res/img/imgProducts/123961162499.jpg">
                                    </div>
                                </div>
                            </div>


                            <div class="col-11 d-flex flex-column Regular">
                                <div class="col-12 d-flex justify-content-between mx-auto">
                                                                <div class="px-3"></div>

                                    <h6 class="col-8 text-14">Facebook [ПЗРД] USA фарм 30д. Интересы+, coockie, UA, 2fa, +2BM, бла бла бла бла бла бла блаИнтересы+, coockie, UA, 2fa, +2BM, бла бла бла бла бла бла бла</h6>

                                    <span class="text-14 col-2 px-4">Кол-во <span> 1689</span> шт.</span>

                                    <div class="col-2 d-flex">
                                        <div class="col-8 mx-auto">
                                            <button class="col-12 rounded-3 bg_blue border-0 text-white fw-medium">
                                                Купить
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-between mx-auto">
                                <div class="px-3"></div>
                                    <h6 class="col-8 text-15 my-auto">Магазин <span class="text_blue Medium">FBGOODS</span> </h6>

                                    <span class="text-14 col-2 my-auto px-4">Цена&nbsp;<span>600</span>р.</span>

                                    <div class="col-2 d-flex">

                                        <span class="d-flex justify-content-center text-14 my-auto col-8 text-center mx-auto">Рейтинг &nbsp;<h6 class="my-auto">5.0</h6></span>
                                    </div>
                                </div>
                            </div>
                        </a>';
        } else {
            echo '<a href="/page/client/product/product" class="text-decoration-none text-white col-12 d-flex justify-content-between my-4 py-3">
                            <div class="col-1">
                                <div class="col-12">
                                    <div class="col-12 position-relative my-auto">
                                        <img src="/res/img/img-category/facebook.png" class="position-absolute col-5 mx-auto fixed_product_img_category">
                                        <img style="height:70px; object-fit: cover;" class="col-12 rounded-4" src="/res/img/imgProducts/123961162499.jpg">
                                    </div>
                                </div>
                            </div>


                            <div class="col-11 d-flex flex-column Regular">
                                <div class="col-12 d-flex justify-content-between mx-auto">
                                                                <div class="px-3"></div>

                                    <h6 class="col-8 text-14">Facebook [ПЗРД] USA фарм 30д. Интересы+, coockie, UA, 2fa, +2BM, бла бла бла бла бла бла блаИнтересы+, coockie, UA, 2fa, +2BM, бла бла бла бла бла бла бла</h6>

                                    <span class="text-14 col-2 px-4">Кол-во <span> 1689</span> шт.</span>

                                    <div class="col-2 d-flex">
                                        <div class="col-8 mx-auto">
                                            <button class="col-12 rounded-3 bg_blue border-0 text-white fw-medium">
                                                Купить
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-between mx-auto">
                                <div class="px-3"></div>
                                    <h6 class="col-8 text-15 my-auto">Магазин <span class="text_blue Medium">FBGOODS</span> </h6>

                                    <span class="text-14 col-2 my-auto px-4">Цена&nbsp;<span>600</span>р.</span>

                                    <div class="col-2 d-flex">

                                        <span class="d-flex justify-content-center text-14 my-auto col-8 text-center mx-auto">Рейтинг &nbsp;<h6 class="my-auto">5.0</h6></span>
                                    </div>
                                </div>
                            </div>
                        </a>';
        }
    }
}
