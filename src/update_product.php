<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']);
    $detail_id = isset($_POST['detail_id']) && $_POST['detail_id'] !== '' ? intval($_POST['detail_id']) : 'NULL';

    $sql = "UPDATE products SET status = '$status', detail_id = $detail_id WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_products.php?message=Изделие успешно обновлено!");
    } else {
        header("Location: manage_products.php?message=Ошибка при обновлении изделия.");
    }
    exit;
}
?>
