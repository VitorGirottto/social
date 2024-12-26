<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../database/db.php'; 

if (!isset($_SESSION['user_id']) || !usuarioEstaAutenticado($_SESSION['user_id'], $db)) {
    header("Location: ../login/login.php"); 
    exit();
}

function usuarioEstaAutenticado($userId, $db) {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return ($user !== false);
}
?>
