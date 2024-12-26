<?php
session_start();
require '../database/db.php';
require '../feed/autenticar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $followerId = $_SESSION['user_id'];
    $followingId = $_POST['user_id'];

    if ($followerId != $followingId) {
        if (!isFollowing($followerId, $followingId, $db)) {
            followUser($followerId, $followingId, $db);
        }
    }
}

header("Location: ../profile/profile.php?user_id=" . $_POST['user_id']);
exit();

function isFollowing($followerId, $followedId, $db) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM followers WHERE follower_id = ? AND following_id = ?");
    $stmt->execute([$followerId, $followedId]);
    return $stmt->fetchColumn() > 0;
}

function followUser($followerId, $followingId, $db) {
    $stmt = $db->prepare("INSERT INTO followers (follower_id, following_id, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$followerId, $followingId]);
}
?>
