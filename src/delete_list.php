<?php
require_once('db.php');

$id = intval($_GET['id']);

// Сначала получим product_id из таблицы list_for_workers
$sql = "SELECT product_id FROM list_for_workers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($product_id);
$stmt->fetch();
$stmt->close();

// Если product_id найден, обновим значение in_list в таблице products
if ($product_id) {
    // Обновление значения in_list в таблице products
    $sqlUpdate = "UPDATE products SET in_list = 0 WHERE id = ? AND in_list = 1";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("i", $product_id);
    $stmtUpdate->execute();
    $stmtUpdate->close();
}

$sqlDetail = "SELECT detail_id FROM list_for_workers WHERE id = ?";
$stmtDetail = $conn->prepare($sqlDetail);
$stmtDetail->bind_param("i", $id);
$stmtDetail->execute();
$stmtDetail->bind_result($detail_id);
$stmtDetail->fetch();
$stmtDetail->close();

if ($product_id) {
    // Обновление значения in_list в таблице products
    $sqlUpdatedetail = "UPDATE details SET in_list = 0 WHERE id = ? AND in_list = 1";
    $stmtUpdatedet = $conn->prepare($sqlUpdatedetail);
    $stmtUpdatedet->bind_param("i", $detail_id);
    $stmtUpdatedet->execute();
    $stmtUpdatedet->close();
}

// Удаление записи из таблицы list_for_workers
$sqlDelete = "DELETE FROM list_for_workers WHERE id = ?";
$stmtDelete = $conn->prepare($sqlDelete);
$stmtDelete->bind_param("i", $id);

if ($stmtDelete->execute()) {
    header("Location: manage_list_for_workers.php?success=Список удален");
} else {
    header("Location: manage_list_for_workers.php?error=Ошибка удаления: " . urlencode($stmtDelete->error));
}

$stmtDelete->close();
$conn->close();
?>