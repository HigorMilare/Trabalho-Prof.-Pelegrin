<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Tela_Login.php");
    exit;
}
require_once "db.php";

$fornecedores =$pdo->query("SELECT * FROM fornecedores")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel - Gestão de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">Sistema Gestão</a>
    <div class="navbar-nav">
        <a class="nav-link active" href="Cad_Produto.php">Cadastros</a>
        <a class="nav-link" href="Area_Produto.php">Seleção de Produtos</a>
        <a class="nav-link" href="Carrinho.php">Minha Cesta</a>
        <a class="nav-link text-danger" href="Logout.php">Sair</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Bem-vindo, <?= $_SESSION['usuario_nome'] ?></h2>
    
    <div class="row mt-4">
        <!-- Form Fornecedor -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">
                <h4>Cadastrar Fornecedor</h4>
                <form action="API.php?acao=cadastrar_fornecedor" method="POST">
                    <div class="mb-2">
                        <label>Nome do Fornecedor</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>CNPJ</label>
                        <input type="text" name="cnpj" class="form-control" required>
                    </div>
                    <button class="btn btn-primary btn-sm">Salvar Fornecedor</button>
                </form>
            </div>
        </div>

        <!-- Form Produto -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">
                <h4>Cadastrar Produto</h4>
                <form action="API.php?acao=cadastrar_produto" method="POST">
                    <div class="mb-2">
                        <label>Nome do Produto</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Preço (R$)</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Fornecedor</label>
                        <select name="fornecedor_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($fornecedores as$f): ?>
                                <option value="<?= $f['id'] ?>"><?= $f['nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-primary btn-sm">Salvar Produto</button>
                </form>
            </div>
        </div>
    </div>

    <hr>

    <div class="mt-4">
        <h3>Área de Atualização em Tempo Real</h3>
        <button onclick="carregarDadosAjax()" class="btn btn-secondary mb-3">Clique para atualizar!</button>
        
        <div class="row">
            <div class="col-md-6">
                <h5>Fornecedores Cadastrados</h5>
                <ul id="lista-fornecedores" class="list-group"></ul>
            </div>
            <div class="col-md-6">
                <h5>Produtos Cadastrados</h5>
                <ul id="lista-produtos" class="list-group"></ul>
            </div>
        </div>
    </div>
</div>

<script>
function carregarDadosAjax() {
    fetch('API.php?acao=listar_dados')
        .then(response => response.json())
        .then(data => {
            const listaF = document.getElementById('lista-fornecedores');
            const listaP = document.getElementById('lista-produtos');
            
            listaF.innerHTML = '';
            listaP.innerHTML = '';

            data.fornecedores.forEach(f => {
                listaF.innerHTML += `<li class="list-group-item">${f.nome} - CNPJ: ${f.cnpj}</li>`;
            });

            data.produtos.forEach(p => {
                listaP.innerHTML += `<li class="list-group-item">${p.nome} - R$ ${p.preco} (Fornecedor: ${p.fornecedor})</li>`;
            });
        });
}

carregarDadosAjax();
</script>
</body>
</html>