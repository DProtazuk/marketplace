<?php
require_once($_SERVER['DOCUMENT_ROOT']."/backend/Class/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/backend/Class/Role.php");
require_once($_SERVER['DOCUMENT_ROOT']."/backend/Class/balance/Balance.php");

$User = new User();
$balance = new Balance();

$Role = new Role();

?>

<div class="my-header col-12 d-flex align-items-center">
    <img class="mx-3 cursor my-auto" onclick="btnMenu()" width="25" src="/res/img/markup/header/markup-icon.png">

    <div class="col-11">
        <div class="myContainer d-flex justify-content-between align-items-center">
            <div class="col-7">

            </div>

            <div class="d-flex col-5 align-items-center justify-content-end">


                <div class="d-flex align-items-center cursor col-5 position-relative">
                    <img class="rounded-5 position-absolute" width="35" height="35" src="/res/img/markup/header/elipse.svg" style="z-index: 111111;">

                    <div class="select select_standard header_name_account mx-4">
                        <input class="select__input select__input_standard" type="hidden" name="">
                        <div class="select__head select__head_standard p-1 text-white"><?php echo $User->ReturnInfoUser('name'); ?></div>
                        <ul class="select__list select__list_standard bg-opacity-50 rounded-top rounded-2" style="display: none;">

                            <?php

                            if ($Role->Check('admin')) {
                                echo '<a class="text-decoration-none text-white" href="/page/admin/dashboard">
                                <li class="select__item select__item_standard mt-1 py-1">Администратор</li>
                            </a>';
                            }

                            ?>

                            <a class="text-decoration-none text-white" href="/page/public/main">
                                <li class="select__item select__item_standard mt-1 py-1">Клиент</li>
                            </a>

                            <a class="text-decoration-none text-white" href="/page/seller/main">
                                <li class="select__item select__item_standard mt-1 py-1">Поставщик</li>
                            </a>

                            <a class="text-decoration-none text-white" href="/page/client/profile">
                                <li class="select__item select__item_standard mt-1 py-1">Мой профиль</li>
                            </a>

                            <a class="text-decoration-none text-white" href="/backend/script/entry_system/logout">
                                <li class="select__item select__item_standard mt-1 py-1">Выйти</li>
                            </a>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>