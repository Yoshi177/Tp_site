<?php
require_once('db.php');

$role = trim($_POST['role']);
$login = trim($_POST['login']);
$password = trim($_POST['password']);

if (empty($role) || empty($login) || empty($password)) {
    header("Location: add_user.php?error=Заполните все поля");
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$sql = "INSERT INTO bez_reg (role, login, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $role, $login, $hashedPassword);

if ($stmt->execute()) {
    header("Location: manage_users.php?success=Пользователь добавлен");
} else {
    header("Location: add_user.php?error=Ошибка добавления: " . urlencode($stmt->error));
}
$stmt->close();
$conn->close();
