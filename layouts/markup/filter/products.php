
<?php
$directory = pathinfo(basename($_SERVER['PHP_SELF']), PATHINFO_FILENAME);
if ($directory === "products") {
    if($status === "open") {
        echo '<div class="col-12 scroll_none filter_div_shop">';
    }
    else echo '<div ="col-12 scroll_none d-none">';?>

    <div class="col-12">
        <h6 class="text-white text-center text-14 my-4 cursor col-10 d-flex justify-content-center mx-auto">Типы аккаунтов</h6>

        <div class="col-12 filter-shops-div-category">
            <?php

            $array_Global_categories = $GL->SelectGlobalCategories();
            for ($i = 0;
                 $i < count($array_Global_categories);
                 $i++) {

                if($i === 0) {
                    echo '<div id="'.$array_Global_categories[$i]['id'].'" class="col-8 mx-auto d-flex cursor filter-shop-gl-category menu_filter menu_filter_active p-1 rounded-2 py-1 my-1">
                <img width="18" height="18" src="/res/img/img-category/' . $array_Global_categories[$i]['img'] . '">
                <h6 class="text-12 text-white my-auto mx-3">' . $array_Global_categories[$i]['name'] . '</h6>
            </div>';

                }
                else {
                    echo '<div id="' . $array_Global_categories[$i]['id'] . '" class="col-8 mx-auto d-flex cursor filter-shop-gl-category menu_filter p-1 rounded-2 py-1 my-1">
        <img width="18" height="18" src="/res/img/img-category/' . $array_Global_categories[$i]['img'] . '">
        <h6 class="text-12 text-white my-auto mx-3">' . $array_Global_categories[$i]['name'] . '</h6>
            </div>';
                }
            }
            ?>
        </div>

        <div class="col-12 filter-shops-div-subcategories">

        </div>

        <div class="col-12">
            <div class="col-12 d-flex justify-content-center align-items-center my-4 cursor show-filter-setting">
                <h6 class="text-white my-auto text-14 mx-1">Цена</h6>
                <img class="img-transform transform2" width="10" height="9" src="/res/img/arrow.png">
            </div>

            <div class="col-12 filter-content transition d-none">
                <div id="slider-range" class="col-10 d-flex justify-content-between mx-auto text-12">
                    <input class="col-5 text-center text-white sidebar_input_price border-0" type="number" id="minPrice" min="1" style="background: linear-gradient(269.89deg, #151515 0.08%, #202020 99.91%); box-shadow: 0px 0px 4px 0.5px rgba(255, 249, 249, 0.1), inset 0px 4px 2px rgba(0, 0, 0, 0.25);
border-radius: 5px;">
                    <input class="col-5 text-center text-white sidebar_input_price border-0" type="number" id="maxPrice" style="background: linear-gradient(269.89deg, #151515 0.08%, #202020 99.91%); box-shadow: 0px 0px 4px 0.5px rgba(255, 249, 249, 0.1), inset 0px 4px 2px rgba(0, 0, 0, 0.25);
border-radius: 5px;">
                </div>

                <div class="col-10 mx-auto my-3" id="filter-shop-input-price_products"></div>
            </div>

        </div>



        <div class="col-12 filter-shops-div-select-parameters">

        </div>

        <div class="col-12">
            <div class="col-12 d-flex justify-content-center align-items-center my-4 cursor show-filter-setting">
                <h6 class="text-white my-auto text-14 mx-1">Параметры</h6>
                <img class="img-transform transform2" width="10" height="9" src="/res/img/arrow.png">
            </div>

            <div class="col-12 filter-shops-div-parameters filter-content transition d-none"></div>
        </div>

        <div class="col-9 mx-auto d-flex mt-5">
            <a onclick="location.reload()">
                <svg class="cursor" width="27" height="28" viewBox="0 0 27 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.7014 6.32636L7.32636 18.7014C7.19743 18.8303 7.125 19.0052 7.125 19.1875C7.125 19.3698 7.19743 19.5447 7.32636 19.6736C7.4553 19.8026 7.63016 19.875 7.8125 19.875C7.99484 19.875 8.1697 19.8026 8.29864 19.6736L20.6736 7.29864C20.8026 7.1697 20.875 6.99484 20.875 6.8125C20.875 6.63016 20.8026 6.4553 20.6736 6.32636C20.5447 6.19743 20.3698 6.125 20.1875 6.125C20.0052 6.125 19.8303 6.19743 19.7014 6.32636Z" fill="white"/>
                    <path d="M8.29864 6.32636C8.1697 6.19743 7.99484 6.125 7.8125 6.125C7.63016 6.125 7.4553 6.19743 7.32636 6.32636C7.19743 6.4553 7.125 6.63016 7.125 6.8125C7.125 6.99484 7.19743 7.1697 7.32636 7.29864L19.7014 19.6736C19.8303 19.8026 20.0052 19.875 20.1875 19.875C20.3698 19.875 20.5447 19.8026 20.6736 19.6736C20.8026 19.5447 20.875 19.3698 20.875 19.1875C20.875 19.0052 20.8026 18.8303 20.6736 18.7014L8.29864 6.32636Z" fill="white"/>
                    <rect x="0.5" y="0.5" width="26" height="27" rx="4.5" stroke="white" stroke-opacity="0.2"/>
                </svg>
            </a>


            <button class="border-0 bg-white bg-opacity-10 text-white rounded-3 col-9 d-block mx-auto text-14 reset-filter" onclick="WriteProductEndPagination()">Применить</button>

        </div>
    </div>
    </div>
<?php }
?>