<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php");
$role = new Role();

if (!$role->Check('admin')) {
    header("Location: /");
}
require_once($_SERVER['DOCUMENT_ROOT'] . "/backend/script/seller/statistics.php");
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/PaymentDetailsType.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/ReferralProgram.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/ReferralTransfers.php";

?>

<?php $PaymentDetailsType = new PaymentDetailsType(); ?>
<?php
$ReferralProgram = new ReferralProgram();
$ReturnReferralPayment_Details = $ReferralProgram->ReturnReferralPayment_Details();
?>
<?php $ReferralTransfers = new ReferralTransfers(); ?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Рефералы</title>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/link/link.php"); ?>
</head>
<body>


<!--Скрытый input активного меню-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_main" data-mini="menu_sidebar_active_uniq_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_analytics" data-mini="menu_sidebar_analytics_mini">-->

<!--<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_shops" data-mini="menu_sidebar_shops_mini">-->

<input type="hidden" class="active_menu" data-type="sidebar" value="menu_sidebar_users"
       data-mini="menu_sidebar_sales_mini" data-submenu="h4-client">


<!--Скрытый input Шапки меню-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-orders">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-balance">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-favorites">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-return_product">-->
<!--<input type="hidden" class="active_menu" data-type="header" value="a-header-referral_program">-->


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

                <div class="col-12 d-flex text-secondary fw-bolder mb-4">
                    <a href="/page/admin/users/client/main?id=<?php echo $_GET['id'] ?>" class="text-14 cursor text-secondary text-decoration-none white-hover mx-3">Общее</a>
                    <a href="/page/admin/users/client/sales.php?id=<?php echo $_GET['id'] ?>" class="text-14 cursor text-secondary text-decoration-none mx-3 white-hover">Покупки</a>
                    <a href="/page/admin/users/client/referral_program?id=<?php echo $_GET['id'] ?>" class="text-14 cursor text-white text-decoration-none mx-3 white-hover">Рефералы</a>
                </div>


                <div class="col-12 bg-silver p-4 px-2 rounded-4 ">
                    <div class="col-9 border border-0 border-bottom border-secondary d-flex border-opacity-50 pb-3">
                        <div class="col-2 px-3 border border-secondary border-0 border-end border-opacity-50">
                            <h6 class="text-14">Баланс</h6>
                            <h6 class="mt-3 fs-5"><?php echo $ReferralProgram->ReturnReferralBalanceAdmin($_GET['id']); ?> ₽</h6>
                        </div>

                        <div class="col-3 px-3 border border-secondary border-0 border-end border-opacity-50">
                            <h6 class="text-14">Всего пришло</h6>
                            <h6 class="mt-3 fs-5"><?php
                                if($ReferralTransfers->ReturnAmount() != "0"){
                                    echo $ReferralTransfers->ReturnAmount();
                                }
                                else echo 0;
                                ?>р.</h6>
                        </div>


                        <div class="col-4 px-3 border-opacity-50">
                            <h6 class="text-14">Кол-во рефералов</h6>
                            <h6 class="mt-3 fs-5"><?php print_r($ReferralProgram->NumberOfReferrals()); ?></h6>
                        </div>
                    </div>

                    <div class="col-12 d-flex align-items-center p-3 py-4">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.33892 23.1403L15.4639 8.1403C15.82 7.7334 16.3343 7.5 16.875 7.5H43.125C43.6657 7.5 44.18 7.7334 44.5361 8.1403L57.6611 23.1403C58.2948 23.8645 58.2773 24.9509 57.6207 25.6543L31.3707 53.7793C30.6642 54.5364 29.4777 54.5773 28.7207 53.8707C28.6892 53.8413 28.6587 53.8108 28.6293 53.7793L2.37927 25.6543C1.72268 24.9509 1.70524 23.8645 2.33892 23.1403ZM30 49.752L6.27693 24.3344L17.7258 11.25H42.2742L53.7231 24.3344L30 49.752Z" fill="#1877F2"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M31.4877 8.2338L42.9956 23.2338C43.4015 23.7629 43.4958 24.4679 43.2433 25.0851L31.7355 53.2101C31.3433 54.1686 30.2485 54.6276 29.2901 54.2355C28.8246 54.045 28.4552 53.6756 28.2648 53.2101L16.7569 25.0851C16.5044 24.4679 16.5987 23.7629 17.0047 23.2338L28.5125 8.2338C29.1428 7.4122 30.3198 7.25714 31.1414 7.88746C31.2715 7.98726 31.3879 8.1037 31.4877 8.2338ZM20.6355 24.6619L30.0001 12.4555L39.3647 24.6619L30.0001 47.5489L20.6355 24.6619Z" fill="#1877F2"/>
                            <path d="M3.75 26.25H56.25C57.2855 26.25 58.125 25.4105 58.125 24.375C58.125 23.3395 57.2855 22.5 56.25 22.5H3.75C2.71447 22.5 1.875 23.3395 1.875 24.375C1.875 25.4105 2.71447 26.25 3.75 26.25Z" fill="#1877F2"/>
                        </svg>

                        <h6 class="text-14 mx-4">Рейтинг клиента / Награды / </h6>
                    </div>

                </div>


                <div class="col-12 bg-silver rounded-4 m-auto my-4 p-4 shadow_status">

                    <div class="col-12 d-flex justify-content-between">
                        <div class="col-12 text-white d-flex align-items-center">
                            <span class="text-white text-14 span_coming cursor">Приход</span>
                            <span class="text-secondary text-14 mx-4">|</span>
                            <span class="text-secondary text-14 span_orders cursor">Ордера на вывод средств</span>


                            <span class="text-secondary text-14 mx-4">|</span>

                            <span class="text-14 mx-4">Даты</span>

                            <input id="start" value="<?php echo date('Y-m-d', strtotime('-1 month')); ?>" type="date"
                                   class="text-14 text-white mx-3 input-price-seller px-2 py-1 rounded-2 border_input"
                                   style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">

                            <input id="finish" value="<?php echo date('Y-m-d'); ?>" type="date"
                                   class="text-14 text-white mx-3 input-price-seller px-2 py-1 rounded-2 border_input"
                                   style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px; !important;">
                        </div>

                        <div class="dropdown">

                        </div>
                    </div>

                    <table class="col-12 my-3">
                    </table>

                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script src="/js/client/paginate.js"></script>
    <script src="/js/client/referral_program.js"></script>


    <style>
        input[type=date]::-webkit-calendar-picker-indicator {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 24 24"><path fill="%23bbbbbb" d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>');
        }
    </style>

</body>
</html>