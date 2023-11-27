<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
$role = new Role();

if (!$role->Check('admin')) {
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
    <title>Создание категории</title>
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
                            <div onclick="save()" style="min-height: 28px"
                                 class="bg-white d-flex justify-content-center align-items-center w-75 mx-auto text-center bg-opacity-10 rounded-3 cursor text-14">
                                Сохранить
                            </div>
                        </div>
                    </div>


                    <div class="col-11 mx-auto d-flex my-5">
                        <div class="col-2">
                            <input accept="image/*" onchange="renderImg.call()" class="d-none inputImg" type="file">

                            <div class="cursor" onclick='imgDown()' style="width: 100px;">
                                <div class="col-12 div_svg ">
                                    <svg width="100" height="100" viewBox="0 0 100 100"
                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100" height="100" rx="16" fill="white" fill-opacity="0.1"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M66.5456 63.7331C66.5456 63.7331 65.31 64.9688 63.5625 64.9688H35.4375C35.4375 64.9688 33.69 64.9688 32.4544 63.7331C32.4544 63.7331 31.2188 62.4975 31.2188 60.75V41.0625C31.2188 41.0625 31.2188 39.315 32.4544 38.0794C32.4544 38.0794 33.69 36.8438 35.4375 36.8438H40.3099L42.7049 33.2512C42.9657 32.86 43.4048 32.625 43.875 32.625H55.125C55.5952 32.625 56.0343 32.86 56.2951 33.2512L58.6901 36.8438H63.5625C63.5625 36.8438 65.31 36.8438 66.5456 38.0794C66.5456 38.0794 67.7812 39.315 67.7812 41.0625V60.75C67.7812 60.75 67.7812 62.4975 66.5456 63.7331ZM64.5569 61.7444C64.5569 61.7444 64.9688 61.3325 64.9688 60.75V41.0625C64.9688 41.0625 64.9688 40.48 64.5569 40.0681C64.5569 40.0681 64.145 39.6562 63.5625 39.6562H57.9375C57.4673 39.6562 57.0282 39.4213 56.7674 39.03L54.3724 35.4375H44.6276L42.2326 39.03C41.9718 39.4213 41.5327 39.6562 41.0625 39.6562H35.4375C35.4375 39.6562 34.855 39.6562 34.4431 40.0681C34.4431 40.0681 34.0312 40.48 34.0312 41.0625V60.75C34.0312 60.75 34.0312 61.3325 34.4431 61.7444C34.4431 61.7444 34.855 62.1562 35.4375 62.1562H63.5625C63.5625 62.1562 64.145 62.1562 64.5569 61.7444Z"
                                              fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M49.5 42.4688C49.5 42.4688 52.7037 42.4688 54.969 44.7341C54.969 44.7341 57.2344 46.9994 57.2344 50.2031C57.2344 50.2031 57.2344 53.4068 54.969 55.6722C54.969 55.6722 52.7037 57.9375 49.5 57.9375C49.5 57.9375 46.2963 57.9375 44.031 55.6722C44.031 55.6722 41.7656 53.4068 41.7656 50.2031C41.7656 50.2031 41.7656 46.9994 44.031 44.7341C44.031 44.7341 46.2963 42.4688 49.5 42.4688ZM49.5 45.2812C49.5 45.2812 47.4613 45.2812 46.0197 46.7228C46.0197 46.7228 44.5781 48.1644 44.5781 50.2031C44.5781 50.2031 44.5781 52.2418 46.0197 53.6834C46.0197 53.6834 47.4613 55.125 49.5 55.125C49.5 55.125 51.5387 55.125 52.9803 53.6834C52.9803 53.6834 54.4219 52.2418 54.4219 50.2031C54.4219 50.2031 54.4219 48.1644 52.9803 46.7228C52.9803 46.7228 51.5387 45.2812 49.5 45.2812Z"
                                              fill="white"/>
                                    </svg>
                                </div>

                                <img style="width: 100px;" class="div_check_img d-none" src="">

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
                                    <input require_onced value=""
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

                            <div class="col-8 div_add_category">

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

                            <div class="col-8 div_add_parameter">


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

<script src="/js/admin/setting/categories/create.js"></script>

<style>
    .svg_add_category:hover {
        border-radius: 7px;
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>

</body>
</html>

