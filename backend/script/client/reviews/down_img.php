<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем, что файл был успешно загружен
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $tempFile = $_FILES['file']['tmp_name'];

        $prefix = 'image_';
        $uniqueHash = uniqid($prefix, false);

        $originalFileName = $_FILES['file']['name'];
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        $newFileName = $uniqueHash . '.' . $extension;

        $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/temp/';
        $targetFile = $targetDirectory . $newFileName;

        // Перемещаем загруженный файл в целевую директорию
        if (move_uploaded_file($tempFile, $targetFile)) {
            echo $newFileName;
        } else {
            // Ошибка при сохранении файла
            echo 'Произошла ошибка при сохранении изображения.';
        }
    } else {
        // Ошибка при загрузке файла
        echo 'Произошла ошибка при загрузке изображения.';
    }
} else {
    // Некорректный тип запроса
    echo 'Некорректный тип запроса.';
}