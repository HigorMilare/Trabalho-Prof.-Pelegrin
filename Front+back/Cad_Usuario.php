<?php
require_once "db.php";
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = hash('sha256', $_POST['senha']);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        header("Location: Tela_Login.php");
        exit;
    } catch (PDOException $e) {
        $mensagem = "Erro ao cadastrar: e-mail já existente.";
    }
}
?> 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Gestão de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 400px;">
    <h3 class="text-center mb-4">Novo Cadastro</h3>
     <?php if ($mensagem): ?>
        <div class="alert alert-danger"><?= $mensagem ?></div>
    <?php endif; ?> 
    <form method="POST" action="Cad_Usuario.php" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>E-mail</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Cadastrar</button>
        <a href="Tela_Login.php" class="d-block text-center mt-3">Voltar ao Login</a>
    </form>
</div>
</body>
</html>