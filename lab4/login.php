<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизація</title>
</head>
<body>
    <h1>Авторизація</h1>
    <form action="" method="POST"> <!-- Зміна action -->
        <label for="username">Ім'я користувача:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Увійти">
    </form>

    <?php
session_start();
$host = 'localhost';
$db = 'users_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Хешування пароля за допомогою MD5

    // Підготовлений запит
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: welkome.php"); // Перенаправлення на захищену сторінку
        exit();
    } else {
        echo "Неправильне ім'я користувача або пароль.";
    }

    $stmt->close();
}

$conn->close();
?>

<p>Ще не зареєстровані? <a href="register.php">Зареєструватись</a></p>

</body>
</html>
