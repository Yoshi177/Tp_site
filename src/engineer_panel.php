<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
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
        <a class="navbar-brand" href="/dashboard.php">Навигационная панель</a>
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
                <a class="nav-link active" aria-current="page" href="#">Определение последовательности сборки</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Слежение за процессом сборки</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Составление списка детелей, необходимых для сборки</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Прием готовых изделий</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-danger" href="/src/logout.php">Выйти</a>
              </li>
            </ul> 
          </div>
        </div>
      </div>
    </nav>

    <p>Добро пожаловать, <?php echo htmlspecialchars($user['login']); ?>!</p>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>



