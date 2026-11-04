<?php
require 'Produto.php';
require 'Carrinho.php';

$c = new Carrinho();
$c->adicionar(new Produto(1, "Camiseta", 59.9, 10), 2);
$c->adicionar(new Produto(2, "Boné", 39.9, 5));
echo "Total: R$ " . number_format($c->total(), 2, ',', '.');