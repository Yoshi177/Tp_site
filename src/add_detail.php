<?php
require_once('db.php');

$status = trim($_POST['status']);
if (empty($status)) {
    header("Location: manage_details.php?error=Состояние не может быть пустым");
    exit();
}

$sql = "INSERT INTO details (status) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $status);

if ($stmt->execute()) {
    header("Location: manage_details.php?success=Деталь добавлена");
} else {
    header("Location: manage_details.php?error=Ошибка добавления: " . $stmt->error);
}
$stmt->close();
$conn->close();
?>
