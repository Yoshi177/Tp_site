<?php
require_once('db.php');

// Получаем данные из формы
$status = trim($_POST['status']);
$detail_id = !empty($_POST['detail_id']) ? intval($_POST['detail_id']) : null;

// Проверяем ввод
if (empty($status)) {
    header("Location: manage_products.php?error=Состояние изделия не может быть пустым");
    exit();
}

// SQL-запрос для добавления изделия
$sql = "INSERT INTO products (status, detail_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $detail_id);

if ($stmt->execute()) {
    header("Location: manage_products.php?success=Изделие добавлено");
} else {
    header("Location: manage_products.php?error=Ошибка добавления: " . $stmt->error);
}


$stmt->close();
$conn->close();
?>
