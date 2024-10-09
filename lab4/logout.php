<?php
session_start();
session_destroy();
header("Location: login.php"); // Перенаправлення на форму авторизації
exit();
?>
