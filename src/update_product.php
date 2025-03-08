<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']);
    $new_detail_id = isset($_POST['detail_id']) && $_POST['detail_id'] !== '' ? intval($_POST['detail_id']) : null;

    // Получаем текущую деталь, которую мы заменяем
    $current_detail_id = null;
    $current_detail_query = "SELECT detail_id FROM products WHERE id = ?";
    $current_detail_stmt = $conn->prepare($current_detail_query);
    $current_detail_stmt->bind_param("i", $id);
    $current_detail_stmt->execute();
    $current_detail_stmt->bind_result($current_detail_id);
    $current_detail_stmt->fetch();
    $current_detail_stmt->close();

    /*if ($new_detail_id === null) {
        // Проверяем значение детали из столбца set_in
        $check_detail_query = "SELECT set_in FROM details WHERE id = ?";
        $check_detail_stmt = $conn->prepare($check_detail_query);
        $check_detail_stmt->bind_param("i", $current_detail_id);
        $check_detail_stmt->execute();
        $check_detail_stmt->bind_result($set_in);
        $check_detail_stmt->fetch();
        $check_detail_stmt->close();
    
        if ($set_in === 1) {
            // Установка новой детали невозможна, потому что она уже используется в другом месте
            header("Location: manage_products_worker.php?message=Ошибка при обновлении изделия.");
            exit;
        }
    }*/

    // Обновление статуса продукта и управление деталями
    if ($new_detail_id !== null) {
        // Проверяем, имеет ли новая деталь set_in = 1
        $check_detail_query = "SELECT set_in FROM details WHERE id = ?";
        $check_detail_stmt = $conn->prepare($check_detail_query);
        $check_detail_stmt->bind_param("i", $new_detail_id);
        $check_detail_stmt->execute();
        $check_detail_stmt->bind_result($set_in_value);
        $check_detail_stmt->fetch();
        $check_detail_stmt->close();
    
        if ($set_in_value !== 1) {
            // Устанавливаем set_in = 1 для новой детали, только если он не установлен
            $update_new_detail_query = "UPDATE details SET set_in = 1 WHERE id = ?";
            $update_new_detail_stmt = $conn->prepare($update_new_detail_query);
            $update_new_detail_stmt->bind_param("i", $new_detail_id);
            $update_new_detail_stmt->execute();
            $update_new_detail_stmt->close();
    
            if ($current_detail_id !== null) {
                // Устанавливаем set_in = 0 для текущей детали
                $reset_current_detail_query = "UPDATE details SET set_in = 0 WHERE id = ?";
                $reset_current_detail_stmt = $conn->prepare($reset_current_detail_query);
                $reset_current_detail_stmt->bind_param("i", $current_detail_id);
                $reset_current_detail_stmt->execute();
                $reset_current_detail_stmt->close();
            }
        }
        else{
            header("Location: manage_products_worker.php?message=Деталь уже используется!");
            exit;
        }
    } else {
        // Если новая деталь не установлена, устанавливаем detail_id на null и set_in = 0 для текущей детали
        if ($current_detail_id !== null) {
            // Устанавливаем set_in = 0 для текущей детали
            $reset_current_detail_query = "UPDATE details SET set_in = 0 WHERE id = ?";
            $reset_current_detail_stmt = $conn->prepare($reset_current_detail_query);
            $reset_current_detail_stmt->bind_param("i", $current_detail_id);
            $reset_current_detail_stmt->execute();
            $reset_current_detail_stmt->close();
        }
    }
    
    

    // Обновление информации о продукте с использованием подготовленного выражения
    $update_product_query = "UPDATE products SET status = ?, detail_id = ? WHERE id = ?";
    $update_product_stmt = $conn->prepare($update_product_query);
    $update_product_stmt->bind_param("sii", $status, $new_detail_id, $id);
    $update_product_stmt->execute();
    $update_product_stmt->close();

    // Перенаправление после успешного обновления
    header("Location: manage_products_worker.php?message=Изделие успешно обновлено!");
    exit;
}
?>
