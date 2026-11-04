<?php

require_once 'Produto.php';
require_once 'Pagavel.php';

$itens = [
    new ProdutoFisico("Camiseta", 49.90, 0.5),
    new ProdutoDigital("Ebook PHP", 39.90, "https://example.com/ebook"),
    new ProdutoComDesconto("Mouse", 100.00, 0.3),
    new Pix(),
    new Cartao(),
    new Dinheiro(),
    new Boleto()
];

foreach ($itens as $item) {
    if ($item instanceof Produto) {
        echo $item->descricao() . "<br>";
        echo "Frete: R$ " . number_format($item->frete(), 2, ',', '.') . "<br>";
        echo "Total: R$ " . number_format($item->total(), 2, ',', '.') . "<br><br>";
    } elseif ($item instanceof Pagavel) {
        $item->pagar(100.00);
        echo "<br>";
    }
}
