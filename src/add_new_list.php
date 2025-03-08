<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Добавить список сборки</title>
</head>
<body>
<div class="container mt-5">
    <h1>Добавить новый список</h1>
    <form action="add_list_handler.php" method="post">
        <div class="mb-3">
            <label for="product_id" class="form-label">ID изделия</label>
            <input type="text" id="product_id" name="product_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="detail_id" class="form-label">ID детали</label>
            <input type="text" id="detail_id" name="detail_id" class="form-control" required>
        </div>
        <!-- <div class="mb-3">
            <label for="priority" class="form-label">Пароль</label>
            <input type="text" id="priority" name="password" class="form-control">
        </div> -->
        <button type="submit" class="btn btn-success">Добавить</button>
        <a href="manage_list_for_workers.php" class="btn btn-secondary">Назад</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
