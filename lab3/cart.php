<?php
session_start();

// Список доступних товарів
$products = ["Сир", "Хліб", "Колбаса", "Масло"];

// Додавання товару
if (isset($_POST['product'])) {
    $product = $_POST['product'];

    // Ініціалізація сесії якщо вона не існує
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $product;

    // Оновлення кукі
    $previous_cart = isset($_COOKIE['previous_cart']) ? json_decode($_COOKIE['previous_cart'], true) : [];
    
    $previous_cart[] = $product;  // Додаємо товар в кукі
    
    // Зберігання кукі на 7 днів
    setcookie('previous_cart', json_encode($previous_cart), time() + 7 * 24 * 60 * 60);  // Куки на 7 дней

    // Редирект щоб не додавалось повторно і кукі після кожного кліка
    header('Location: cart.php');
    exit();
}

// ОТримання кукф
$previous_cart = isset($_COOKIE['previous_cart']) ? json_decode($_COOKIE['previous_cart'], true) : [];

// Очистка корзини
if (isset($_POST['clear_current_cart'])) {
    unset($_SESSION['cart']);
    header('Location: cart.php');
    exit();
}

// Очистка cookies
if (isset($_POST['clear_cookies'])) {
    setcookie('previous_cart', '', time() - 3600);
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина покупок</title>
</head>
<body>
    <h2>Товари:</h2>
    <?php foreach ($products as $product): ?>
        <form method="post">
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td><?php echo htmlspecialchars($product); ?></td>
                    <td>
                        <input type="hidden" name="product" value="<?php echo htmlspecialchars($product); ?>">
                        <button type="submit">Додати</button>
                    </td>
                </tr>
            </table>
        </form>
    <?php endforeach; ?>

    <h2>Корзина:</h2>
    <ul>
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <li><?php echo htmlspecialchars($item); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Корзина пуста</p>
        <?php endif; ?>
    </ul>

    <h2>Минулі покупки:</h2>
    <ul>
        <?php if (!empty($previous_cart)): ?>
            <?php foreach ($previous_cart as $item): ?>
                <li><?php echo htmlspecialchars($item); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Нема кукі</p>
        <?php endif; ?>
    </ul>

    <form method="post">
        <button type="submit" name="clear_current_cart">Очистити корзину</button>
    </form>

    <form method="post">
        <button type="submit" name="clear_cookies">Очистити кукі</button>
    </form>
</body>
</html>
