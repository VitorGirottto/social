<?php
session_start();
require '../database/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unfollow'])) {
    $followerId = $_SESSION['user_id'];
    $followingId = $_POST['user_id'];

    $stmt = $db->prepare("SELECT * FROM followers WHERE follower_id = ? AND following_id = ?");
    $stmt->execute([$followerId, $followingId]);
    $followRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($followRecord) {
        $stmt = $db->prepare("DELETE FROM followers WHERE id = ?");
        $stmt->execute([$followRecord['id']]);
        header("Location: profile.php?user_id=$followingId");
        exit();
    } else {
        echo "Erro ao tentar deixar de seguir o usuário.";
        exit();
    }
} else {
    header("Location: profile.php");
    exit();
}
?>
