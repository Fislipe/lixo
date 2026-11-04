<?php
require __DIR__ . '/autoload.php';
use App\Support\CarrinhoSessao;
$c = new CarrinhoSessao();

foreach ($c->itens() as $id => $qtd) {
  echo "Produto #$id x $qtd<br>";
}


