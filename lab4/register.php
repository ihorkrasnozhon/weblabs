<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>
</head>
<body>
    <h1>Реєстрація</h1>
    
    <?php

    //Віклик сесії і параметри підключення
    session_start();
    $host = 'localhost';
    $db = 'users_db';
    $user = 'root';
    $pass = '';

    // Підключення до бази даних
    $conn = new mysqli($host, $user, $pass, $db);

    // Перевірка підключення
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Обробка форми реєстрації
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']); // Хешування пароля

        // Підготовлений запит
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Реєстрація успішна!</p>";
        } else {
            echo "<p style='color: red;'>Помилка: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    $conn->close();
    ?>

    <form action="" method="POST">
        <label for="username">Ім'я користувача:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Електронна пошта:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Зареєструватись">
    </form>
<p>Вже зареєстровані? <a href="login.php">Увійдіть</a></p>
</body>
</html>
