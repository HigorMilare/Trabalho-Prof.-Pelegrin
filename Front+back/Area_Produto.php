<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Tela_Login.php");
    exit;
}
require_once "db.php";

$produtos = $pdo->query("
    SELECT p.id, p.nome, p.preco, f.nome as fornecedor 
    FROM produtos p 
    JOIN fornecedores f ON p.fornecedor_id = f.id
")->fetchAll();
?> 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Vitrine - Gestão de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">Sistema Gestão</a>
    <div class="navbar-nav">
        <a class="nav-link" href="Cad_Produto.php">Cadastros</a>
        <a class="nav-link active" href="Area_Produto.php">Seleção de Produtos</a>
        <a class="nav-link" href="Carrinho.php">Minha Cesta</a>
        <a class="nav-link text-danger" href="Logout.php">Sair</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Selecione os Produtos para a Cesta</h2>
    <p class="text-muted">Marque pelo menos um produto para adicionar ao seu carrinho.</p>

    <form action="API.php?acao=adicionar_cesta" method="POST" onsubmit="return validarSelecao()">
        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>Selecionar</th>
                    <th>Produto</th>
                    <th>Fornecedor</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="produtos[]" value="<?= $p['id'] ?>" class="form-check-input chk-produto">
                    </td>
                    <td><?= $p['nome'] ?></td>
                    <td><?= $p['fornecedor'] ?></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <button type="submit" class="btn btn-success">Adicionar Selecionados à Cesta</button>
    </form>
</div>

<script>
function validarSelecao() {
    const checkboxes = document.querySelectorAll('.chk-produto:checked');
    if (checkboxes.length === 0) {
        alert("Por favor, selecione ao menos um produto para adicionar à cesta!");
        return false; 
    }
    return true;
}
</script>
</body>
</html>