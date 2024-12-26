<?php
session_start();
require '../image/image.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../database/db.php';

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password']; 

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        $error = "Email já cadastrado. Por favor, use outro email.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertStmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $insertStmt->execute([$name, $email, $hashedPassword]);

        $user_id = $db->lastInsertId();

        $_SESSION['user_id'] = $user_id;

        header("Location: ../feed/feed.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<style>
        .custom-title {
            color: white;
            text-align: center;
        }
    </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="custom-title">Criar usuário</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="POST">
                <div class="form-group">
                    <label class="custom-title" for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label class="custom-title" for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label class="custom-title" for="password">Senha</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Senha" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Criar</button>
            </form>
            <div class="custom-title">
                <p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
