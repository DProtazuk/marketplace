<?php

$imagePath = $_SERVER['DOCUMENT_ROOT'].'/temp/'.$_POST['img']; // Замените на реальный путь к изображению

if (file_exists($imagePath)) {
    unlink($imagePath);
    echo 'Изображение успешно удалено.';
} else {
    echo 'Изображение не найдено.';
}