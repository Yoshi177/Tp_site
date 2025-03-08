<?php
require_once('db.php');

$id = intval($_POST['id']);
$product_id = trim($_POST['product_id']);
$detail_id = trim($_POST['detail_id']);
$priority = trim($_POST['priority']);

if (empty($product_id) || empty($detail_id)) {
    header("Location: edit_lists.php?id=$id&error=Заполните все поля");
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
    header("Location: edit_lists.php?id=$id&error=Деталь уже находится в другом списке");
    exit();
}

// Проверка на существование product_id в таблице products
$checkProductSql = "SELECT COUNT(*) FROM products WHERE id = ?";
$checkProductStmt = $conn->prepare($checkProductSql);
$checkProductStmt->bind_param("i", $product_id);
$checkProductStmt->execute();
$checkProductStmt->bind_result($countProduct);
$checkProductStmt->fetch();
$checkProductStmt->close();

if ($countProduct == 0) {
    // Если product_id не существует, выдаем ошибку
    header("Location: edit_lists.php?id=$id&error=Продукт не найден");
    exit();
}

// Проверка на существование detail_id в таблице details
$checkDetailExistSql = "SELECT COUNT(*) FROM details WHERE id = ?";
$checkDetailExistStmt = $conn->prepare($checkDetailExistSql);
$checkDetailExistStmt->bind_param("i", $detail_id);
$checkDetailExistStmt->execute();
$checkDetailExistStmt->bind_result($countDetailExist);
$checkDetailExistStmt->fetch();
$checkDetailExistStmt->close();

if ($countDetailExist == 0) {
    // Если detail_id не существует, выдаем ошибку
    header("Location: edit_lists.php?id=$id&error=Деталь не найдена");
    exit();
}

$checkSetInSql = "SELECT set_in FROM details WHERE id = ?";
$checkSetInStmt = $conn->prepare($checkSetInSql);
$checkSetInStmt->bind_param("i", $detail_id);
$checkSetInStmt->execute();
$checkSetInStmt->bind_result($set_in);
$checkSetInStmt->fetch();
$checkSetInStmt->close();

if ($set_in == 1) {
    // Если set_in уже равен 1, выдаем ошибку
    header("Location: edit_lists.php?id=$id&error=Деталь уже установлена");
    exit();
}

$sqlOld = "SELECT product_id, detail_id FROM list_for_workers WHERE id = ?";
$stmtOld = $conn->prepare($sqlOld);
$stmtOld->bind_param("i", $id);
$stmtOld->execute();
$stmtOld->bind_result($old_product_id, $old_detail_id);
$stmtOld->fetch();
$stmtOld->close();

// Обновляем in_list для старых значений
$updateOldProductSql = "UPDATE products SET in_list = 0 WHERE id = ?";
$updateOldProductStmt = $conn->prepare($updateOldProductSql);
$updateOldProductStmt->bind_param("i", $old_product_id);
if (!$updateOldProductStmt->execute()) {
    echo "Ошибка обновления in_list для старого продукта: " . $updateOldProductStmt->error;
}

$updateOldDetailSql = "UPDATE details SET in_list = 0 WHERE id = ?";
$updateOldDetailStmt = $conn->prepare($updateOldDetailSql);
$updateOldDetailStmt->bind_param("i", $old_detail_id);
if (!$updateOldDetailStmt->execute()) {
    echo "Ошибка обновления set_in для старой детали: " . $updateOldDetailStmt->error;
}

// Обновляем in_list для новых значений
$updateNewProductSql = "UPDATE products SET in_list = 1 WHERE id = ?";
$updateNewProductStmt = $conn->prepare($updateNewProductSql);
$updateNewProductStmt->bind_param("i", $product_id);
if (!$updateNewProductStmt->execute()) {
    echo "Ошибка обновления in_list для нового продукта: " . $updateNewProductStmt->error;
}

$updateNewDetailSql = "UPDATE details SET in_list = 1 WHERE id = ?";
$updateNewDetailStmt = $conn->prepare($updateNewDetailSql);
$updateNewDetailStmt->bind_param("i", $detail_id);
if (!$updateNewDetailStmt->execute()) {
    echo "Ошибка обновления set_in для новой детали: " . $updateNewDetailStmt->error;
}

// Обновляем list_for_workers
$sql = "UPDATE list_for_workers SET product_id = ?, detail_id = ?, priority = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $product_id, $detail_id, $priority, $id);

if ($stmt->execute()) {
    header("Location: queue_of_lists.php?success=Данные обновлены");
} else {
    header("Location: edit_lists.php?id=$id&error=Ошибка обновления: " . urlencode($stmt->error));
}
$stmt->close();
$conn->close();
?>
