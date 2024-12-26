<?php
session_start();
require '../database/db.php';
require '../image/image.php';
require '../feed/autenticar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

function deleteUserById($userId, $db) {
    $stmt = $db->prepare("DELETE FROM likes WHERE user_id = ?");
    $stmt->execute([$userId]);

    $stmt = $db->prepare("DELETE FROM posts WHERE user_id = ?");
    $stmt->execute([$userId]);

    $stmt = $db->prepare("DELETE FROM profile_visits WHERE visitor_user_id = ? OR visited_user_id = ?");
    $stmt->execute([$userId, $userId]);

    $stmt = $db->prepare("DELETE FROM followers WHERE follower_id = ? OR following_id = ?");
    $stmt->execute([$userId, $userId]);

    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    deleteUserById($_SESSION['user_id'], $db);
    session_destroy();
    header("Location: ../login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deletar Perfil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .custom-title {
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="custom-title">Deletar Perfil</h2>
    <form method="post">
        <div class="alert alert-danger" role="alert">
            Tem certeza que deseja deletar sua conta? Esta ação não pode ser desfeita.
        </div>
        <button type="submit" class="btn btn-danger">Deletar Conta</button>
        <a href="profile.php?user_id=<?= $_SESSION['user_id'] ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
