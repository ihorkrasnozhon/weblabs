<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати товар</title>
</head>
<body>
    <h2>Додати новий товар</h2>

    <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Подключение к базе данных
    $host = 'localhost';
    $db = 'shop';
    $user = 'root';
    $port = 3306;
    $pass = '';

    $conn = new mysqli($host, $user, $pass, $db, $port);

    if ($conn->connect_error) {
        die("Помилка з'єднання: " . $conn->connect_error);
    }

    // Получение данных из формы
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $discount = $_POST['discount'];
    $category_name = $_POST['category'];

    // Получаем id категории
    $sql_category = "SELECT id FROM categories WHERE name = ?";
    $stmt_category = $conn->prepare($sql_category);
    $stmt_category->bind_param("s", $category_name);
    $stmt_category->execute();
    $result_category = $stmt_category->get_result();
    $category_id = null;

    if ($result_category->num_rows > 0) {
        $row = $result_category->fetch_assoc();
        $category_id = $row['id'];
    } else {
        echo "Категорія не знайдена.";
        exit;
    }

    // SQL-запрос для вставки данных
    $sql = "INSERT INTO products (name, price, description, discount, category_id) 
            VALUES (?, ?, ?, ?, ?)";

    // Подготовка и выполнение запроса
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsdi", $name, $price, $description, $discount, $category_id);

    if ($stmt->execute()) {
        echo "Товар успішно додано!";
    } else {
        echo "Помилка: " . $stmt->error;
    }

    // Закрытие соединения
    $stmt->close();
    $stmt_category->close();
    $conn->close();
}
?>


    <form action="" method="post">
        <label for="name">Назва товару:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Опис товару:</label><br>
        <input type="text" id="description" name="description" required><br><br>

        <label for="price">Ціна:</label><br>
        <input type="number" step="0.01" id="price" name="price" required><br><br>

        <label for="discount">Знижка (%):</label><br>
        <input type="number" step="0.01" id="discount" name="discount" value="0"><br><br>

        <label for="category">Категорія:</label><br>
        <select id="category" name="category" required>
            <option value="Електроніка">Електроніка</option>
            <option value="Одяг">Одяг</option>
            <option value="Книги">Книги</option>
        </select><br><br>

        <input type="submit" value="Додати товар">
    </form>
</body>
</html>
