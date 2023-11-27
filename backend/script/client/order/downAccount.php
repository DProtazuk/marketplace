<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

function redirect(): void
{
    header('Location: /');
}

///Проверка наличия куков
{
    if(!isset($_COOKIE['unique_id'])){
        redirect();
    }
    $unique_id = $_COOKIE['unique_id'];
}

//Проверка наличия get параметра
{
    if(!isset($_GET['id'])){
        redirect();
    }
    $id = $_GET['id'];
}

//Проверка наличие этого заказа у клиента
{
    $sql = "SELECT `accounts`.`value` FROM `orders` 
        INNER JOIN `account_on_order` ON `orders`.`id` = `account_on_order`.`order_id`
        INNER JOIN `accounts` ON `account_on_order`.`account_id` = `accounts`.`id`
        WHERE `orders`.`unique_id` = ? AND `accounts`.`id` = ?";

    $pdo = DB::connect()->prepare($sql);
    $pdo->execute(array($unique_id, $id));
    $array = $pdo->fetch(PDO::FETCH_ASSOC);

    if (!$array) {
        redirect();
    }
}

{

    $nameFile = $id."_".time().".txt";
    $filename = $_SERVER['DOCUMENT_ROOT']."/res/account/".$nameFile;

    $fp = fopen($filename, 'a');
    fwrite($fp, $array['value'] . PHP_EOL);
    fclose($fp);
}

//Загрузка файла
{
    // иначе Internet Explorer будет игнорировать Content-Disposition
    if(ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');

    $file_extension = strtolower(substr(strrchr($filename,"."),1));

    if( $filename == "" )
    {
        echo "ОШИБКА: УКАЖИТЕ ИМЯ ФАЙЛА.";
        exit;
    } elseif ( ! file_exists( $filename ) ) // проверяем файл на существование
    {
        echo "ОШИБКА: данного файла не существует.";
        exit;
    };
    switch( $file_extension )
    {
        case "pdf": $ctype="application/pdf"; break;
        case "exe": $ctype="application/octet-stream"; break;
        case "zip": $ctype="application/zip"; break;
        case "doc": $ctype="application/msword"; break;
        case "xls": $ctype="application/vnd.ms-excel"; break;
        case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
        case "mp3": $ctype="audio/mp3"; break;
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpg"; break;
        default: $ctype="application/force-download";
    }
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false); // нужен для Explorer
    header("Content-Type: $ctype");
    header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
    header("Content-Transfer-Encoding: binary");
    // нужно сделать подсчет размера файла его пути
    header("Content-Length: ".filesize($filename));
    readfile("$filename");

    unlink($filename);
    exit();
}