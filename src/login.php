<?php
session_start();
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    if (empty($login) || empty($password)) {
        echo "Заполните все поля.";
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM bez_reg WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Сохраняем пользователя в сессии
            $_SESSION['user'] = [
                'id' => $user['id'],
                'login' => $user['login'],
                'role' => $user['role'], // Роль пользователя
            ];

            // Редирект на главную страницу после авторизации
            header("Location: /dashboard.php");
            exit();
        } else {
            echo "Неверный пароль.";
        }
    } else {
        echo "Нет такого пользователя.";
    }
}
?>
