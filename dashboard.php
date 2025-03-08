<?php
session_start();
$user = $_SESSION['user'] ?? null; // Проверка авторизации пользователя
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Форма регистрации</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Навигационная панель</a>
    <button class="navbar-toggler text-align: right" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Переключить навигацию">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Завод</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <?php if ($user): ?>
              <?php if ($user['role'] === 'admin'): ?>
                  <li class="nav-item">
                      <a class="nav-link" href="/src/admin_panel.php">Панель администратора</a>
                  </li>
              <?php elseif ($user['role'] === 'worker'): ?>
                  <li class="nav-item">
                      <a class="nav-link" href="/src/worker_tasks.php">Панель работника</a>
                  </li>
              <?php elseif ($user['role'] === 'engineer'): ?>
                  <li class="nav-item">
                      <a class="nav-link" href="/src/engineer_panel.php">Панель инженера</a>
                  </li>
              <?php endif; ?>
              <li class="nav-item">
                  <a class="nav-link text-danger" href="/src/logout.php">Выйти</a>
              </li>
          <?php else: ?>
              <li class="nav-item">
                  <a class="nav-link" href="/login.php">Войти</a>
              </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</nav>
<div class="form-container">
  <h1>Приветствуем на предприятии завода</h1>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
