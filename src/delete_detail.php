<?php
require_once('db.php');

$id = intval($_GET['id']);

// SQL-запрос для удаления
$sql = "DELETE FROM details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: manage_details.php?success=Деталь успешно удалена");
} else {
    header("Location: manage_details.php?error=Ошибка удаления: " . $stmt->error);
}


$stmt->close();
$conn->close();
?>
