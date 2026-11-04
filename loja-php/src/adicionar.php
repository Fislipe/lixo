<?php
require __DIR__ . '/autoload.php';

use App\Support\CarrinhoSessao;

$carrinho = new CarrinhoSessao();
$id = (int) ($_GET['id'] ?? 0);
$quantidade = (int) ($_GET['qtd'] ?? 1);

if ($id > 0) {
    $carrinho->adicionar($id, $quantidade);
}

header('Location: carrinho.php');
exit;