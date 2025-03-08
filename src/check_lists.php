<?php
require_once('db.php');

// Получаем всех пользователей из базы данных
$sql = "SELECT id, product_id, detail_id, priority FROM list_for_workers ORDER BY priority ASC";
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
    <title>Списки для сборки</title>
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
        <a class="navbar-brand" href="/src/worker_tasks.php">Навигационная панель</a>
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
                <a class="nav-link active" aria-current="page" href="/src/manage_details_worker.php">Работа с деталью</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/src/manage_products_worker.php">Работа с изделием</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Проверить списки сборки от инженера</a>
              </li> -->
              <li class="nav-item">
                  <a class="nav-link text-danger" href="/src/logout.php">Выйти</a>
              </li>
            </ul> 
          </div>
        </div>
      </div>
    </nav>
    <div class="container mt-5">
    <h1 class="mb-4">Списки для сборки изделий</h1>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>ID изделия</th>
            <th>ID детали, необходимой для изделия</th>
            <th>Приоритет</th>
            <!-- <th>Действия</th> -->
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['product_id'] ?></td>
                    <td><?= $row['detail_id'] ?></td>
                    <!-- <td><?= $row['priority'] ?></td> -->
                    <td style="<?= $row['priority'] === null || $row['priority'] == 0 ? 'color: red;' : ''; ?>">
                        <?php 
                        if ($row['priority'] === null || $row['priority'] == 0) {
                            echo "Приоритет не выставлен";
                        } else {
                            echo htmlspecialchars($row['priority']);
                        }
                        ?>
                    </td>
                    <!-- <td>
                         <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Редактировать</a>
                         <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Удалить пользователя?')">Удалить</a>
                    </td> -->
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Нет списков</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <!-- <a href="/src/add_new_list.php" class="btn btn-success">Добавить новый список</a> -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
