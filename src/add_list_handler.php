<?php
require_once('db.php');

$product_id = trim($_POST['product_id']);
$detail_id = trim($_POST['detail_id']);
/*$priority = trim($_POST['priority']);*/
$priority = null;

if (empty($product_id) || empty($detail_id)) {
    header("Location: add_new_list.php?error=Заполните все поля");
    exit();
}

$checkSql = "SELECT COUNT(*) FROM list_for_workers WHERE detail_id = ? AND id != ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $detail_id, $id);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

if ($count > 0) {
    // Если detail_id уже существует, выдаем ошибку
    header("Location: add_new_list.php?error=Ошибка: detail_id уже существует");
    exit();
}

// Проверка на существование детали
$checkDetailSql = "SELECT COUNT(*) FROM details WHERE id = ?";
$checkDetailStmt = $conn->prepare($checkDetailSql);
$checkDetailStmt->bind_param("i", $detail_id);
$checkDetailStmt->execute();
$checkDetailStmt->bind_result($detailExists);
$checkDetailStmt->fetch();
$checkDetailStmt->close();

if ($detailExists === 0) {
    // Если деталь не найдена, выдаем ошибку
    header("Location: add_new_list.php?error=Ошибка: деталь с таким id не существует");
    exit();
}

// Проверяем значение set_in в таблице details
$checkSetInSql = "SELECT set_in, in_list FROM details WHERE id = ?";
$checkSetInStmt = $conn->prepare($checkSetInSql);
$checkSetInStmt->bind_param("i", $detail_id);
$checkSetInStmt->execute();
$checkSetInStmt->bind_result($set_in, $in_list);
$checkSetInStmt->fetch();
$checkSetInStmt->close();

// Проверка значения set_in
if ($set_in === 1) {
    // Если set_in равно 1, выдаем ошибку
    header("Location: add_new_list.php?error=Ошибка: вставка невозможна, set_in равно 1");
    exit();
}

// Проверка значения in_list
if ($in_list === 1) {
    // Если in_list равно 1, выдаем ошибку
    header("Location: add_new_list.php?error=Ошибка: вставка невозможна, in_list равно 1");
    exit();
}

$checkProductSql = "SELECT COUNT(*) FROM products WHERE id = ?";
$checkProductStmt = $conn->prepare($checkProductSql);
$checkProductStmt->bind_param("i", $product_id);
$checkProductStmt->execute();
$checkProductStmt->bind_result($productExists);
$checkProductStmt->fetch();
$checkProductStmt->close();

if ($productExists === 0) {
    // Если продукт не найден, выдаем ошибку
    header("Location: add_new_list.php?error=Ошибка: продукт с таким id не существует");
    exit();
}

$checkInListSql = "SELECT in_list FROM products WHERE id = ?";
$checkInListStmt = $conn->prepare($checkInListSql);
$checkInListStmt->bind_param("i", $product_id);
$checkInListStmt->execute();
$checkInListStmt->bind_result($in_list);
$checkInListStmt->fetch();
$checkInListStmt->close();

if ($in_list === 1) {
    // Если in_list равно 1, выдаем ошибку
    header("Location: add_new_list.php?error=Ошибка: изделие уже в списке");
    exit();
}

$sql = "INSERT INTO list_for_workers (product_id, detail_id, priority) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $product_id, $detail_id, $priority);

if ($stmt->execute()) {
    // Обновляем значение in_list в таблице products на 1
    $updateInListSql = "UPDATE products SET in_list = 1 WHERE id = ?";
    $updateInListStmt = $conn->prepare($updateInListSql);
    $updateInListStmt->bind_param("i", $product_id);
    $updateInListStmt->execute();
    $updateInListStmt->close();

    // Обновляем значение in_list в таблице products на 1
    $updateInListdetailsSql = "UPDATE details SET in_list = 1 WHERE id = ?";
    $updateInListdetailsStmt = $conn->prepare($updateInListdetailsSql);
    $updateInListdetailsStmt->bind_param("i", $detail_id);
    $updateInListdetailsStmt->execute();
    $updateInListdetailsStmt->close();


    header("Location: manage_list_for_workers.php?success=Список добавлен");
} else {
    header("Location: add_new_list.php?error=Ошибка добавления: " . urlencode($stmt->error));
}
$stmt->close();
$conn->close();
