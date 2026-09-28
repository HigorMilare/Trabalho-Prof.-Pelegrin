<?php
session_start();
require_once "db.php";

$acao = $_GET['acao'] ?? '';

if ($acao == 'listar_dados') {
    header('Content-Type: application/json');
    
    $fornecedores = $pdo->query("SELECT * FROM fornecedores")->fetchAll(PDO::FETCH_ASSOC);
    $produtos = $pdo->query("
        SELECT p.nome, p.preco, f.nome as fornecedor 
        FROM produtos p 
        JOIN fornecedores f ON p.fornecedor_id = f.id
    ")->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'fornecedores' => $fornecedores,
        'produtos' => $produtos
    ]);
    exit;
}

if ($acao == 'cadastrar_fornecedor' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO fornecedores (nome, cnpj) VALUES (?, ?)");
    $stmt->execute([$_POST['nome'], $_POST['cnpj']]);
    header("Location: Cad_Produto.php");
    exit;
}

if ($acao == 'cadastrar_produto' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, fornecedor_id) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['nome'], $_POST['preco'], $_POST['fornecedor_id']]);
    header("Location: Cad_Produto.php");
    exit;
}

if ($acao == 'adicionar_cesta' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $produtos = $_POST['produtos'] ?? [];

    $stmt = $pdo->prepare("INSERT INTO cestas (usuario_id, produto_id) VALUES (?, ?)");
    foreach ($produtos as $produto_id) {
        $stmt->execute([$usuario_id, $produto_id]);
    }
    header("Location: Carrinho.php");
    exit;
}

if ($acao == 'remover_cesta') {
    $cesta_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM cestas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$cesta_id, $_SESSION['usuario_id']]);
    header("Location: Carrinho.php");
    exit;
}
?>