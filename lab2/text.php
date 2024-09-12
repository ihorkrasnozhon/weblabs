<?php
$logFile = 'log.txt';

if (isset($_POST['logText'])) {
    $text = $_POST['logText'];
    $file = fopen($logFile, "a+");
    fwrite($file, $text . PHP_EOL);
    fclose($file);
    echo "Текст успішно записано у файл.<br>";
}

if (file_exists($logFile)) {
    echo "<h2>Вміст файлу log.txt:</h2>";
    $file = fopen($logFile, "r");
    while (!feof($file)) {
        echo fgets($file) . "<br>";
    }
    fclose($file);
} else {
    echo "Файл log.txt не знайдено.";
}
?>
