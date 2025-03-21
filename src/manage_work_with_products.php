<?php
require_once('db.php');

// Получаем данные изделий
$sql = "
    SELECT p.id, p.status, p.approved, d.id AS detail_id, d.status AS detail_status
    FROM products p
    LEFT JOIN details d ON p.detail_id = d.id";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Просмотр готовности изделий</title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="/src/engineer_panel.php">Навигационная панель</a>
        <button
          class="navbar-toggler text-align: right"
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
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
              Завод
            </h5>
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
                <a class="nav-link active" aria-current="page" href="/src/queue_of_lists.php">Определение последовательности сборки</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/src/manage_work_with_products.php">Слежение за процессом сборки</a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/src/manage_list_for_workers.php">Составление списка детелей, необходимых для сборки</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/src/tracking_construction.php">Прием готовых изделий</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-danger" href="/src/logout.php">Выйти</a>
              </li>
            </ul> 
          </div>
        </div>
      </div>
    </nav>
<div class="container mt-5">
    <h1 class="mb-4">Слежение за процессом сборки</h1>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Состояние</th>
            <th>Деталь (ID)</th>
            <!--<th>Одобрено инженерами</th>
            <th>Действия</th>-->
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <?= $row['detail_id'] > 0 ? $row['detail_id'] . " (" . $row['detail_status'] . ") - Изделие готово" : ($row['detail_id'] == 0 ? "Изделие в процессе изготовления" : "Нет детали") ?>

                    </td>
                    <!-- <td style="<?= $row['approved'] === null ? 'color: red;' : ($row['approved'] == 0 ? 'color: red;' : ($row['approved'] == 1 ? 'color: green;' : ($row['approved'] == 2 ? 'color: orange;' : ''))); ?>">

                        <?php 
                        if ($row['approved'] === null || $row['approved'] == 0) {
                            echo "Не прошло проверку";
                        } else if($row['approved'] == 2){
                            echo "Не одобрено";
                        } else {
                            echo "Одобрено";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Редактировать</a>
                        <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Удалить изделие?')">Удалить</a>
                    </td> -->
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Нет изделий</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <!-- <a href="add_product.php" class="btn btn-success">Добавить изделие</a> -->
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
