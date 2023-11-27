<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/database/DB.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/print.php");

$role = new Role();
$role = $role->Check('client');

if($role) {
    header('Location: /page/public/main');
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
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
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-favorites">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-return_product">-->
<input type="hidden" class="active_menu" data-type="header" value="a-header-referral_program">


<div class="col-12 d-flex h-100">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/sidebar/public.php"); ?>

    <div class="my-content">
        <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . "/layouts/markup/header/public.php");
        ?>

        <div class="col-12 content-body">
            <div class="myContainer mx-auto my-2">

                <form action="/backend/script/entry_system/authorization.php" method="post">
                    <div class="col-5 rounded-3 bg-silver mx-auto my-5 p-5">

                        <div class="d-flex justify-content-center mx-auto">
                            <svg class="d-block my-auto" width="28" height="14" viewBox="0 0 28 14" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.0996094 14V0.582031H13.6836V3.44336H3.82031V5.66016H13.1758V8.52148H3.82031V11.1387H13.8203V14H0.0996094Z"
                                      fill="white"/>
                                <path d="M0.0996094 14V0.582031H13.6836V3.44336H3.82031V5.66016H13.1758V8.52148H3.82031V11.1387H13.8203V14H0.0996094Z"
                                      fill="#1877F2"/>
                                <path d="M20.9766 7.11523L27.3438 14H22.998L18.7988 9.47852L14.6191 14H10.2832L16.6406 7.11523L10.5957 0.582031H14.9414L18.7988 4.78125L22.6758 0.582031H27.0215L20.9766 7.11523Z"
                                      fill="white"/>
                                <path d="M20.9766 7.11523L27.3438 14H22.998L18.7988 9.47852L14.6191 14H10.2832L16.6406 7.11523L10.5957 0.582031H14.9414L18.7988 4.78125L22.6758 0.582031H27.0215L20.9766 7.11523Z"
                                      fill="#1877F2"/>
                            </svg>

                            <svg width="76" height="14" viewBox="0 0 76 14" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.1602 14V4.57617L12.1797 14H8.70312L3.72266 4.57617V14H0.0996094V0.582031H5.02148L10.4414 10.7383L15.8613 0.582031H20.7637V14H17.1602ZM28.5859 14H24.9629V0.582031H34.0449C35.0215 0.582031 35.8483 0.682943 36.5254 0.884766C37.209 1.08659 37.7624 1.37305 38.1855 1.74414C38.6152 2.11523 38.9245 2.56445 39.1133 3.0918C39.3086 3.61263 39.4062 4.19531 39.4062 4.83984C39.4062 5.40625 39.3249 5.90104 39.1621 6.32422C39.0059 6.7474 38.791 7.11198 38.5176 7.41797C38.2507 7.71745 37.9382 7.97135 37.5801 8.17969C37.222 8.38802 36.8444 8.56055 36.4473 8.69727L40.8418 14H36.6035L32.541 9.05859H28.5859V14ZM35.7441 4.82031C35.7441 4.5599 35.7083 4.33854 35.6367 4.15625C35.5716 3.97396 35.4544 3.82747 35.2852 3.7168C35.1159 3.59961 34.888 3.51497 34.6016 3.46289C34.3216 3.41081 33.9701 3.38477 33.5469 3.38477H28.5859V6.25586H33.5469C33.9701 6.25586 34.3216 6.22982 34.6016 6.17773C34.888 6.12565 35.1159 6.04427 35.2852 5.93359C35.4544 5.81641 35.5716 5.66667 35.6367 5.48438C35.7083 5.30208 35.7441 5.08073 35.7441 4.82031ZM47.082 5.69922L54.5039 0.582031H59.3574L50.3242 7.01758L59.9629 14H54.6797L47.082 8.42383V14H43.4395V0.582031H47.082V5.69922ZM69.5918 3.50195V14H65.9688V3.50195H60.2754V0.582031H75.2949V3.50195H69.5918Z"
                                      fill="white"/>
                            </svg>
                        </div>

                        <h6 class="text-18 text-center my-4">Торговая площадка №1
                            <br>
                            по продаже любых видов аккаунтов</h6>
                        <?php
                        if(isset($_GET['status']) AND $_GET['status'] === "forgot_save"){
                            echo '<h6 class="text-center text-16 my-1 text-white text-check-politics">Пароль успешно сменен!</h6>';
                        }
                        ?>

                        <div class="col-12 my-4 mt-5 ">
                            <div class="input-price-seller col-12">


                                <input value="<?php
                                if (isset($_GET['email'])) {
                                    echo $_GET['email'];
                                }
                                ?>" name="email" placeholder="Email" require_onced
                                       class="input-auth px-3 text-white bg-silver col-12 text-14 py-1 rounded-2 border border-secondary"
                                       type="email"
                                       style=" outline:none;  ">

                                <?php
                                if (isset($_GET['error']) and $_GET['error'] === "email") {
                                    echo '<h6 class="text-13 my-1 text-danger text-check-politics">Введенный Email не зарегистрирован!</h6>';
                                }
                                ?>
                            </div>

                            <div class="input-price-seller col-12 my-4">
                                <input value="<?php
                                if (isset($_GET['password'])) {
                                    echo $_GET['password'];
                                }
                                ?>" name="password" placeholder="Пароль" require_onced
                                       class="input-auth px-3 text-white bg-silver col-12 text-14 py-1 rounded-2 border border-secondary"
                                       type="text"
                                       style=" outline:none;  ">

                                <?php
                                if (isset($_GET['error']) and $_GET['error'] === "password") {
                                    echo '<h6 class="text-13 my-1 text-danger text-check-politics">Неправельный пароль!</h6>';
                                }
                                ?>
                            </div>

                            <div class="col-12 px-3 d-flex justify-content-end">
                                <a class="lh-1 text-decoration-none text-14 text_blue" href="/page/entry_system/forgot_your_password">Забыли пароль?</a>
                            </div>
                        </div>

                        <button type="submit"
                                class="bg_blue rounded-3 d-flex justify-content-center text-center align-items-center col-12 text-16 py-1 text-white border_blue bg-transparent">
                            Войти
                        </button>

                        <h6 class="text-14 my-3 text-center">Нет аккаунта? <a class="text-decoration-none text_blue"
                                                                              href="/page/entry_system/registration">Регистрация</a>
                        </h6>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>

<script>
    $(".a-header-registration").addClass("btn_buy");
    $(".a-header-authorization").addClass("bg_blue");
</script>

<style>
    .input-auth::placeholder {
        color: white;
    }

</style>

</body>
</html>