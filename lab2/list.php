<?php
$uploadDir = 'uploads/';

if (is_dir($uploadDir)) {
    $files = array_diff(scandir($uploadDir), ['.', '..']);
    if (!empty($files)) {
        echo "<h2>Список завантажених файлів:</h2>";
        echo "<ul>";
        foreach ($files as $file) {
            echo "<li><a href='{$uploadDir}{$file}'>{$file}</a></li>";
        }
        echo "</ul>";
    } else {
        echo "Файли відсутні.";
    }
} else {
    echo "Директорія не існує.";
}
?>
