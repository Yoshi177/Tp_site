<?php
require_once('db.php');

$id = intval($_POST['id']);
$role = trim($_POST['role']);
$login = trim($_POST['login']);

if (empty($role) || empty($login)) {
    header("Location: edit_user.php?id=$id&error=Заполните все поля");
    exit();
}

$sql = "UPDATE bez_reg SET role = ?, login = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $role, $login, $id);

if ($stmt->execute()) {
    header("Location: manage_users.php?success=Данные обновлены");
} else {
    header("Location: edit_user.php?id=$id&error=Ошибка обновления: " . urlencode($stmt->error));
}
$stmt->close();
$conn->close();
?>
