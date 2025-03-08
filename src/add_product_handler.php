<?php
require_once('db.php');

// Получаем данные из формы
$status = trim($_POST['status']);
$detail_id = !empty($_POST['detail_id']) ? intval($_POST['detail_id']) : null;

// Проверяем ввод
if (empty($status)) {
    $sql = "INSERT INTO products (detail_id, status) VALUES (?, ?)";

    // Подготовка и выполнение запроса
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Ошибка подготовки запроса: " . $mysqli->error);
    }

    // Устанавливаем значения для вставки
    $detail_id = null; // Значение для detail_id
    $status = $_POST['status'] ?? 'default_status'; // Установите значение по умолчанию


    // Привязка параметров
    $stmt->bind_param("is", $detail_id, $status); // Используем 'i' для integer и 's' для string

    // Выполнение запроса
    $stmt->execute();
    header("Location: manage_products.php?success=Изделие добавлено");
    exit();
}

// Проверяем значение set_in в таблице details
$checkSql = "SELECT set_in FROM details WHERE id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("i", $detail_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    $row = $checkResult->fetch_assoc();
    if ($row['set_in'] == 1) {
        // Если set_in равно 1, вставка не удачная
        header("Location: manage_products.php?error=Ошибка добавления: деталь недоступна");
        exit();
    }
} /*else {
    // Если деталь не найдена, можно обработать это как ошибку
    header("Location: manage_products.php?error=Ошибка: деталь не найдена");
    exit();
}*/

// SQL-запрос для добавления изделия
$sql = "INSERT INTO products (status, detail_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $detail_id);

if ($stmt->execute()) {
    header("Location: manage_products.php?success=Изделие добавлено");
} else {
    header("Location: manage_products.php?error=Ошибка добавления: " . $stmt->error);
}

$checkStmt->close();
$stmt->close();
$conn->close();
?>
