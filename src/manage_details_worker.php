<?php
require_once('db.php');

// Получение всех деталей из базы данных
$sql = "SELECT * FROM details";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Управление деталями</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 100px; /* Для смещения элементов ниже навигационной панели */
        }
        h1 {
            margin-bottom: 20px;
            font-weight: bold;
            color: #343a40;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        table {
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/src/worker_tasks.php">Навигационная панель</a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasDarkNavbar"
            aria-controls="offcanvasDarkNavbar"
            aria-label="Переключить навигацию"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div
            class="offcanvas offcanvas-end text-bg-dark"
            tabindex="-1"
            id="offcanvasDarkNavbar"
            aria-labelledby="offcanvasDarkNavbarLabel"
        >
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Завод</h5>
                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="offcanvas"
                    aria-label="Закрыть"
                ></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="/src/manage_products_worker.php">Работа с изделием</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/src/check_lists.php">Проверить списки сборки от инженера</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/src/logout.php">Выйти</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="text-center">Каталог деталей</h1>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <!-- Таблица с деталями -->
    <table class="table table-bordered text-center">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Состояние</th>
            <th>Использовние</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <!-- <td>
                    <a href="delete_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Удалить</a>
                    <a href="edit_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Редактировать</a>
                </td> -->
                <td>
                <?php 
                // Проверяем значение поля set_in
                if ($row['set_in'] == 0) {
                    echo "Не установлена";
                } elseif ($row['set_in'] == 1) {
                    echo "Установлена";
                } else {
                    echo "Неизвестно"; // На случай, если set_in имеет неожиданное значение
                }
                ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Форма добавления детали 
    <h2 class="mt-5 text-center">Добавить новую деталь</h2>
    <form action="add_detail_handler.php" method="post" class="mt-3">
        <div class="mb-3">
            <label for="status" class="form-label">Состояние детали</label>
            <input type="text" class="form-control" id="status" name="status" placeholder="Введите состояние детали" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Добавить деталь</button>
        </div>
    </form> -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
