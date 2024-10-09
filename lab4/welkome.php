<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Перенаправлення на форму авторизації
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Ласкаво просимо!</title>
</head>
<body>
    <h1>Ласкаво просимо, <?php echo $_SESSION['username']; ?>!</h1>
    <a href="logout.php">Вийти</a>
</body>
</html>
