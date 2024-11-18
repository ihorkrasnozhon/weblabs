<?php
session_start();
include 'database.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $new_username, $new_email, $user_id);

    if ($stmt->execute()) {
        $message = "Дані оновлено успішно.";
        $username = $new_username;
        $email = $new_email;
    } else {
        $message = "Помилка оновлення: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профіль користувача</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Ваш профіль</h1>

<?php if (isset($message)): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>

<form method="post">
    <label>
        Ім'я користувача:
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
    </label>
    <br>
    <label>
        Електронна пошта:
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
    </label>
    <br>
    <button type="submit">Оновити</button>
</form>

<a href="logout.php">Вийти</a>
</body>
</html>
