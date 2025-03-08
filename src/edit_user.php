<?php
require_once('db.php');

$id = intval($_GET['id']);
$sql = "SELECT * FROM bez_reg WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Пользователь не найден");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Редактировать пользователя</title>
</head>
<body>
<div class="container mt-5">
    <h1>Редактировать пользователя</h1>
    <form action="edit_user_handler.php" method="post">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <div class="mb-3">
            <label for="role" class="form-label">Роль</label>
            <input type="text" id="role" name="role" class="form-control" value="<?= $user['role'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="login" class="form-label">Логин</label>
            <input type="text" id="login" name="login" class="form-control" value="<?= $user['login'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="manage_users.php" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>
