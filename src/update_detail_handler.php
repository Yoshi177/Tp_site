<?php
require_once('db.php');

// Получаем данные из формы
$id = intval($_POST['id']);
$status = trim($_POST['status']);

// Проверяем ввод
if (empty($status)) {
    header("Location: edit_detail.php?id=$id&error=Состояние детали не может быть пустым");
    exit();
}

// SQL-запрос для обновления
$sql = "UPDATE details SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    header("Location: manage_details.php?success=Деталь успешно обновлена");
} else {
    header("Location: edit_detail.php?id=$id&error=Ошибка обновления: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
