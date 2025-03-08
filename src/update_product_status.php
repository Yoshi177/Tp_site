<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['id'];
    $approval_status = $_POST['approved'];

    // Обновление статуса одобрения в таблице products
    $sql = "UPDATE products SET approved = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $approval_status, $product_id);
        $stmt->execute();
        
        // Проверка на ошибки выполнения
        if ($stmt->error) {
            echo "Ошибка: " . $stmt->error;
        } else {
            // Перенаправление обратно на страницу с изделиями
            header('Location: tracking_construction.php');
            exit();
        }
    } else {
        echo "Ошибка подготовки запроса: " . $conn->error;
    }
}
?>
