<?php
session_start();

// Автоматичне завершення сесії після 5 хвилин
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 300)) {
    session_unset();
    session_destroy();
    header('Location: session.php');
    exit();
}
$_SESSION['last_activity'] = time();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: session.php');
    exit();
}

if (isset($_POST['login']) && isset($_POST['password'])) {
    $_SESSION['user'] = $_POST['login'];
    header('Location: session.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Session Example</title>
</head>
<body>
    <?php if (isset($_SESSION['user'])): ?>
        <p>Вітаю, <?php echo htmlspecialchars($_SESSION['user']); ?>!</p>
        <form method="post">
            <button type="submit" name="logout">Вийти</button>
        </form>
    <?php else: ?>
        <form method="post">
            <input type="text" name="login" placeholder="Логін" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Увійти</button>
        </form>
    <?php endif; ?>
</body>
</html>
