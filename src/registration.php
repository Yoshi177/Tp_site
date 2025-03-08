<?php
require_once('db.php');

// Получаем данные из POST-запроса
$role = trim($_POST['role']);
$login = trim($_POST['login']);
$password = trim($_POST['password']);

if (empty($login) || empty($password) || empty($role)) {
    header("Location: /src/register_form.php?error=Заполните все поля");
    exit();
}

// Хэшируем пароль
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Подготовленный запрос для защиты от SQL-инъекций
$sql = "INSERT INTO bez_reg (role, login, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $role, $login, $hashedPassword);

// Выполняем запрос и проверяем результат
if ($stmt->execute()) {
    header("Location: /registrationUsers.html?success=Успешная регистрация");
} else {
    header("Location: /registrationUsers.html?error=Ошибка регистрации: " . urlencode($stmt->error));
}

$stmt->close();
$conn->close();
?>
