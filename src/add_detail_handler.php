<?php
require_once('db.php');

$status = trim($_POST['status']);
$set_it = 0; // Устанавливаем значение set_in в 0

if (empty($status)) {
    header("Location: manage_details.php?error=Состояние не может быть пустым");
    exit();
}

// Обновленный SQL-запрос для вставки значения в поле set_in
$sql = "INSERT INTO details (status, set_in) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $set_it); // Привязываем статус как строку и set_in как целое число

if ($stmt->execute()) {
    header("Location: manage_details.php?success=Деталь добавлена");
} else {
    header("Location: manage_details.php?error=Ошибка добавления: " . $stmt->error);
}


$stmt->close();
$conn->close();
?>
