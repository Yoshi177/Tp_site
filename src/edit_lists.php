<?php
require_once('db.php');

$id = intval($_GET['id']);
$sql = "SELECT * FROM list_for_workers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$list = $result->fetch_assoc();

if (!$list) {
    die("Список не найден");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Редактировать список</title>
</head>
<body>
<div class="container mt-5">
    <h1>Редактировать список</h1>
    <form action="edit_list_handler.php" method="post">
        <input type="hidden" name="id" value="<?= $list['id'] ?>">
        <div class="mb-3">
            <label for="product_id" class="form-label">id изделия</label>
            <input type="text" id="product_id" name="product_id" class="form-control" value="<?= $list['product_id'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="detail_id" class="form-label">id детали</label>
            <input type="text" id="detail_id" name="detail_id" class="form-control" value="<?= $list['detail_id'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Приоритет сборки</label>
            <input type="text" id="priority" name="priority" class="form-control" value="<?= $list['priority'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="queue_of_lists.php" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>
