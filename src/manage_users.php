<?php
require_once('db.php');

// Получаем всех пользователей из базы данных
$sql = "SELECT id, role, login FROM bez_reg";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous"
    />
    <title>Авторизация</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
      }

      body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f4f4f9;
      }

      .login-container {
        width: 100%;
        max-width: 350px;
        padding: 2rem;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
      }

      .login-container h1 {
        font-size: 1.5rem;
        color: #333333;
        margin-bottom: 1.5rem;
      }

      .login-container input[type="text"],
      .login-container input[type="password"] {
        width: 100%;
        padding: 0.8rem;
        margin-bottom: 1rem;
        border: 1px solid #dddddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        font-size: 1rem;
      }

      .login-container input[type="text"]:focus,
      .login-container input[type="password"]:focus {
        outline: none;
        border-color: #6c63ff;
        background-color: #ffffff;
      }

      .login-container button {
        width: 100%;
        padding: 0.8rem;
        background-color: #6c63ff;
        color: #ffffff;
        font-size: 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      .login-container button:hover {
        background-color: #5752d7;
      }

      .login-container p {
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #666666;
      }

      .login-container a {
        color: #6c63ff;
        text-decoration: none;
        transition: color 0.3s ease;
      }

      .login-container a:hover {
        color: #4d45b2;
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
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/registrationUsers.html">Зарегистрировать нового пользователя</a>
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
          </div>
        </div>
      </div>
    </nav>
    <div class="container mt-5">
    <h1 class="mb-4">Управление пользователями</h1>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Логин</th>
            <th>Роль</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['login'] ?></td>
                    <td><?= $row['role'] ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Редактировать</a>
                        <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Удалить пользователя?')">Удалить</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Нет пользователей</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="add_user.php" class="btn btn-success">Добавить пользователя</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
