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

$user = getUserById($_SESSION['user_id'], $db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $bio = $_POST['bio'];

    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, password = ?, bio = ? WHERE id = ?");
        $stmt->execute([$name, $email, $passwordHash, $bio, $_SESSION['user_id']]);
    } else {
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, bio = ? WHERE id = ?");
        $stmt->execute([$name, $email, $bio, $_SESSION['user_id']]);
    }

    header("Location: profile.php?user_id=" . $_SESSION['user_id']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .custom-title {
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="custom-title">Editar Perfil</h2>
    <form method="post">
        <div class="form-group">
            <label class="custom-title" for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        <div class="form-group">
            <label class="custom-title" for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="form-group">
            <label class="custom-title" for="password">Senha (deixe em branco para não alterar)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label class="custom-title" for="bio">Biografia</label>
            <textarea class="form-control" id="bio" name="bio" rows="5"><?= htmlspecialchars($user['bio']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="profile.php?user_id=<?= $_SESSION['user_id'] ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
