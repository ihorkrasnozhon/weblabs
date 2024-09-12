<?php
$uploadDir = 'uploads/';
$maxFileSize = 2 * 1024 * 1024;  // 2 МБ

if (isset($_FILES['user_file'])) {
    $fileName = basename($_FILES['user_file']['name']);
    $fileSize = $_FILES['user_file']['size'];
    $fileTmpName = $_FILES['user_file']['tmp_name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
        die('Помилка: дозволені лише файли JPG, JPEG, PNG.');
    }

    if ($fileSize > $maxFileSize) {
        die('Помилка: файл перевищує 2 МБ.');
    }

    if (file_exists($uploadDir . $fileName)) {
        $fileName = time() . '_' . $fileName;
    }

    if (move_uploaded_file($fileTmpName, $uploadDir . $fileName)) {
        echo "Файл успішно завантажено.<br>";
        echo "Ім'я файлу: $fileName<br>";
        echo "Розмір файлу: " . round($fileSize / 1024, 2) . " КБ<br>";
        echo "<a href='{$uploadDir}{$fileName}'>Завантажити файл</a>";
    } else {
        echo 'Помилка завантаження файлу.';
    }
}
?>
