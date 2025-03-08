<?php
require_once('db.php');

$id = intval($_GET['id']);
$sql = "DELETE FROM bez_reg WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: manage_users.php?success=Пользователь удален");
} else {
    header("Location: manage_users.php?error=Ошибка удаления: " . urlencode($stmt->error));
}
$stmt->close();
$conn->close();
?>
