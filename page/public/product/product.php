<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/MyFunction.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Product.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Favorite.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Orders.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/print.php");

$role = new MyFunction();
$MyFunction = new MyFunction();
$Orders = new Orders();
$product = new Product();

$array = $product->selectWhiteProduct($_GET['id']);
$arrayProduct = $array['arrayProduct'];
$arrayparameter_table = $array['arrayparameter_table'];

//Проверка наличие товара
if (empty($_GET['id']) || !$arrayProduct) {
    header('Location: /page/public/product/products');
}

$role = new Role();
$role = $role->Check('client');


$cover = $arrayProduct['cover'];
$price = $arrayProduct['price'];
$shop_id = $arrayProduct['shop_id'];
$shopName = $arrayProduct['shop'];
$productName = $arrayProduct['name'];
$productId = $arrayProduct['id'];
$quantity = $arrayProduct['quantity'];
$description = $arrayProduct['description'];


if ($arrayProduct['type_rating'] === "rating") {
    $rating = $arrayProduct['product_rating'];
} else $rating = $arrayProduct['product_fake_rating'];


?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Товар №<?php echo $_GET['id']; ?></title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<!--Скрытый input активного меню-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_main" data-mini="menu_sidebar_active_uniq_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_analytics" data-mini="menu_sidebar_analytics_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops" data-mini="menu_sidebar_shops_mini">-->


<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_product"
       data-mini="menu_sidebar_product_mini">


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

                <div class="d-flex">
                    <a class="text-14 text-white text-decoration-none opacity-75" href="">Аккаунты</a>
                    <span class="mx-2">/</span>
                    <a class="text-14 text-white text-decoration-none opacity-75" href="">Facebok</a>
                    <span class="mx-2">/</span>
                    <a class="text-14 text-white text-decoration-none opacity-75" href="">Название Товара</a>
                </div>

                <div class="col-12 d-flex justify-content-between my-2">
                    <div class="col-5 rounded-4">
                        <div class="col-12 position-relative">
                            <img style="max-height: 335px !important; min-height: 335px !important; object-fit: cover;"
                                 class="col-12 rounded-4"
                                 src="/res/img/imgProducts/<?php echo $cover; ?>">
                        </div>
                    </div>

                    <div class="col-7 d-flex justify-content-end">
                        <div class="w-95 bg-silver rounded-4 p-4">
                            <div class="col-12 mx-auto text-white">
                                <div class="col-12 d-flex">
                                    <div class="d-flex">
                                        <h6 class="text-14 my-auto">Оценка <?php echo $rating; ?> </h6>

                                        <div class="d-flex my-auto mx-2">
                                            <?php
                                                echo $MyFunction->create_ratingShop($rating);
                                            ?>

                                        </div>
                                    </div>

                                    <div class="d-flex mx-4">
                                        <h6 class="text-14 my-auto">Продавец</h6>

                                        <a class="text-14 text-decoration-none fw-bolder text_blue mx-4 my-auto" href="/page/public/shop/shop?id=<?php echo $shop_id; ?>">
                                           <?php echo $shopName ?>
                                        </a>
                                    </div>
                                </div>

                                <h6 class="text-white mt-4 py-1 col-10 text-16" style="line-height: 20px !important; height: 140px;">
                                    <?php echo $productName ?> </h6>

                                <div class="d-flex">
                                    <h6 class="text-14 d-flex my-auto">Цена</h6><h6
                                            class="mx-2 my-auto text-20"><?php echo $price; ?> ₽</h6>
                                </div>

                                <div class="col-12 d-flex align-items-center">
                                    <div class="col-6">
                                        <div class="col-12 d-flex my-3 ">
                                            <?php
                                            if ($role === "unauthorized") {
                                                echo '<a href="/page/entry_system/authorization" class="btn rounded-3 text-white col-6 my-auto text-16 bg-transparent border-secondary border-0 bg_blue text-center">
                                                Купить
                                            </a>';
                                            } else {
                                                if ($arrayProduct['quantity']){
                                                    echo '<button data-bs-toggle="modal" data-bs-target="#purchaseModal" class="btn rounded-3 text-white col-6 my-auto text-16 bg-transparent border-secondary border-0 bg_blue text-center">
                                                Купить
                                            </button>';
                                                }
                                                else {
                                                    echo '<button disabled class="btn rounded-3 text-white col-6 my-auto text-16 bg-transparent border-secondary border-0 bg_blue text-center">
                                                Купить
                                            </button>';
                                                }

                                            }
                                            ?>

                                            <?php
                                            if ($role !== "unauthorized") {
                                                ?>
                                                <div class="mx-3 rounded-2 cursor" style="border: 1px solid #1877F2;">

                                                    <?php
                                                    $favorite = new Favorite();
                                                    if ($favorite->check($_GET['id'])) {
                                                        echo '<div data-id=' . $productId . ' class="delete-to-favorites">
                                                    <svg class="m-1" version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 26" width="32" height="26">
                                                        <defs>
                                                            <image  width="32" height="26" id="img1" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAUCAMAAAC+oj0CAAAAAXNSR0IB2cksfwAAANtQTFRFGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfygts5ngAAAEl0Uk5TACyowKtSKXevmjcCpf8TD7WTCPb+9fj9/JdA8/Sf4unv2+vQ6ufNkY82M7axLfchlvlw1fIa2tELzvDJDcX7+gd6gjLW3TCVhaA6YQUAAADLSURBVHicZZDZVsJAEEQLA8pWUaDNDBhF9lWURcGVHf3/LyIhxEByn2ru6dNnqgEgdmEY8YQTcHmVNFJpNyGT5YGkeX3jpVze0TkWhBThrUUqUisWgRLvvBlhQBpxZfsP0X64x0OZER4rsFVUqypq9ahuNNGKWrKNDnVYCrtAT8m5VdJ36jyFx63Bs9v+hcNzPzocJT+WyantweP1LWhucTo7apjv+sP/xKeJf76+3dvxZ87sAidkltrWw4KsEGK9Ibe7sHUW/f4FC/YX+BmUB15izgAAAABJRU5ErkJggg=="/>
                                                        </defs>
                                                        <style>
                                                        </style>
                                                        <use id="Layer" href="#img1" x="0" y="1"/>
                                                    </svg>
                                                </div> 
                                                <div data-id="' . $productId . '" class="add-to-favorites  d-none">
                                                    <svg class="m-1" width="32" height="26" viewBox="0 0 22 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M13.0109 0.965066C13.0109 0.965066 11.7849 1.61787 11 2.67185C11 2.67185 10.2151 1.61787 8.98914 0.965066C8.98914 0.965066 7.06619 -0.0588944 4.92992 0.36836C4.92992 0.36836 2.79364 0.795615 1.41245 2.4804C1.41245 2.4804 0.03125 4.16519 0.03125 6.34378C0.03125 6.34378 0.03125 11.022 5.37834 15.8344C5.37834 15.8344 7.00766 17.3008 8.95929 18.6149C8.95929 18.6149 9.93912 19.2747 10.603 19.6464C10.8497 19.7846 11.1503 19.7846 11.3971 19.6464C11.3971 19.6464 12.0637 19.2729 13.044 18.6127C13.044 18.6127 14.9957 17.2982 16.6246 15.8317C16.6246 15.8317 21.9688 11.0207 21.9688 6.34377C21.9688 6.34377 21.9688 4.16519 20.5876 2.4804C20.5876 2.4804 19.2064 0.795615 17.0701 0.36836C17.0701 0.36836 14.9338 -0.0588941 13.0109 0.965066ZM8.22537 2.39939C8.22537 2.39939 9.63553 3.15029 10.25 4.62502C10.3324 4.82285 10.4897 4.9801 10.6876 5.06255L10.6904 5.06371C10.8885 5.14531 11.1112 5.14542 11.3094 5.06383L11.3125 5.06252C11.5103 4.9801 11.6676 4.82285 11.75 4.62502C11.75 4.62502 12.3645 3.15029 13.7746 2.39939C13.7746 2.39939 15.1848 1.64848 16.7514 1.9618C16.7514 1.9618 18.318 2.27512 19.3309 3.51064C19.3309 3.51064 20.3438 4.74615 20.3438 6.34377C20.3438 6.34377 20.3438 10.2971 15.5374 14.624C15.5374 14.624 13.9933 16.0142 12.1363 17.2648C12.1363 17.2648 11.4911 17.6994 11 17.9966C11 17.9966 10.5107 17.7005 9.86689 17.267C9.86689 17.267 8.00991 16.0166 6.46541 14.6266C6.46541 14.6266 1.65625 10.2983 1.65625 6.34378C1.65625 6.34378 1.65625 4.74615 2.66913 3.51064C2.66913 3.51064 3.682 2.27512 5.24861 1.9618C5.24861 1.9618 6.81521 1.64848 8.22537 2.39939Z"
                                                              fill="#1877F2"/>
                                                    </svg>
                                                </div>';
                                                    } else {
                                                        echo '<div data-id=' . $productId . ' class="delete-to-favorites d-none">
                                                    <svg class="m-1" version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 26" width="32" height="26">
                                                        <defs>
                                                            <image  width="32" height="26" id="img1" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAUCAMAAAC+oj0CAAAAAXNSR0IB2cksfwAAANtQTFRFGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfyGHfygts5ngAAAEl0Uk5TACyowKtSKXevmjcCpf8TD7WTCPb+9fj9/JdA8/Sf4unv2+vQ6ufNkY82M7axLfchlvlw1fIa2tELzvDJDcX7+gd6gjLW3TCVhaA6YQUAAADLSURBVHicZZDZVsJAEEQLA8pWUaDNDBhF9lWURcGVHf3/LyIhxEByn2ru6dNnqgEgdmEY8YQTcHmVNFJpNyGT5YGkeX3jpVze0TkWhBThrUUqUisWgRLvvBlhQBpxZfsP0X64x0OZER4rsFVUqypq9ahuNNGKWrKNDnVYCrtAT8m5VdJ36jyFx63Bs9v+hcNzPzocJT+WyantweP1LWhucTo7apjv+sP/xKeJf76+3dvxZ87sAidkltrWw4KsEGK9Ibe7sHUW/f4FC/YX+BmUB15izgAAAABJRU5ErkJggg=="/>
                                                        </defs>
                                                        <style>
                                                        </style>
                                                        <use id="Layer" href="#img1" x="0" y="1"/>
                                                    </svg>
                                                </div> 
                                                <div data-id="' . $productId . '" class="add-to-favorites">
                                                    <svg class="m-1" width="32" height="26" viewBox="0 0 22 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M13.0109 0.965066C13.0109 0.965066 11.7849 1.61787 11 2.67185C11 2.67185 10.2151 1.61787 8.98914 0.965066C8.98914 0.965066 7.06619 -0.0588944 4.92992 0.36836C4.92992 0.36836 2.79364 0.795615 1.41245 2.4804C1.41245 2.4804 0.03125 4.16519 0.03125 6.34378C0.03125 6.34378 0.03125 11.022 5.37834 15.8344C5.37834 15.8344 7.00766 17.3008 8.95929 18.6149C8.95929 18.6149 9.93912 19.2747 10.603 19.6464C10.8497 19.7846 11.1503 19.7846 11.3971 19.6464C11.3971 19.6464 12.0637 19.2729 13.044 18.6127C13.044 18.6127 14.9957 17.2982 16.6246 15.8317C16.6246 15.8317 21.9688 11.0207 21.9688 6.34377C21.9688 6.34377 21.9688 4.16519 20.5876 2.4804C20.5876 2.4804 19.2064 0.795615 17.0701 0.36836C17.0701 0.36836 14.9338 -0.0588941 13.0109 0.965066ZM8.22537 2.39939C8.22537 2.39939 9.63553 3.15029 10.25 4.62502C10.3324 4.82285 10.4897 4.9801 10.6876 5.06255L10.6904 5.06371C10.8885 5.14531 11.1112 5.14542 11.3094 5.06383L11.3125 5.06252C11.5103 4.9801 11.6676 4.82285 11.75 4.62502C11.75 4.62502 12.3645 3.15029 13.7746 2.39939C13.7746 2.39939 15.1848 1.64848 16.7514 1.9618C16.7514 1.9618 18.318 2.27512 19.3309 3.51064C19.3309 3.51064 20.3438 4.74615 20.3438 6.34377C20.3438 6.34377 20.3438 10.2971 15.5374 14.624C15.5374 14.624 13.9933 16.0142 12.1363 17.2648C12.1363 17.2648 11.4911 17.6994 11 17.9966C11 17.9966 10.5107 17.7005 9.86689 17.267C9.86689 17.267 8.00991 16.0166 6.46541 14.6266C6.46541 14.6266 1.65625 10.2983 1.65625 6.34378C1.65625 6.34378 1.65625 4.74615 2.66913 3.51064C2.66913 3.51064 3.682 2.27512 5.24861 1.9618C5.24861 1.9618 6.81521 1.64848 8.22537 2.39939Z"
                                                              fill="#1877F2"/>
                                                    </svg>
                                                </div>';
                                                    }

                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-5">
                                        <div class="col-12 d-flex">
                                            <h6 class="text-14 d-flex col-6">В наличии</h6><h6
                                                    class="mx-1"><?php echo $quantity; ?>
                                                шт.</h6>
                                        </div>

                                        <div class="col-12 d-flex">
                                            <h6 class="text-14 d-flex col-6">Продано</h6><h6
                                                    class="mx-1"><?php echo $Orders->ReturnOrderNum($_GET['id']); ?>
                                                шт.</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-12 rounded-4 bg-silver px-4 my-5 py-3 text-14 Regular">

                    <div class="col-12 d-flex flex-wrap my-4">

                        <?php
                            foreach ($arrayparameter_table as $item) {
                                echo '<h6 class="text-14 bg-white bg-opacity-10 px-3 py-2 rounded-4">'.$item['name'].'</h6> <h6 class="mx-2"></h6>';
                            }
                        ?>
                    </div>

                    <?php echo $description; ?>
                </div>

                <div class="col-12 d-flex justify-content-between my-5">
                    <div class="col-8 rounded-4 bg-silver p-3 px-4 ">
                        <div class="d-flex">
                            <h6 class="text-white text-16 mt-2">Отзывы</h6>
                        </div>

                        <?php
                        //                        echo '<pre>';
                        $sql = "SELECT `reviews`.`id`, `user`.`name`, `reviews`.`rating`, `reviews`.`dignities`, `reviews`.`disadvantages`, `reviews`.`comment` , `reviews`.`img` FROM `user`
                                INNER JOIN `reviews` ON `user`.`unique_id` = `reviews`.`unique_id`
                                WHERE `reviews`.`product_id` = ?";
                        $sql = DB::connect()->prepare($sql);
                        $sql->execute(array($_GET['id']));
                        $arrayReviews = $sql->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($arrayReviews as $arrayReviews2) { ?>
                            <div class="col-12 mt-5">
                                <div class="col-9 d-flex">
                                    <div class="d-flex col-6">
                                        <img src="/res/img/elipse.png" width="29" height="29">
                                        <h6 class="text-15 my-auto mx-3"><?php echo $arrayReviews2['name']; ?></h6>
                                    </div>

                                    <div class="col-5 d-flex align-items-center">
                                        <h6 class="my-auto text-15 mx-3">Оценка</h6>
                                        <h6 class="my-auto text-15">5.0</h6>

                                        <div class="d-flex col-3 mx-2 my-auto mx-1">
                                            <?php echo $MyFunction->create_ratingShop($arrayReviews2['rating']); ?>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if ($arrayReviews2['dignities']) {
                                    ?>
                                    <div class="col-9 my-2 mt-4">
                                        <h6 class="text-white-75 text-15 my-3">Достоинства:</h6>
                                        <p class="text-14 text-white-75 Regular">
                                            <?php echo $arrayReviews2['dignities']; ?>
                                        </p>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($arrayReviews2['disadvantages']) {
                                    ?>
                                    <div class="col-9 my-2 mt-4">
                                        <h6 class="text-white-75 text-15 my-3">Недостатки:</h6>
                                        <p class="text-14 text-white-75 Regular">
                                            <?php echo $arrayReviews2['disadvantages']; ?>
                                        </p>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($arrayReviews2['comment']) {
                                    ?>
                                    <div class="col-9 my-2 mt-4">
                                        <h6 class="text-white-75 text-15 my-3">Комментарий:</h6>
                                        <p class="text-14 text-white-75 Regular">
                                            <?php echo $arrayReviews2['comment']; ?>
                                        </p>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($arrayReviews2['img'] !== NULL) {
                                    $img = json_decode($arrayReviews2['img']);
                                    ?>
                                    <div class="col-12 my-2 mt-4 d-flex flex-wrap" style="gap: 2%;">
                                        <?php
                                        foreach ($img as $imgItem) {
                                            echo '<a class="col-3 m-3" target="_blank" href="/res/img/reviews/' . $imgItem . '">
                                                <img class="col-12" src="/res/img/reviews/' . $imgItem . '" ></a>';
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        <?php }
                        //                            print_r($arrayReviews);
                        ?>

                    </div>

                    <div class="col-4 d-flex justify-content-end">
                        <div class="col-10">
                            <div class="col-12 rounded-4 bg-silver px-5 py-4 mb-4">

                                <!--                                --><?php
                                //                                if ($role !== "unauthorized") {
                                //                                    echo '<button class="mx-auto text-dark fs-6 rounded-3 mb-4 border_blue bg-transparent text-white py-1 d-block">
                                //                                    &nbsp; Оставить отзыв &nbsp;
                                //                                </button>';
                                //                                }
                                //                                ?>

                                <div class="col-8 mx-auto d-flex align-items-center">
                                    <h6 class="my-auto text-14 mx-3">Оценка</h6>
                                    <h6 class="my-auto text-14"><?php
                                        if ($arrayProduct['product_fake_rating'] === "0") {
                                            echo $arrayProduct['product_rating'];
                                        } else echo $arrayProduct['product_fake_rating'];
                                        ?></h6>

                                    <div class="d-flex col-8 mx-1 my-auto mx-1">
                                        <img class="w-22 my-auto" src="/res/img/star.png">
                                    </div>
                                </div>

                                <div class="col-12 d-flex my-2 mt-3 justify-content-around">
                                    <div class="d-flex col-4 mx-1 my-auto">
                                    </div>

                                    <h6 class="my-auto mx-3 text-12">250 отзывов</h6>
                                </div>

                                <div class="col-12 d-flex my-2 justify-content-around">
                                    <div class="d-flex col-4 mx-1 my-auto">
                                        <img class="w-22 my-auto" src="/res/img/star.png">
                                        <img class="w-22" src="/res/img/star.png">
                                        <img class="w-22" src="/res/img/star.png">
                                        <img class="w-22" src="/res/img/star.png">
                                        <img class="w-22" src="/res/img/star.png">
                                    </div>

                                    <h6 class="my-auto mx-3 text-12">50 отзывов</h6>
                                </div>

                                <div class="col-12 d-flex my-2 justify-content-around">
                                    <div class="d-flex col-4 mx-1 my-auto">
                                        <img class="w-22 my-auto" src="/res/img/star.png">
                                        <img class="w-22" src="/res/img/star.png">
                                        <img class="w-22" src="/res/img/star.png">
                                        <img class="w-22" src="/res/img/star.png">
                                    </div>

                                    <h6 class="my-auto mx-3 text-12">250 отзывов</h6>
                                </div>

                                <div class="col-12 d-flex my-2 justify-content-around">
                                    <div class="d-flex col-4 mx-1 my-auto">
                                        <img class="w-22 my-auto" src="/res/img/star.png">
                                        <img class="w-22" src="/res/img/star.png">
                                        <img class="w-22" src="/res/img/star.png">
                                    </div>

                                    <h6 class="my-auto mx-3 text-12">50 отзывов</h6>
                                </div>
                            </div>

                            <div class="col-12 rounded-4 bg-silver px-5 py-2" style="min-height: 400px">

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
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between">
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
<script src="/js/client/jquery.rating.js"></script>
<script src="/js/client/product.js"></script>

<script>

    $(function () {

        $('.carousel-product').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
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
    });
</script>

</body>
</html>

<!-- Modal -->
<div class="modal fade" id="purchaseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="purchaseModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent text-white">
            <div class="modal-header modal_bg border-0 p-0">
                <div class="col-11 mx-auto p-0 my-4 mt-4 d-flex justify-content-between">
                    <h1 class="fs-5 fw-bold">Купить товар</h1>

                    <svg data-bs-dismiss="modal" class="cursor" width="20" height="20" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.2929 0.292893L0.292893 18.2929C0.105357 18.4804 0 18.7348 0 19C0 19.2652 0.105357 19.5196 0.292893 19.7071C0.48043 19.8946 0.734783 20 1 20C1.26522 20 1.51957 19.8946 1.70711 19.7071L19.7071 1.70711C19.8946 1.51957 20 1.26522 20 1C20 0.734784 19.8946 0.48043 19.7071 0.292894C19.5196 0.105357 19.2652 0 19 0C18.7348 0 18.4804 0.105357 18.2929 0.292893Z"
                              fill="white"/>
                        <path d="M1.70711 0.292893C1.51957 0.105357 1.26522 0 1 0C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1C0 1.26522 0.105357 1.51957 0.292893 1.70711L18.2929 19.7071C18.4804 19.8946 18.7348 20 19 20C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19C20 18.7348 19.8946 18.4804 19.7071 18.2929L1.70711 0.292893Z"
                              fill="white"/>
                    </svg>
                </div>
            </div>
            <div class="modal-body modal_bg p-0 border-0 rounded-bottom">
                <div class="col-11 m-auto p-0">
                    <p class="text-14 my-fw opacity-75 copy_product_id">ID <?php echo $arrayProduct['id'] ?></p>
                    <p class="text-14 opacity-75 copy_product_name"><?php echo $arrayProduct['name'] ?></p>

                    <div class="d-flex col-12">
                        <div class="col-4">
                            <input type="hidden" id="max-quantity" value="<?php echo $arrayProduct['quantity'] ?>">
                            <input type="hidden" id="price" value="<?php echo $arrayProduct['price'] ?>">
                            <input type="hidden" id="discount" value="<?php echo $arrayProduct['discount'] ?>">


                            <p class="text-14 opacity-75 text-light fw-light copy_product_quantity">В
                                наличии <?php echo $arrayProduct['quantity'] ?> шт.</p>
                            <p class="text-14 opacity-75 copy_product_price">Цена <?php echo $arrayProduct['price']; ?>
                                ₽</p>
                        </div>
                        <div>
                            <p class="text-14 opacity-75 text-light fw-light">Рейтинг
                                <?php

                                if($arrayProduct['type_rating'] === "rating") {
                                    echo $arrayProduct['product_rating'];
                                }
                                else echo $arrayProduct['product_fake_rating'];
                                ?>
                            </p>

                            <div class="d-flex justify-content-center">
                                <?php

                                if($arrayProduct['type_rating'] === "rating") {
                                    echo $MyFunction->create_ratingShop($arrayProduct['product_rating']);
                                }
                                else echo $MyFunction->create_ratingShop($arrayProduct['product_fake_rating']);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex col-12 m-auto align-items-center mt-4">
                        <div class="d-flex align-items-center col-4">
                            <h6 class="text-white text-14 fw-bolder d-block my-auto">Количество </h6>
                        </div>
                        <input type="number" id="quantity" oninput="ChekInputAmount()" max="10"
                               class="col-4 text-white border-0 input-price-seller px-3">
                    </div>

                    <div class="d-flex col-12 m-auto align-items-center my-3">
                        <div class="d-flex align-items-center col-4">
                            <h6 class="text-white text-14 fw-bolder d-block my-auto">Купон </h6>
                        </div>

                        <input id="name" name="name" class="col-4 text-white border-0 input-price-seller px-3">
                    </div>

                    <?php
                    if ($arrayProduct['discount'] !== 0) {
                        echo '<div class="d-flex col-12 m-auto align-items-center my-3">
                        <div class="d-flex align-items-center col-4">
                            <h6 class="text-white text-14 fw-bolder d-block my-auto">Скидка </h6>
                        </div>

                        <div class="d-flex align-items-center col-3">
                            <h6 class="text-white text-14 fw-bolder d-block my-auto">' . $arrayProduct['discount'] . '%</h6>
                        </div>
                    </div>';
                    }
                    ?>

                    <div class="d-flex col-12 m-auto align-items-center my-3">
                        <div class="d-flex align-items-center col-4">
                            <h6 class="text-white text-14 fw-bolder d-block my-auto">Сумма </h6>
                        </div>

                        <div class="d-flex align-items-center col-3">
                            <h6 class="text-white text-14 fw-bolder d-block my-auto span-amount">0 ₽</h6>
                        </div>
                    </div>

                    <h6 class="text-14 text-danger h6-error"></h6>

                    <div class="col-12 m-auto d-flex py-3">
                        <button onclick="Purchase()" id="save_order" data-id="" type="button"
                                class="btn bg_blue fw-bold small_shadow col-2 text-white button_loading_modal">Купить
                        </button>
                        <button type="button" class="btn btn-dg-danger fw-bold small_shadow col-2 mx-4 text-white "
                                data-bs-dismiss="modal">отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ModalGoodOrder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="purchaseModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent text-white">
            <div class="modal-header modal_bg border-0 p-0">
                <div class="col-11 mx-auto p-0 my-4 mt-4 d-flex justify-content-between">
                    <h1 class="fs-5 fw-bold">Благодарим за покупку!</h1>

                    <svg data-bs-dismiss="modal" class="cursor" width="20" height="20" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.2929 0.292893L0.292893 18.2929C0.105357 18.4804 0 18.7348 0 19C0 19.2652 0.105357 19.5196 0.292893 19.7071C0.48043 19.8946 0.734783 20 1 20C1.26522 20 1.51957 19.8946 1.70711 19.7071L19.7071 1.70711C19.8946 1.51957 20 1.26522 20 1C20 0.734784 19.8946 0.48043 19.7071 0.292894C19.5196 0.105357 19.2652 0 19 0C18.7348 0 18.4804 0.105357 18.2929 0.292893Z"
                              fill="white"/>
                        <path d="M1.70711 0.292893C1.51957 0.105357 1.26522 0 1 0C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1C0 1.26522 0.105357 1.51957 0.292893 1.70711L18.2929 19.7071C18.4804 19.8946 18.7348 20 19 20C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19C20 18.7348 19.8946 18.4804 19.7071 18.2929L1.70711 0.292893Z"
                              fill="white"/>
                    </svg>
                </div>
            </div>
            <div class="modal-body modal_bg p-0 border-0 rounded-bottom">
                <div class="col-11 m-auto p-0">
                    <p class="text-14 my-fw opacity-75 copy_product_id">Номер заказа <span id="id_order_good"
                                                                                           class="mx-3"></span></p>
                    <p class="text-14 opacity-75 copy_product_name"><?php echo $arrayProduct['name'] ?></p>

                    <div class="d-flex col-12">
                        <div class="col-4">
                            <input type="hidden" id="max-quantity" value="<?php echo $arrayProduct['quantity'] ?>">
                            <input type="hidden" id="price" value="<?php echo $arrayProduct['price'] ?>">
                            <input type="hidden" id="discount" value="<?php echo $arrayProduct['discount'] ?>">


                            <p class="text-14 opacity-75 text-light fw-light copy_product_quantity">Кол-во <span
                                        id="quantity_modal_good" class="mx-3">123 шт.</span></p>
                            <p class="text-14 opacity-75 copy_product_price">Сумма <span id="amount_modal_good"
                                                                                         class="mx-3"></span></p>
                        </div>
                        <div>
                            <p class="text-14 opacity-75 text-light fw-light">Рейтинг
                                <?php
                                if ($arrayProduct['product_fake_rating'] !== NULL) {
                                    echo $arrayProduct['product_fake_rating'];
                                } else  echo $arrayProduct['product_rating'];
                                ?>
                            </p>

                            <div class="d-flex justify-content-center">
                                <?php
                                if ($arrayProduct['product_fake_rating'] !== NULL) {
                                    echo $MyFunction->create_ratingShop($arrayProduct['product_fake_rating']);
                                } else  echo $MyFunction->create_ratingShop($arrayProduct['product_rating']);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mx-auto my-4">
                        <button id="ModalReviewButton"
                                class="col-6 border-0 d-block mx-auto my-3 bg-white bg-opacity-10 text-white text-center text-decoration-none py-1 rounded-3">
                            Оставить отзыв
                        </button>

                        <a class="col-6 d-block mx-auto my-3 bg-white bg-opacity-10 text-white text-center text-decoration-none py-1 rounded-3"
                           href="/page/client/orders.php">
                            Мои покупки
                        </a>

                        <a id="a_href_order" class="col-6 d-block mx-auto my-3 bg_blue text-white text-center text-decoration-none py-1 rounded-3"
                           href="">
                            Скачать товар
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ModalReview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="purchaseModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal_big">
        <div class="modal-content bg-transparent text-white">
            <div class="modal-header modal_bg border-0 p-0">
                <div class="col-11 mx-auto p-0 my-4 mt-4 d-flex justify-content-between">
                    <h1 class="fs-5 fw-bold col-11 mx-auto">Напишите отзыв о товаре</h1>

                    <svg data-bs-dismiss="modal" class="cursor" width="20" height="20" viewBox="0 0 20 20" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.2929 0.292893L0.292893 18.2929C0.105357 18.4804 0 18.7348 0 19C0 19.2652 0.105357 19.5196 0.292893 19.7071C0.48043 19.8946 0.734783 20 1 20C1.26522 20 1.51957 19.8946 1.70711 19.7071L19.7071 1.70711C19.8946 1.51957 20 1.26522 20 1C20 0.734784 19.8946 0.48043 19.7071 0.292894C19.5196 0.105357 19.2652 0 19 0C18.7348 0 18.4804 0.105357 18.2929 0.292893Z"
                              fill="white"/>
                        <path d="M1.70711 0.292893C1.51957 0.105357 1.26522 0 1 0C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1C0 1.26522 0.105357 1.51957 0.292893 1.70711L18.2929 19.7071C18.4804 19.8946 18.7348 20 19 20C19.2652 20 19.5196 19.8946 19.7071 19.7071C19.8946 19.5196 20 19.2652 20 19C20 18.7348 19.8946 18.4804 19.7071 18.2929L1.70711 0.292893Z"
                              fill="white"/>
                    </svg>
                </div>
            </div>
            <div class="modal-body modal_bg p-0 border-0 rounded-bottom">
                <div class="col-11 mx-auto p-0">
                    <p class="text-14 col-11 mx-auto opacity-75 copy_product_name"><?php echo $arrayProduct['name'] ?></p>

                    <div class="col-11 bg-white bg-opacity-10 rounded-3 p-3 px-4 mx-auto d-flex align-items-center">
                        <svg class="my-auto" width="45" height="45" viewBox="0 0 45 45" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M22.5 4.21875C22.5 4.21875 26.2184 4.21875 29.6163 5.65596C29.6163 5.65596 32.8973 7.04369 35.4268 9.5732C35.4268 9.5732 37.9563 12.1027 39.344 15.3837C39.344 15.3837 40.7812 18.7816 40.7812 22.5C40.7812 22.5 40.7812 26.2184 39.344 29.6163C39.344 29.6163 37.9563 32.8973 35.4268 35.4268C35.4268 35.4268 32.8973 37.9563 29.6163 39.344C29.6163 39.344 26.2184 40.7812 22.5 40.7812C22.5 40.7812 18.7816 40.7812 15.3837 39.344C15.3837 39.344 12.1027 37.9563 9.5732 35.4268C9.5732 35.4268 7.04369 32.8973 5.65596 29.6163C5.65596 29.6163 4.21875 26.2184 4.21875 22.5C4.21875 22.5 4.21875 18.7816 5.65596 15.3837C5.65596 15.3837 7.04369 12.1027 9.57321 9.5732C9.57321 9.5732 12.1027 7.04369 15.3837 5.65596C15.3837 5.65596 18.7816 4.21875 22.5 4.21875ZM22.5 7.03125C22.5 7.03125 19.352 7.03125 16.4793 8.24628C16.4793 8.24628 13.7036 9.42032 11.5619 11.5619C11.5619 11.5619 9.42032 13.7036 8.24628 16.4793C8.24628 16.4793 7.03125 19.352 7.03125 22.5C7.03125 22.5 7.03125 25.648 8.24628 28.5207C8.24628 28.5207 9.42032 31.2964 11.5619 33.4381C11.5619 33.4381 13.7036 35.5797 16.4793 36.7537C16.4793 36.7537 19.352 37.9688 22.5 37.9688C22.5 37.9688 25.648 37.9688 28.5207 36.7537C28.5207 36.7537 31.2964 35.5797 33.4381 33.4381C33.4381 33.4381 35.5797 31.2964 36.7537 28.5207C36.7537 28.5207 37.9688 25.648 37.9688 22.5C37.9688 22.5 37.9688 19.352 36.7537 16.4793C36.7537 16.4793 35.5797 13.7036 33.4381 11.5619C33.4381 11.5619 31.2964 9.42031 28.5207 8.24628C28.5207 8.24628 25.648 7.03125 22.5 7.03125Z"
                                  fill="white"/>
                            <path d="M22.5 32.3438H23.9062C24.6829 32.3438 25.3125 31.7141 25.3125 30.9375C25.3125 30.1609 24.6829 29.5312 23.9062 29.5312V21.0938C23.9062 20.3171 23.2766 19.6875 22.5 19.6875H21.0938C20.3171 19.6875 19.6875 20.3171 19.6875 21.0938C19.6875 21.8704 20.3171 22.5 21.0938 22.5V30.9375C21.0938 31.7141 21.7234 32.3438 22.5 32.3438Z"
                                  fill="white"/>
                            <path d="M24.2578 14.7656C24.2578 15.9306 23.3133 16.875 22.1484 16.875C20.9835 16.875 20.0391 15.9306 20.0391 14.7656C20.0391 13.6006 20.9835 12.6562 22.1484 12.6562C23.3133 12.6562 24.2578 13.6006 24.2578 14.7656Z"
                                  fill="white"/>
                        </svg>

                        <h6 class="col-10 mx-4 text-14 my-auto">Если качество покупки вас устроило, можете поставить
                            только оценку товара. Остальные поля - не обязательны.</h6>
                    </div>

                    <div class="col-6 mx-auto d-flex justify-content-around my-4 align-items-center">
                        <div id="ID" class="rate1 col-5"></div>

                        <span id="info_rating" class="col-6 text-14 my-auto"></span>
                    </div>

                    <div class="col-11 mx-auto my-3 mt-5">
                        <textarea placeholder="Достоинства" oninput="adjustTextareaHeight(event)"
                                  class="text-14 col-12 mx-auto border-1 border-opacity-10 rounded-3 bg-white bg-opacity-10 p-4 py-2 text-white"
                                  name="" id="dignities" cols="30" rows="1"></textarea>
                    </div>

                    <div class="col-11 mx-auto my-3">
                        <textarea placeholder="Недостатки" oninput="adjustTextareaHeight(event)"
                                  class="text-14 col-12 mx-auto border-1 border-opacity-10 rounded-3 bg-white bg-opacity-10 p-4 py-2 text-white"
                                  name="" id="disadvantages" cols="30" rows="1"></textarea>
                    </div>

                    <div class="col-11 mx-auto my-3">
                        <textarea placeholder="Комментарий к отзыву" oninput="adjustTextareaHeight(event)"
                                  class="text-14 col-12 mx-auto border-1 border-opacity-10 rounded-3 bg-white bg-opacity-10 p-4 py-2 text-white"
                                  name="" id="comment" cols="30" rows="1"></textarea>
                    </div>

                    <div class="col-11 mx-auto d-flex align-items-center my-5">

                        <input type="hidden" id="arrayImg">
                        <input type="hidden" id="order">

                        <input type="file" id="downImg" class="d-none" accept=".png, .jpeg, .jpg">
                        <svg class="cursor svgAddImg" width="100" height="100" viewBox="0 0 100 100" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect width="100" height="100" rx="16" fill="white" fill-opacity="0.1"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M66.5456 63.7331C66.5456 63.7331 65.31 64.9688 63.5625 64.9688H35.4375C35.4375 64.9688 33.69 64.9688 32.4544 63.7331C32.4544 63.7331 31.2188 62.4975 31.2188 60.75V41.0625C31.2188 41.0625 31.2188 39.315 32.4544 38.0794C32.4544 38.0794 33.69 36.8438 35.4375 36.8438H40.3099L42.7049 33.2512C42.9657 32.86 43.4048 32.625 43.875 32.625H55.125C55.5952 32.625 56.0343 32.86 56.2951 33.2512L58.6901 36.8438H63.5625C63.5625 36.8438 65.31 36.8438 66.5456 38.0794C66.5456 38.0794 67.7812 39.315 67.7812 41.0625V60.75C67.7812 60.75 67.7812 62.4975 66.5456 63.7331ZM64.5569 61.7444C64.5569 61.7444 64.9688 61.3325 64.9688 60.75V41.0625C64.9688 41.0625 64.9688 40.48 64.5569 40.0681C64.5569 40.0681 64.145 39.6562 63.5625 39.6562H57.9375C57.4673 39.6562 57.0282 39.4213 56.7674 39.03L54.3724 35.4375H44.6276L42.2326 39.03C41.9718 39.4213 41.5327 39.6562 41.0625 39.6562H35.4375C35.4375 39.6562 34.855 39.6562 34.4431 40.0681C34.4431 40.0681 34.0312 40.48 34.0312 41.0625V60.75C34.0312 60.75 34.0312 61.3325 34.4431 61.7444C34.4431 61.7444 34.855 62.1562 35.4375 62.1562H63.5625C63.5625 62.1562 64.145 62.1562 64.5569 61.7444Z"
                                  fill="white"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M49.5 42.4688C49.5 42.4688 52.7037 42.4688 54.969 44.7341C54.969 44.7341 57.2344 46.9994 57.2344 50.2031C57.2344 50.2031 57.2344 53.4068 54.969 55.6722C54.969 55.6722 52.7037 57.9375 49.5 57.9375C49.5 57.9375 46.2963 57.9375 44.031 55.6722C44.031 55.6722 41.7656 53.4068 41.7656 50.2031C41.7656 50.2031 41.7656 46.9994 44.031 44.7341C44.031 44.7341 46.2963 42.4688 49.5 42.4688ZM49.5 45.2812C49.5 45.2812 47.4613 45.2812 46.0197 46.7228C46.0197 46.7228 44.5781 48.1644 44.5781 50.2031C44.5781 50.2031 44.5781 52.2418 46.0197 53.6834C46.0197 53.6834 47.4613 55.125 49.5 55.125C49.5 55.125 51.5387 55.125 52.9803 53.6834C52.9803 53.6834 54.4219 52.2418 54.4219 50.2031C54.4219 50.2031 54.4219 48.1644 52.9803 46.7228C52.9803 46.7228 51.5387 45.2812 49.5 45.2812Z"
                                  fill="white"/>
                        </svg>

                        <div class="col-5 mx-4">
                            <h6 class="text-14">Нажмите на кнопку для загрузки фото
                                до 10 изображений в формате PNG, JPEG.</h6>

                            <h6 class="my-1 text-error-down-image text-danger d-none">Введен неверный формат!</h6>
                            <h6 class="my-1 text-error-down-image-count text-danger d-none">Выбранно 10
                                изображений!</h6>
                        </div>
                    </div>

                    <div class="col-11 mx-auto d-flex flex-wrap my-4 write-img" style="gap:3.5%">

                    </div>

                    <div class="col-11 d-flex my-5">
                        <button class="col-2 mx-auto rounded-3 bg_blue text-center border-0 text-white" onclick="
SendReviews()">Отправить
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .modal-lg, .modal-xl {
        --bs-modal-width: 550px;
    }

    .btn-dg-danger, .btn-dg-danger:hover {
        background-color: #C74C4D;
    }

    .modal_big {
        --bs-modal-width: 900px !important;
    }

    #ID img {
        width: 25px !important;
    }

    textarea {
        resize: none;
        scrollbar-width: none; /* Скрывает стандартные полосы прокрутки в Firefox */
        -ms-overflow-style: none; /* Скрывает стандартные полосы прокрутки в Internet Explorer и Edge */
    }

    textarea::-webkit-scrollbar {
        width: 0; /* Скрывает стандартные полосы прокрутки в Chrome и Safari */
    }

    textarea::placeholder {
        color: white;
        opacity: 1; /* Установка полной непрозрачности */
    }

</style>

<style>
    .image-block {
        position: relative;
        display: inline-block;
    }

    .image-block img {
        display: block;
        max-width: 100%;
        min-height: 50px;
    }

    .image-block .close-button {

        position: absolute;
        top: 5px;
        right: 4px;
        width: 18px;
        height: 18px;
        background-color: transparent;
        color: white;
        border: 2px solid white;
        border-radius: 50%;
        font-size: 14px;
        line-height: 30px;
        text-align: center;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<script>
    function adjustTextareaHeight(event) {
        var textarea = event.target;
        textarea.style.height = "auto";
        textarea.style.height = textarea.scrollHeight + "px";
    }
</script>
