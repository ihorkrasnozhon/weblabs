<?php
$host = 'localhost';
$db = 'lab7';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Помилка з'єднання до БД: " . $conn->connect_error);
}
?>
