<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Tela_Login.php");
    exit;
}
require_once "db.php";

$usuario_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("
    SELECT c.id as cesta_id, p.nome, p.preco 
    FROM cestas c
    JOIN produtos p ON c.produto_id = p.id
    WHERE c.usuario_id = ?
");
$stmt->execute([$usuario_id]);
$itens = $stmt->fetchAll();

$quantidade_total = count($itens);
$valor_total = 0;
foreach ($itens as $item) {
    $valor_total += $item['preco'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Cesta - Gestão de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">Sistema Gestão</a>
    <div class="navbar-nav">
        <a class="nav-link" href="Cad_Produto.php">Cadastros</a>
        <a class="nav-link" href="Area_Produto.php">Seleção de Produtos</a>
        <a class="nav-link active" href="Carrinho.php">Minha Cesta</a>
        <a class="nav-link text-danger" href="Logout.php">Sair</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Minha Cesta de Compras</h2>

    <div class="row mt-4">
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço Unitário</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($quantidade_total == 0): ?>
                        <tr><td colspan="3" class="text-center">Sua cesta está vazia.</td></tr>
                    <?php endif; ?>
                    
                    <?php foreach ($itens as $item): ?>
                    <tr>
                        <td><?= $item['nome'] ?></td>
                        <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                        <td>
                            <a href="API.php?acao=remover_cesta&id=<?= $item['cesta_id'] ?>" class="btn btn-danger btn-sm">Remover</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="col-md-4">
            <div class="card p-3 shadow-sm bg-light">
                <h4>Resumo da Cesta</h4>
                <hr>
                <p><strong>Total de itens:</strong> <?= $quantidade_total ?> unidade(s)</p>
                <p><strong>Valor Total:</strong> R$ <?= number_format($valor_total, 2, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>