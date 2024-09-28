<?php
if (isset($_POST['name'])) {
    setcookie('username', $_POST['name'], time() + 7 * 24 * 60 * 60); // Зберпеження на 7 днів
    header('Location: cookie.php');
    exit();
}

if (isset($_POST['delete_cookie'])) {
    setcookie('username', '', time() - 3600); // Видалення cookie
    header('Location: cookie.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cookie Example</title>
</head>
<body>
    <?php if (isset($_COOKIE['username'])): ?>
        <p>Вітаю, <?php echo htmlspecialchars($_COOKIE['username']); ?>!</p>
        <form method="post">
            <button type="submit" name="delete_cookie">Видалити Cookie</button>
        </form>
    <?php else: ?>
        <form method="post">
            <input type="text" name="name" placeholder="Введи ім'я" required>
            <button type="submit">Відправити</button>
        </form>
    <?php endif; ?>
</body>
</html>
