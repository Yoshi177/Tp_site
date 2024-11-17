<?php
require_once('db.php');

// Получаем данные из формы
$status = trim($_POST['status']);

// Проверяем ввод
if (empty($status)) {
    header("Location: manage_details.php?error=Состояние детали не может быть пустым");
    exit();
}

// SQL-запрос для добавления детали
$sql = "INSERT INTO details (status) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $status);

if ($stmt->execute()) {
    header("Location: manage_details.php?success=Деталь успешно добавлена");
} else {
    header("Location: manage_details.php?error=Ошибка добавления: " . $stmt->error);
}


$stmt->close();
$conn->close();
?>
