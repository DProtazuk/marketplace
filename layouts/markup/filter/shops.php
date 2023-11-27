<br>

<?php
$directory = pathinfo(basename($_SERVER['PHP_SELF']), PATHINFO_FILENAME);
if ($directory === "shops") {
    if($status === "open") {
        echo '<div class="col-12 scroll_none filter_div_shop">';
    }
    else echo '<div ="col-12 scroll_none d-none">';?>
    <div class="col-12">
        <h6 class="text-white text-center text-14 my-4">Типы аккаунтов</h6>

        <?php

        $array_Global_categories = $GL->SelectGlobalCategories();
        for ($i = 0; $i < count($array_Global_categories); $i++) {
            echo '<div id="'.$array_Global_categories[$i]['id'].'" class="col-8 mx-auto d-flex cursor menu_filter p-1 rounded-2 py-1 my-1">
        <img width="18" height="18" src="/res/img/img-category/' . $array_Global_categories[$i]['img'] . '">
        <h6 class="text-12 text-white my-auto mx-3">' . $array_Global_categories[$i]['name'] . '</h6>
    </div>';
        }

        ?>

        <!--    <button class="border_blue bg-transparent text-white rounded-3 col-8 d-block mx-auto text-14 mt-3 reset-filter">Сбросить фильтр</button>-->
    </div>
    </div>
<?php }
?>