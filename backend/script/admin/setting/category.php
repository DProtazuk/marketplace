<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Role.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/MyFunction.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/GlobalCategories.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/Subcategories.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/backend/Class/ParametersProduct.php";

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === "checkImg") {
        if (checkImg('file')) {
            echo "true";
        } else echo "false";
    }
    if ($action === "create") {
        save();
    }
    if ($action === "update_info") {
        update_info();
    }
    if ($action === "update") {
        update();
    }
}
if (isset($_GET['id'])) {
    delete($_GET['id']);
}


function checkImg($input_name)
{

// Разрешенные расширения файлов.
    $allow = array('jpg', 'jpeg', 'png');

    if (!isset($_FILES[$input_name])) {
        return false;
    } else {
        $file = $_FILES[$input_name];

        // Оставляем в имени файла только буквы, цифры и некоторые символы.
        $pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
        $name = mb_eregi_replace($pattern, '-', $file['name']);
        $name = mb_ereg_replace('[-]+', '-', $name);
        $parts = pathinfo($name);

        // Проверим на ошибки загрузки.
        if (!empty($file['error']) || empty($file['tmp_name'])) {
            return false;
        } elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
            return false;
        } else {

            if (!in_array(strtolower($parts['extension']), $allow)) {
                $error = 'error4';
            } else {
                return true;
            }
        }
    }
}


function save()
{

    if (isset($_POST['global_categories'])) {
        if (empty(trim($_POST['global_categories']))) {
            echo json_encode("false");
            exit;
        } else {
            $global_categories = $_POST['global_categories'];
        }
    } else {
        echo json_encode("false");
        exit;
    }

    //Проверка Подкатегорий
    {
        $statusSubcategories = false;

        if (isset($_POST['subcategories'])) {


            $subcategories = json_decode($_POST['subcategories']);


            if (!empty($subcategories)) {

                foreach ($subcategories as $element) {
                    if (empty(trim($element))) {
                        echo json_encode("false");
                        exit;
                    }
                }
                $statusSubcategories = true;
            }
        }
    }


    //Проверка Параметров
    {
        $statusParameter = false;

        if (isset($_POST['parameter'])) {

            $parameter = json_decode($_POST['parameter']);

            if ($parameter) {

                foreach ($parameter as $element) {
                    if (empty(trim($element->name)) || empty(trim($element->key))) {
                        echo json_encode("false");
                        exit;
                    }
                }

                $statusParameter = true;
            }

        }
    }



    //Проверка наличие уже категории на сайте
    {
        $GlobalCategories = new GlobalCategories();

        if (!empty($GlobalCategories->searchGlobalCategories($global_categories))) {
            echo json_encode("global_categories");
            exit;
        }
    }

    //Проверка картинки
    {
        if (!checkImg('file')) {
            echo json_encode("falseImg");
        }
    }


    //Начинаем запись в базу
    {
        //Добавление Глобальной категории
        {
            $MyFunction = new MyFunction();
            $newFileName = $MyFunction->transliterate($global_categories);
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $newFileName = $newFileName . "." . $extension;


            $uploadedFileName = $_FILES['file']['tmp_name']; // Путь к загруженному файлу

            $destination = $_SERVER['DOCUMENT_ROOT'] . '/res/img/img-category/' . $newFileName;

            move_uploaded_file($uploadedFileName, $destination);


            $array = [
                'name' => $global_categories,
                'img' => $newFileName,
                'status' => 1
            ];

            $idGlobalCategories = $GlobalCategories->insert($array);
        }

        //Добавление подкатегорий если они есть
        {
            if ($statusSubcategories) {
                $Subcategories = new Subcategories();

                foreach ($subcategories as $element) {
                    $array = [
                        'id_global_categorie' => $idGlobalCategories,
                        'name' => $element,
                        'status' => 1
                    ];

                    $Subcategories->insert($array);
                }
            }
        }

        //Добавление парамеров если они есть
        {
            if ($statusParameter) {

                $ParametersProduct = new ParametersProduct();

                foreach ($parameter as $element) {
                    $type = "";
                    $mass = "";

                    if ($element->key === "checkbox") {
                        $type = "checkbox";
                        $mass = NULL;
                    }
                    if ($element->key === "input_day") {
                        $type = "input";
                        $mass = "дней";
                    }
                    if ($element->key === "input_ht") {
                        $type = "input";
                        $mass = "шт.";
                    }
                    if ($element->key === "input_ed") {
                        $type = "input";
                        $mass = "ед.";
                    }
                    if ($element->key === "input_geo") {
                        $type = "select";
                        $mass = json_encode(["ru", "uk", "usa", "de"]);
                    }
                    if ($element->key === "input_bm") {
                        $type = "two_inputs";
                        $mass = "+";
                    }

                    $array = [
                        'id_categories' => $idGlobalCategories,
                        'name' => $element->name,
                        'type' => $type,
                        'mass' => $mass,
                        'status' => 1
                    ];

                    $ParametersProduct->insert($array);
                }
            }
        }

        echo json_encode("save");
    }

}


function delete($id)
{
    $role = new Role();

    if (!$role->Check('admin')) {
        header("Location: /");
    }

    $GlobalCategories = new GlobalCategories();

    $array = $GlobalCategories->searchGlobalCategoriesId($id);

    if (empty($array)) {
        header("Location: /page/admin/setting/categories/search");
    } else {
        if ($array['status'] === 1) {
            $GlobalCategories->deleteGlobalCategories($id);
        }

        header("Location: /page/admin/setting/categories/search");
    }
}


function update_info()
{
    if (!isset($_POST['id'])) {
        echo json_encode("false");
        exit();
    }

    $id = $_POST['id'];

    $GlobalCategories = new GlobalCategories();
    $arrayGlobalCategories = $GlobalCategories->searchGlobalCategoriesId($id);
    if (empty($arrayGlobalCategories)) {
        echo json_encode("false");
        exit();
    }

    $Subcategories = new Subcategories();

    $SelectCategoryEndParameters = json_decode($Subcategories->SelectCategoryEndParameters($id));
    $SelectCategoryEndParameters[] = $arrayGlobalCategories;
    echo json_encode($SelectCategoryEndParameters);
}


function update()
{
    $MyFunction = new MyFunction();

    if (!isset($_POST['id'])) {
        echo "false";
        exit();
    }

    $id = $_POST['id'];

    $GlobalCategories = new GlobalCategories();
    $arrayGlobalCategories = $GlobalCategories->searchGlobalCategoriesId($id);
    if (empty($arrayGlobalCategories)) {
        echo "false";
        exit();
    }

    //Обновление Глобальной категории
    {
        $name = $arrayGlobalCategories['name'];
        $img = $arrayGlobalCategories['img'];

        if (!isset($_POST['name_global_category'])) {
            echo "false";
            exit();
        } else {
            $name = $_POST['name_global_category'];
        }

        //Проверка картинки
        {
            if (isset($_FILES['file'])) {
                if (!checkImg('file')) {
                    echo "falseImg";
                    exit();
                } else {
                    $newFileName = $MyFunction->transliterate($name);
                    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $newFileName = $newFileName . "." . $extension;


                    $uploadedFileName = $_FILES['file']['tmp_name']; // Путь к загруженному файлу

                    $destination = $_SERVER['DOCUMENT_ROOT'] . '/res/img/img-category/' . $newFileName;

                    move_uploaded_file($uploadedFileName, $destination);

                    $img = $newFileName;
                }
            }
        }

        $array = [
            'name' => $name,
            'img' => $img,
            'id' => $id
        ];

        $GlobalCategories->update($array);
    }

    //Обновление Подкатегорий
    {
        $Subcategories = new Subcategories();

        if (isset($_POST['arraySubcategories'])) {
            $arraySubcategories = $_POST['arraySubcategories'];
            $arraySubcategories = json_decode($arraySubcategories);

            if (!empty($arraySubcategories)) {

                $arrayId[] = $id;

                foreach ($arraySubcategories as $item) {
                    $array = [
                        'name' => $item->name,
                        'id' => $item->id
                    ];

                    array_push($arrayId, $item->id);

                    $Subcategories->update($array);
                }

                $placeholders = rtrim(str_repeat('?,', count($arrayId)), ',');
                $sql = "UPDATE `subcategories` SET `status` = 2 WHERE `id_global_categorie` = ? AND `id` NOT IN ($placeholders)";
                $stmt = DB::connect()->prepare($sql);
                $params = array_merge([$id], $arrayId);
                $stmt->execute($params);
            }
        } else {
            $query = "UPDATE `subcategories` SET `status` = 2 WHERE `id_global_categorie` = ?";
            $query = DB::connect()->prepare($query);
            $query->execute(array($id));
        }

        if (isset($_POST['arraySubcategoriesNew'])) {
            $arraySubcategoriesNew = $_POST['arraySubcategoriesNew'];
            if (!empty($arraySubcategoriesNew)) {
                $arraySubcategoriesNew = json_decode($arraySubcategoriesNew);

                foreach ($arraySubcategoriesNew as $item) {
                    $array = [
                        'id_global_categorie' => $id,
                        'name' => $item,
                        'status' => 1
                    ];

                    $Subcategories->insert($array);
                }
            }
        }
    }


    //Обновление Параметров
    {
        $ParametersProduct = new ParametersProduct();

        if (isset($_POST['arrayParameters'])) {
            $arrayParameters = $_POST['arrayParameters'];
            $arrayParameters = json_decode($arrayParameters);

            if (!empty($arrayParameters)) {

                $arrayId[] = $id;


                foreach ($arrayParameters as $item) {
                    array_push($arrayId, $item->id);

                    $type = null;
                    $mass = null;

                    if ($item->key === "checkbox") {
                        $type = "checkbox";
                        $mass = NULL;
                    }
                    if ($item->key === "input_day") {
                        $type = "input";
                        $mass = "дней";
                    }
                    if ($item->key === "input_ht") {
                        $type = "input";
                        $mass = "шт.";
                    }
                    if ($item->key === "input_ed") {
                        $type = "input";
                        $mass = "ед.";
                    }
                    if ($item->key === "input_geo") {
                        $type = "select";
                        $mass = json_encode(["ru", "uk", "usa", "de"]);
                    }
                    if ($item->key === "input_bm") {
                        $type = "two_inputs";
                        $mass = "+";
                    }

                    $array = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'type' => $type,
                        'mass' => $mass
                    ];

                    $ParametersProduct->update($array);
                }

                $placeholders = rtrim(str_repeat('?,', count($arrayId)), ',');
                $sql = "UPDATE `parameters_product` SET `status` = 2 WHERE `id_categories` = ? AND `id` NOT IN ($placeholders)";
                $stmt = DB::connect()->prepare($sql);
                $params = array_merge([$id], $arrayId);
                $stmt->execute($params);
            }
        } else {
            $query = "UPDATE `parameters_product` SET `status` = 2 WHERE `id_categories` = ?";
            $query = DB::connect()->prepare($query);
            $query->execute(array($id));
        }

        if (isset($_POST['arrayParametersNew'])) {
            $arrayParametersNew = $_POST['arrayParametersNew'];
            if (!empty($arrayParametersNew)) {
                $arrayParametersNew = json_decode($arrayParametersNew);

                $status = 1;

                foreach ($arrayParametersNew as $element) {
                    $type = "";
                    $mass = "";

                    if ($element->key === "checkbox") {
                        $type = "checkbox";
                        $mass = NULL;
                    }
                    if ($element->key === "input_day") {
                        $type = "input";
                        $mass = "дней";
                    }
                    if ($element->key === "input_ht") {
                        $type = "input";
                        $mass = "шт.";
                    }
                    if ($element->key === "input_ed") {
                        $type = "input";
                        $mass = "ед.";
                    }
                    if ($element->key === "input_geo") {
                        $type = "select";
                        $mass = json_encode(["ru", "uk", "usa", "de"]);
                    }
                    if ($element->key === "input_bm") {
                        $type = "two_inputs";
                        $mass = "+";
                    }

                    $array = [
                        'id_categories' => $id,
                        'name' => $element->name,
                        'type' => $type,
                        'mass' => $mass,
                        'status' => $status
                    ];

                    $ParametersProduct->insert($array);
                }
            }
        }
    }

    echo "save";
}