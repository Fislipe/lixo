<?php
namespace App\Model;

class ProdutoDigital extends Produto
{
    public function __construct(
        ?int $id,
        string $nome,
        float $preco,
        int $estoque,
        private string $link
    ) {
        parent::__construct($id, $nome, $preco, $estoque);
    }

    public function frete(int $qtd = 1): float
    {
        return 0;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getLinkDownload(): string
    {
        return $this->link;
    }
}
