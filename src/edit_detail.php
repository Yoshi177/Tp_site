<?php
require_once('db.php');

// Получаем ID детали
$id = intval($_GET['id']);
$sql = "SELECT * FROM details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$detail = $result->fetch_assoc();

if (!$detail) {
    header("Location: manage_details.php?error=Деталь не найдена");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Редактировать деталь</title>
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
    <h1 class="text-center">Редактировать деталь</h1>

    <form action="update_detail_handler.php" method="post">
        <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
        <div class="mb-3">
            <label for="status" class="form-label">Состояние детали</label>
            <input type="text" class="form-control" id="status" name="status" value="<?php echo htmlspecialchars($detail['status']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
