<?php
require_once('db.php');

// Получение списка всех доступных деталей из базы данных
$sql = "SELECT * FROM details";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Добавить изделие</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-label {
            font-weight: bold;
        }
        
    </style>
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
            <!-- <li class="nav-item">
                <a class="nav-link active" href="/src/admin_panel.php">Панель администратора</a>
            </li>
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
              </li> -->
              <li class="nav-item">
                  <a class="nav-link text-danger" href="/src/logout.php">Выйти</a>
              </li>
            </ul> 
          </div>
        </div>
      </div>
    </nav>
<div class="container ">
    <h1>Добавить изделие</h1>

    <!-- Отображение сообщений об успехе или ошибке -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <!-- Форма добавления изделия -->
    <form action="add_product_handler.php" method="post">
        <!-- Состояние изделия -->
        <div class="mb-3">
            <label for="status" class="form-label">Состояние изделия</label>
            <input type="text" class="form-control" id="status" name="status" placeholder="Введите состояние изделия">
        </div>

        <!-- Выбор детали -->
        <!--<div class="mb-3">
            <label for="detail_id" class="form-label">Выберите деталь</label>
            <select class="form-select" id="detail_id" name="detail_id">
                <option value="" disabled selected>Выберите деталь</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo "ID: " . $row['id'] . " - Состояние: " . $row['status']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div> -->

        <!-- Кнопка отправки -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block">Добавить изделие</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
