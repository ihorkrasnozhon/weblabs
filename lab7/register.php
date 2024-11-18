<?php
session_start();
include 'database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $response['message'] = 'Паролі не співпадають.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $conn->insert_id;
            $response['success'] = true;
            $response['message'] = 'Успішна реєстрація.';
//            exit;
        } else {
            $response['message'] = 'Помилка при збереженні даних: ' . $stmt->error;
        }

        $stmt->close();
    }
}

echo json_encode($response);
?>
