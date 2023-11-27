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
    <title>Оформление</title>
    <link rel="icon" href="/favicon.svg">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>

<!--Скрытый input активного меню-->

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_decoration" data-mini="menu_sidebar_decoration_mini">



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


                <form id="form_shop" action="/backend/script/seller/shop.php" method="post" enctype="multipart/form-data">

                    <?php

                    $shop = new Shop();
                    $array = $shop->SelectMyShop($_COOKIE['unique_id']);

                    if($array){
                        $name = $array['name'];
                        $heading = $array['heading'];
                        $cover = "/res/img/imgShop/".$array['cover'];
                        $logo = "/res/img/imgShop/".$array['logo'];
                        $description = $array['description'];
                        $lower_description = $array['lower_description'];
                        echo '<input type="hidden" name="action" value="update_shop">';
                    }
                    else {
                        $name = NULL;
                        $heading = NULL;
                        $cover = NULL;
                        $logo = NULL;
                        $description = NULL;
                        $lower_description = NULL;
                        echo '<input type="hidden" name="action" value="create_shop">';
                    }
                    ?>
                    <div class="col-12">
                        <div class="col-12 bg-silver rounded-4 m-auto d-flex justify-content-around shadow_status div_imgCover" style="<?php
                        if($cover === NULL) {
                            echo "background: linear-gradient(270deg, #7E5195 1.21%, #47A38E 100%);";
                        }
                        else echo "background: url(".$cover.");";
                        ?>  height: 250px; max-height: 300px; background-repeat:no-repeat; background-position: center center; background-size: 100% ">
                        </div>

                        <div class="col-12 d-flex justify-content-between m-auto mt-4">
                            <div class="col-3">
                                <div class="col-11 shadow_status bg-silver rounded-4 p-3 py-4 d-flex flex-column align-items-center">
                                    <div class="bg-transparent div_imgLogo col-8 p-3 bg-danger Content justify-content-center position-relative">
                                        <div class="img_div_imgLogo" style="<?php
                                        if($logo == NULL) {
                                            echo "background: url(/res/img/testImgLogo.svg) no-repeat center center;";
                                        }
                                        else echo "background: url(".$logo.");";
                                        ?>border-radius: 50%";></div>
                                    </div>

                                    <p class="text-14 text-light fw-light mt-2 fw-bolder lh-1">
                                        <?php
                                        if(isset($array['name'])){
                                            echo $array['name'];
                                        }
                                        else echo "Название шопа";
                                        ?></p>
                                    <p class="text-light fw-light text-14 lh-1">Рейтинг <span class="fs-6">5.0</span></p>
                                    <div class="d-flex justify-content-center">
                                        <img src="/res/img/star.png">
                                        <img src="/res/img/star.png">
                                        <img src="/res/img/star.png">
                                        <img src="/res/img/star.png">
                                        <img src="/res/img/star.png">
                                    </div>
                                </div>
                            </div>

                            <div class="col-9 shadow_status bg-silver rounded-4 p-4 py-5">
                                <div class="d-flex col-11 m-auto justify-content-between align-items-center">
                                    <div class="my-auto">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h6 class="text-white fw-bolder d-block my-auto">Название</h6>
                                            <a data-title="Название" class="d-flex align-items-center"><img  class="cursor mx-2" width="20" src="/res/img/info.svg"></a>
                                        </div>
                                    </div>
                                    <input value="<?php echo $name?>" id="name" name="name" type="text" class="col-9 text-white border-0 input-price-seller px-3">
                                </div>


                                <div class="d-flex col-11 m-auto justify-content-between align-items-center mt-3">

                                    <div class="my-auto">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h6 class="text-white fw-bolder d-block my-auto">Заголовок </h6>
                                            <a data-title="Заголовок" class="d-flex align-items-center"><img  class="cursor mx-2" width="20" src="/res/img/info.svg"></a>
                                        </div>
                                    </div>
                                    <input value="<?php echo $heading;?>" id="heading" name="heading" type="text" class="col-9 text-white border-0 input-price-seller px-3">
                                </div>


                                <div class="d-flex col-11 m-auto justify-content-between align-items-center mt-3">
                                    <div class="my-auto">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h6 class="text-white fw-bolder d-block my-auto">Обложка</h6>
                                            <a data-title="Обложка"  class="d-flex align-items-center"><img  class=" cursor mx-2" width="20" src="/res/img/info.svg"></a>
                                        </div>
                                    </div>
                                    <div class="d-flex col-9 div-imgCover input-price-seller text-white px-4 p-1 d-flex">
                                        <label >
                                            <label class="cursor" for="imgCover">Выбрать файл</label>
                                            <input id="imgCover" name="imgCover" type="file"/>
                                        </label>
                                        <span class="mx-4 text-secondary" id="fileInfo_imgCover">Расширения: png, jpg/jpeg</span>
                                    </div>
                                </div>


                                <div class="d-flex col-11 m-auto justify-content-between align-items-center mt-3">
                                    <div class="my-auto">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h6 class="text-white fw-bolder d-block my-auto">Логотип</h6>
                                            <a data-title="Логотип"  class="d-flex align-items-center"><img  class=" cursor mx-2" width="20" src="/res/img/info.svg"></a>
                                        </div>
                                    </div>

                                    <div class="d-flex col-9 div-imgLogo input-price-seller text-white px-4 p-1 d-flex">
                                        <label>
                                            <label class="cursor" for="imgLogo">Выбрать файл</label>
                                            <input value="<?php echo $array['logo'];?>" id="imgLogo" name="imgLogo" type="file"/>
                                        </label>
                                        <span class="mx-4 text-secondary" id="fileInfo_imgLogo">Расширения: png, jpg/jpeg</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 bg-silver rounded-4 m-auto mt-4 p-4 shadow_status">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div class="col-4 d-flex">
                                    <span data-div="summernote-description-shop" onclick="switch_description_shop.call(this)" class="d-block text-white fw-bolder text-14 cursor span-summernote-description">Описание товара</span>
                                    <span class="d-block mx-4 text-white opacity-25 fw-light fw-bolder">|</span>
                                    <span data-div="summernote-lower_description" onclick="switch_description_shop.call(this)" class="d-block text-secondary fw-bolder text-14 cursor span-summernote-description">Нижнее описание</span>
                                </div>

                                <div data-div="description-shop" class="col-2 d-flex justify-content-center">
                                    <?php
                                    if($array){
                                        echo '<button form="form_shop" type="button" data-h="1" onclick="update_date_shop.call(this)" class="btn p-1 text-14 px-4 bg_blue small_shadow rounded lh-1 fs-6 text-white">изменить</button>';
                                    }
                                    else echo '<button form="form_shop" type="button" data-h="1" onclick="save_date_shop.call(this)" class="btn p-1 text-14 px-4 btn-bg-seller bg_blue small_shadow rounded lh-1 fs-6 text-white">сохранить</button>';
                                    ?>

                                </div>
                            </div>

                            <hr class="border-bottom my-3">

                            <div class="col-12 bg-black bg-opacity-25 summernote-description rounded summernote-description-shop">
                                <div class="col-12 rounded shadow">
                                    <input type="hidden" name="txt_description_shop" id="txt_description_shop">
                                    <div id="summernote-description-shop">
                                        <?php echo $description;?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 bg-black bg-opacity-25 summernote-description rounded summernote-lower_description d-none">
                                <div class="col-12 rounded shadow">
                                    <input type="hidden" name="txt_lower_description_shop" id="txt_lower_description_shop">
                                    <div id="summernote-lower_description">
                                        <?php echo $lower_description;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <style>
        .img_div_imgLogo {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: cover !important;
            background-repeat: no-repeat !important;
            background-position: center center !important;
        }

        .Content:before {
            content: "";
            display: block;
            padding-top: 100%;
        }
        input {outline:none;}

        #imgCover, #imgLogo {
            display: none;
            opacity: 0;
            position: absolute;
            z-index: -1;
        }

        .input-price-seller {
            background: linear-gradient(269.89deg, #151515 0.08%, #202020 99.91%);
            box-shadow: 0px 0px 4px 0.5px rgba(255, 249, 249, 0.1), inset 0px 4px 2px rgba(0, 0, 0, 0.25);
            border-radius: 5px;
        }

        .border-colors {
            border-color: #C74C4D !important;
        }
    </style>

    <script src="/js/seller/decoration.js"></script>


</body>
</html>