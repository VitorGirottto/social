<?php
session_start();
require '../database/db.php';
require '../feed/autenticar.php';
require '../image/image.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_content'])) {
    $post_content = htmlspecialchars($_POST['post_content']); 
    $user_id = $_SESSION['user_id'];

    if (!empty($post_content)) {
        try {
            $stmt = $db->prepare("INSERT INTO posts (user_id, content, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$user_id, $post_content]);
            header("Location: feed.php");
            exit();
        } catch (PDOException $e) {
            echo "Erro ao publicar o post: " . $e->getMessage();
        }
    } else {
        echo "O conteúdo do post não pode estar vazio.";
    }
}

function userLikedPost($userId, $postId, $db) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$userId, $postId]);
    return $stmt->fetchColumn() > 0;
}

function countLikes($postId, $db) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
    $stmt->execute([$postId]);
    return $stmt->fetchColumn();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['like_post'])) {
    $postId = $_POST['like_post'];
    $userId = $_SESSION['user_id'];

    if (userLikedPost($userId, $postId, $db)) {
        $stmt = $db->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$userId, $postId]);
    } else {
        $stmt = $db->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
        $stmt->execute([$userId, $postId]);
    }
    header("Location: feed.php"); 
    exit();
}

$stmt = $db->prepare("SELECT p.id, p.content, p.created_at, u.name, p.user_id FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feed</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .custom-title {
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
<h2 class="custom-title">Feed</h2>
<div class="container">

    <form method="POST" class="mb-4">
        <div class="form-group">
            <label class="custom-title" for="post_content">Nova Postagem (até 100 caracteres)</label>
            <textarea class="form-control" name="post_content" id="post_content" rows="3" maxlength="100" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>

    <?php foreach ($posts as $post): ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><a href="../profile/profile.php?user_id=<?= $post['user_id'] ?>"><?= htmlspecialchars($post['name']) ?></a></h5>
            <p class="card-text"><?= htmlspecialchars($post['content']) ?></p>
            <p class="card-text"><small class="text-muted"><?= $post['created_at'] ?></small></p>
            
            <form method="POST">
                <input type="hidden" name="like_post" value="<?= $post['id'] ?>">
                <button type="submit" class="btn btn-primary">
                    <?php if (userLikedPost($_SESSION['user_id'], $post['id'], $db)): ?>
                        Descurtir
                    <?php else: ?>
                        Curtir
                    <?php endif; ?>
                </button>
            </form>
            
            <p class="card-text"><small class="text-muted"><?= countLikes($post['id'], $db) ?> curtida(s)</small></p>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="position-fixed" style="top: 10px; right: 10px;">
        <a href="../profile/profile.php?user_id=<?= $_SESSION['user_id'] ?>" class="btn btn-info mr-2">Meu Perfil</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

</div>
</body>
</html>
