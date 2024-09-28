<?php

/*if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: error.php');
    exit();
}*/


$client_ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$script_name = $_SERVER['PHP_SELF'];
$request_method = $_SERVER['REQUEST_METHOD'];
$script_path = $_SERVER['SCRIPT_FILENAME'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Server Info</title>
</head>
<body>
    <p>IP адреса: <?php echo $client_ip; ?></p>
    <p>Браузер: <?php echo $user_agent; ?></p>
    <p>Назва скрипта: <?php echo $script_name; ?></p>
    <p>Метод запроса: <?php echo $request_method; ?></p>
    <p>Путь до файлу на сервері: <?php echo $script_path; ?></p>
</body>
</html>
