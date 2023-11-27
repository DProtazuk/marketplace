<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");

$role = new Role();

if (!$role->Check('admin')) {
    header("Location: /");
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/GlobalCategories.php");
$GlobalCategories= new GlobalCategories();
$array = $GlobalCategories->searchGlobalCategoriesId($_GET['id']);
if(empty($array)){
    header("Location: /page/admin/setting/categories/search");
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Изменения категории</title>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>


<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_setting"
       data-mini="menu_sidebar_sales_mini" data-submenu="h4-categories">


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

                    <div class="col-12 d-flex justify-content-end">
                        <div class="col-8">
                            <!--                            <h6 class="text-danger text-14 text-center text-error"></h6>-->
                        </div>

                        <div class="col-2">
                            <a href="/page/admin/setting/categories/search" style="min-height: 28px"
                               class="bg-white text-decoration-none text-white d-flex justify-content-center align-items-center w-75 mx-auto text-center bg-opacity-10 rounded-3 cursor text-14">Назад</a>
                        </div>

                        <div class="col-2">
                            <div onclick="update()" style="min-height: 28px"
                                 class="bg-white d-flex justify-content-center align-items-center w-75 mx-auto text-center bg-opacity-10 rounded-3 cursor text-14">
                                Изменить
                            </div>
                        </div>
                    </div>


                    <div class="col-11 mx-auto d-flex my-5">
                        <div class="col-2">
                            <input accept="image/*" onchange="renderImg.call()" class="d-none inputImg" type="file">

                            <div class="cursor" onclick='imgDown()' style="width: 100px;">

                                <img style="width: 100px;" class="div_check_img" src="">

                                <h6 class="text-14 my-1 text-danger text-center errorImg"></h6>
                            </div>


                        </div>


                        <div class="col-8 d-flex align-items-center">
                            <div class="col-12 border border-secondary px-4 py-2 rounded-4 border-opacity-50"
                                 style="background: rgba(255, 255, 255, 0.1);">
                                <span class="opacity-50 text-14">Имя категории</span>
                                <span class="text-14 text-danger text-error"></span>
                                <br>

                                <div class="col-10">
                                    <input required value=""
                                           class="text-white col-12 input_search_product text-16  rounded-2 border-0 bg-transparent input_name_gl_category"
                                           type="text"
                                           style=" outline:none;">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-11 mx-auto my-5">
                        <div class="col-12 d-flex my-2">
                            <div class="col-2 d-flex">
                                <h6 class="text-14 my-4">Подкатегории</h6>
                            </div>

                            <div class="col-8">
                                <div class="col-12 div_add_category">
                                    <h6 class="text-center text-14 mt-5 my-3">Действующие</h6>
                                </div>

                                <div class="col-12 div_add_new_category">
                                    <h6 class="text-center text-14 mt-5 my-3">Новые</h6>
                                </div>
                            </div>


                        </div>

                        <div class="col-12 d-flex justify-content-center">
                            <svg onclick="addCategory()" class="cursor svg_add_category" width="143" height="48"
                                 viewBox="0 0 143 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.5" y="0.5" width="142" height="47" rx="7.5" stroke="white"
                                      stroke-opacity="0.2"/>
                                <path d="M60 25H82C82.5523 25 83 24.5523 83 24C83 23.4477 82.5523 23 82 23H60C59.4477 23 59 23.4477 59 24C59 24.5523 59.4477 25 60 25Z"
                                      fill="white"/>
                                <path d="M70 13V35C70 35.5523 70.4477 36 71 36C71.5523 36 72 35.5523 72 35V13C72 12.4477 71.5523 12 71 12C70.4477 12 70 12.4477 70 13Z"
                                      fill="white"/>
                            </svg>
                        </div>
                    </div>


                    <div class="col-11 mx-auto">
                        <div class="col-12 d-flex my-3">
                            <div class="col-2 d-flex">
                                <h6 class="text-14 my-4">Параметры</h6>
                            </div>



                            <div class="col-8">
                                <div class="col-12 div_add_parameter">
                                    <h6 class="text-center text-14 mt-5 my-3">Действующие</h6>
                                </div>

                                <div class="col-12 div_add_new_parameter">
                                    <h6 class="text-center text-14 mt-5 my-3">Новые</h6>
                                </div>

                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center">
                            <svg onclick="addParameter()" class="cursor svg_add_category" width="143" height="48"
                                 viewBox="0 0 143 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.5" y="0.5" width="142" height="47" rx="7.5" stroke="white"
                                      stroke-opacity="0.2"/>
                                <path d="M60 25H82C82.5523 25 83 24.5523 83 24C83 23.4477 82.5523 23 82 23H60C59.4477 23 59 23.4477 59 24C59 24.5523 59.4477 25 60 25Z"
                                      fill="white"/>
                                <path d="M70 13V35C70 35.5523 70.4477 36 71 36C71.5523 36 72 35.5523 72 35V13C72 12.4477 71.5523 12 71 12C70.4477 12 70 12.4477 70 13Z"
                                      fill="white"/>
                            </svg>
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>
</div>

<script src="/js/admin/setting/categories/update.js"></script>

<style>
    .svg_add_category:hover {
        border-radius: 7px;
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>

</body>
</html>

