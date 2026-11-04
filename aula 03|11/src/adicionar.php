<?php
require __DIR__ . '/autoload.php';

use App\Support\CarrinhoSessao;

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
    $c = new CarrinhoSessao();
    $c->adicionar((int)$_GET['id']);
}

header('Location: carrinho.php');
exit;
