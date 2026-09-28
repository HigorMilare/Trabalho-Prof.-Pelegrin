<?php
session_start();
require_once "db.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = hash('sha256', $_POST['senha']); 

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
    $stmt->execute([$email, $senha]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header("Location: Cad_Produto.php");
        exit;
    } else {
        $mensagem = "E-mail ou senha incorretos!";
    }
}
?> 

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Gestão de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 400px;">
    <h3 class="text-center mb-4">Login no Sistema</h3>
    <?php if ($mensagem): ?>
        <div class="alert alert-danger"><?= $mensagem ?></div>
    <?php endif; ?> 
    <form method="POST" action="Tela_Login.php" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label>E-mail</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
        <a href="Cad_Usuario.php" class="d-block text-center mt-3">Criar uma conta</a>
    </form>
</div>
</body>
</html>