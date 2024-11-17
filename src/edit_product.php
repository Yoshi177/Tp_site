<?php
require_once('db.php');

if (!isset($_GET['id'])) {
    die("ID изделия не указан.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    die("Изделие не найдено.");
}

$product = $result->fetch_assoc();

// Получаем список всех деталей
$sql_details = "SELECT id, status FROM details";
$result_details = $conn->query($sql_details);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать изделие</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="/src/admin_panel.php">Навигационная панель</a>
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
                <a class="nav-link active" aria-current="page" href="/registrationUsers.html">Зарегистрировать нового пользователя</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/src/manage_users.php">Составить список рабочих</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/src/manage_products.php">Составить список изделий</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/src/manage_details.php">Составить список деталей</a>
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
    <h1>Редактировать изделие</h1>
    <form action="update_product.php" method="POST">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        
        <div class="mb-3">
            <label for="status" class="form-label">Состояние</label>
            <input type="text" id="status" name="status" class="form-control" value="<?= htmlspecialchars($product['status']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="detail_id" class="form-label">Применяемая деталь</label>
            <select id="detail_id" name="detail_id" class="form-control">
                <option value="" <?= $product['detail_id'] === null ? 'selected' : '' ?>>Нет детали</option>
                <?php if ($result_details->num_rows > 0): ?>
                    <?php while ($detail = $result_details->fetch_assoc()): ?>
                        <option value="<?= $detail['id'] ?>" <?= $product['detail_id'] == $detail['id'] ? 'selected' : '' ?>>
                            ID: <?= $detail['id'] ?> (<?= htmlspecialchars($detail['status']) ?>)
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="manage_products.php" class="btn btn-secondary">Отмена</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
