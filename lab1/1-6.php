<?php
// 1
echo "Hello, World!";

//2
$string = "Це рядок";
$integer = 25; 
$float = 10.5; 
$bool = true; 

echo "\n\nЗначення змінних:\n";
echo "Рядок: " . $string . "\n";
echo "Ціле число: " . $integer . "\n";
echo "Число з плаваючою комою: " . $float . "\n";
echo "Булеве значення: " . ($bool ? 'true' : 'false') . "\n";

echo "\nТипи:\n";
var_dump($string);
var_dump($integer); 
var_dump($float);
var_dump($bool); 

//3
$first = "Hello, ";
$second = "world!";
echo "\n" . $first . $second;

//4
$number = 7;
    if ($number % 2 == 0) {
        echo "\n\nЧисло $number є парним.";
    } else {
        echo "\n\nЧисло $number є непарним.";
    }
    
//5
echo "\n\n";
for ($i = 1; $i <= 10; $i++) {
        echo $i . "\n";
    }
echo "\n\n";
$j = 10;
    while ($j >= 1) {
        echo $j . "\n";
        $j--; }
        
//6
echo "\n\n";
$student = [
        "ім'я" => "Ігор",
        "прізвище" => "Красножон",
        "вік" => 19,
        "спеціальність" => "122"
    ];

    echo "Інформація про студента:\n";
    echo "Ім'я: " . $student["ім'я"] . "\n";
    echo "Прізвище: " . $student["прізвище"] . "\n";
    echo "Вік: " . $student["вік"] . "\n";
    echo "Спеціальність: " . $student["спеціальність"] . "\n";

    $student["середній бал"] = 90;

    echo "\nОновлена інформація про студента:\n";
    foreach ($student as $key => $value) {
        echo $key . ": " . $value . "\n";
    }

?>