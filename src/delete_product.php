<?php
require_once('db.php');

$id = intval($_GET['id']);
$sql = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: manage_products.php?success=Изделие удалено");
} else {
    header("Location: manage_products.php?error=Ошибка удаления: " . $stmt->error);
}


$stmt->close();
$conn->close();
?>
