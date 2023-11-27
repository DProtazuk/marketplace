<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/print.php");


$role = new Role();
$role = $role->Check('client');

if($role) {
    header('Location: /page/public/main');
}
if(isset($_GET['referral_link'])) {
    setcookie("referral_link", $_GET['referral_link'], time() + 86400, "/");
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
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
                <form action="/backend/script/entry_system/registration" method="post">
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

                            <svg width="76" height="14" viewBox="0 0 76 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.1602 14V4.57617L12.1797 14H8.70312L3.72266 4.57617V14H0.0996094V0.582031H5.02148L10.4414 10.7383L15.8613 0.582031H20.7637V14H17.1602ZM28.5859 14H24.9629V0.582031H34.0449C35.0215 0.582031 35.8483 0.682943 36.5254 0.884766C37.209 1.08659 37.7624 1.37305 38.1855 1.74414C38.6152 2.11523 38.9245 2.56445 39.1133 3.0918C39.3086 3.61263 39.4062 4.19531 39.4062 4.83984C39.4062 5.40625 39.3249 5.90104 39.1621 6.32422C39.0059 6.7474 38.791 7.11198 38.5176 7.41797C38.2507 7.71745 37.9382 7.97135 37.5801 8.17969C37.222 8.38802 36.8444 8.56055 36.4473 8.69727L40.8418 14H36.6035L32.541 9.05859H28.5859V14ZM35.7441 4.82031C35.7441 4.5599 35.7083 4.33854 35.6367 4.15625C35.5716 3.97396 35.4544 3.82747 35.2852 3.7168C35.1159 3.59961 34.888 3.51497 34.6016 3.46289C34.3216 3.41081 33.9701 3.38477 33.5469 3.38477H28.5859V6.25586H33.5469C33.9701 6.25586 34.3216 6.22982 34.6016 6.17773C34.888 6.12565 35.1159 6.04427 35.2852 5.93359C35.4544 5.81641 35.5716 5.66667 35.6367 5.48438C35.7083 5.30208 35.7441 5.08073 35.7441 4.82031ZM47.082 5.69922L54.5039 0.582031H59.3574L50.3242 7.01758L59.9629 14H54.6797L47.082 8.42383V14H43.4395V0.582031H47.082V5.69922ZM69.5918 3.50195V14H65.9688V3.50195H60.2754V0.582031H75.2949V3.50195H69.5918Z" fill="white"/>
                            </svg>
                        </div>

                        <h6 class="text-18 text-center my-4">Торговая площадка №1
                            <br>
                            по продаже любых видов аккаунтов</h6>


                        <div class="col-12 my-4 mt-5 ">
                            <div class="col-12 my-4">
                                <input value="<?php
                                    if(isset($_GET['name'])){
                                        echo $_GET['name'];
                                    }
                                ?>" name="name" placeholder="Имя" class="input-auth px-3 text-white bg-silver col-12 text-14 py-1 rounded-2 border border-secondary" type="text"
                                       style=" outline:none;  ">
                            </div>

                            <div class="col-12 my-4">
                                <input value="<?php
                                if(isset($_GET['email'])){
                                    echo $_GET['email'];
                                }
                                ?>" name="email" require_onced placeholder="Email" class="input-auth px-3 text-white bg-silver col-12 text-14 py-1 rounded-2 border border-secondary" type="email"
                                       style=" outline:none;  ">
                                <?php
                                if(isset($_GET['error']) AND $_GET['error'] === "email"){
                                    echo '<h6 class="text-13 my-1 text-danger text-check-politics">Email уже зарегистрирован!</h6>';
                                }
                                ?>

                            </div>

                            <div class="col-12 my-4">
                                <input value="<?php
                                if(isset($_GET['password'])){
                                    echo $_GET['password'];
                                }
                                ?>" name="password" require_onced placeholder="Пароль" class="input-auth px-3 text-white bg-silver col-12 text-14 py-1 rounded-2 border border-secondary" type="text"
                                       style=" outline:none;  ">
                            </div>

                            <div class="col-12 my-4">
                                <input name="second_password" require_onced placeholder="Повторите пароль" class="input-auth px-3 text-white bg-silver col-12 text-14 py-1 rounded-2 border border-secondary" type="text"
                                       style=" outline:none;  ">
                                <?php
                                    if(isset($_GET['error']) AND $_GET['error'] === "password"){
                                        echo '<h6 class="text-13 my-1 text-danger text-check-politics">Пароли не совпадают!</h6>';
                                    }
                                ?>

                            </div>

                            <div class=" col-12 my-4 bg">
                                <input name="referral_link" placeholder="Реферальный код " class="input-auth px-3 text-white bg-silver col-12 text-14 py-1 rounded-2 border border-secondary" type="text" style=" outline:none;  " value="<?php
                                    if(isset($_GET['referral_link'])){
                                        echo $_GET['referral_link'];
                                    }
                                    else {
                                        if(isset($_COOKIE['referral_link'])){
                                            echo $_COOKIE['referral_link'];
                                        }
                                    }
                                ?>">

                                <?php
                                if(isset($_GET['error']) AND $_GET['error'] === "referral_link"){
                                    echo '<h6 class="text-13 my-1 text-danger">Реферальный код не действующий!</h6>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-12 d-flex">

                            <div class="cursor" onclick="click_politics()">
                                <input type="hidden" name="check-politics" value="0">
                                <div class="rounded-1 block-politics-false" style="width: 24px; height: 24px; border: 1px solid rgba(255, 255, 255, 0.1);"></div>
                                <div class="block-politics-true d-none">
                                    <svg class="border-1 rounded-1 border_blue" width="24" height="24" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.98257 9.08038L3.98234 9.08016C3.87099 8.96881 3.71997 8.90625 3.5625 8.90625C3.40503 8.90625 3.25401 8.96881 3.14266 9.08016C3.03131 9.1915 2.96875 9.34253 2.96875 9.5C2.96875 9.50951 2.96898 9.51902 2.96944 9.52852C2.97653 9.67596 3.03828 9.81547 3.14266 9.91984L3.14288 9.92007L7.29891 14.0761C7.53078 14.308 7.90672 14.308 8.13859 14.0761L16.4511 5.76359C16.5624 5.65224 16.625 5.50122 16.625 5.34375C16.625 5.18628 16.5624 5.03526 16.4511 4.92391C16.3397 4.81256 16.1887 4.75 16.0312 4.75C15.8738 4.75 15.7228 4.81256 15.6114 4.92391L7.71875 12.8166L3.98257 9.08038Z" fill="white"/>
                                    </svg>
                                </div>
                            </div>

                            <h6 class="text-14 mx-3">Я принимаю
                                <a class="text-decoration-none text_blue" href="/page/public/politics">пользовательское соглашение и
                                    политику конфиденциальности
                                </a>
                            </h6>
                        </div>
                        <h6 class="text-13 my-1 text-danger text-check-politics"></h6>


                        <button class="bg_blue my-3 rounded-3 d-flex justify-content-center text-center align-items-center col-12 text-16 py-1 text-white border_blue bg-transparent text-decoration-none btn-registration" type="button" onclick="btn_registration()">
                            Регистрация
                        </button>

                        <h6 class="text-14 my-3 text-center">Есть аккаунт? <a class="text-decoration-none text_blue" href="/page/entry_system/authorization">Войти</a> </h6>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<style>
    .input-auth::placeholder {color: white;}
</style>

<script>
    $(".a-header-authorization").addClass("btn_buy");
    $(".a-header-registration").addClass("bg_blue");
</script>

<script>
    function click_politics() {
        if(check_politics() === "0"){
            $(".block-politics-false").addClass("d-none");
            $(".block-politics-true").removeClass("d-none");
            $("input[name='check-politics']").val(1);
            $(".btn-registration").attr("type", "submit");
        }
        else {
            $(".block-politics-false").removeClass("d-none");
            $(".block-politics-true").addClass("d-none");
            $("input[name='check-politics']").val(0);
            $(".btn-registration").attr("type", "button");
        }
    }

    function btn_registration() {
        if($(".btn-registration").attr("type") == "button"){
            $(".text-check-politics").text("Чтобы продолжить, установите этот флажок!");
        }
        else {
            $(".text-check-politics").text("");
        }
    }

    function check_politics() {
        return $("input[name='check-politics']").val();
    }
</script>



</body>
</html>