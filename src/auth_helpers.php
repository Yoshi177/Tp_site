<?php
function checkRole($requiredRole) {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === $requiredRole;
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}
?>
