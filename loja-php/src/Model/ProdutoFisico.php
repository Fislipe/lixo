<?php
namespace App\Model;

class ProdutoFisico extends Produto
{
    public function __construct(
        ?int $id,
        string $nome,
        float $preco,
        int $estoque,
        private float $pesoKg
    ) {
        parent::__construct($id, $nome, $preco, $estoque);
    }

    public function frete(int $qtd = 1): float
    {
        return $this->pesoKg * 5 * $qtd;
    }

    public function getPesoKg(): float
    {
        return $this->pesoKg;
    }
}
