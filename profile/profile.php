<?php
session_start();
require '../database/db.php';
require '../image/image.php';
require '../feed/autenticar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

function getUserById($userId, $db) {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function countProfileStats($userId, $db) {
    $stmt = $db->prepare("
        SELECT 
            (SELECT COUNT(*) FROM profile_visits WHERE visited_user_id = ?) AS profile_visits,
            (SELECT COUNT(*) FROM followers WHERE following_id = ?) AS followers_count
    ");
    $stmt->execute([$userId, $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function isFollowing($followerId, $followingId, $db) {
    $stmt = $db->prepare("SELECT * FROM followers WHERE follower_id = ? AND following_id = ?");
    $stmt->execute([$followerId, $followingId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$profileUserId = isset($_GET['user_id']) ? (int) $_GET['user_id'] : $_SESSION['user_id'];

$user = getUserById($profileUserId, $db);

$visitTime = date('Y-m-d H:i:s'); 
$stmt = $db->prepare("INSERT INTO profile_visits (visitor_user_id, visited_user_id, visit_time) VALUES (?, ?, ?)");
$stmt->execute([$_SESSION['user_id'], $profileUserId, $visitTime]);

$stats = countProfileStats($profileUserId, $db);
$profileVisits = $stats['profile_visits'];
$followersCount = $stats['followers_count'];

$isFollowing = isFollowing($_SESSION['user_id'], $profileUserId, $db);

$stmt = $db->prepare("SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id = users.id WHERE posts.user_id = ? ORDER BY posts.created_at DESC");
$stmt->execute([$profileUserId]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil de <?= htmlspecialchars($user['name']) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            color: white;
        }
        .card-body, .post-content {
            color: black;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Perfil de <?= htmlspecialchars($user['name']) ?></h2>
        </div>
        <div class="col-auto">
            <a href="../feed/feed.php" class="btn btn-secondary">Voltar</a>
            <?php if ($profileUserId == $_SESSION['user_id']): ?>
                <a href="edit_profile.php" class="btn btn-primary">Editar Perfil</a>
                <a href="delete_profile.php" class="btn btn-danger ml-2">Excluir Conta</a>
            <?php else: ?>
                <?php if ($isFollowing): ?>
                    <form action="unfollow.php" method="post" style="display: inline;">
                        <input type="hidden" name="user_id" value="<?= $profileUserId ?>">
                        <button type="submit" name="unfollow" class="btn btn-primary">Deixar de Seguir</button>
                    </form>
                <?php else: ?>
                    <form action="follow.php" method="post" style="display: inline;">
                        <input type="hidden" name="user_id" value="<?= $profileUserId ?>">
                        <button type="submit" class="btn btn-primary">Seguir</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <p>Total de visitas ao perfil: <?= $profileVisits ?></p>
    <p>Total de seguidores: <?= $followersCount ?></p>
    
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Informações do Usuário</h5>
            <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p class="card-text"><strong>Nome:</strong> <?= htmlspecialchars($user['name']) ?></p>
            <p class="card-text"><strong>Biografia:</strong><br><?= htmlspecialchars($user['bio']) ?></p>
        </div>
    </div>
    
    <h3>Postagens</h3>
    <?php foreach ($posts as $post): ?>
        <div class="card mb-3">
            <div class="card-body post-content">
                <h5 class="card-title"><?= htmlspecialchars($post['name']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($post['content']) ?></p>
                <p class="card-text"><small class="text-muted"><?= $post['created_at'] ?></small></p>
            </div>
        </div>
    <?php endforeach; ?>
    
</div>

</body>
</html>
