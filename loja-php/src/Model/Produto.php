<?php
namespace App\Model;

abstract class Produto
{
    public function __construct(
        protected ?int $id,
        protected string $nome,
        protected float $preco,
        protected int $estoque
    ) {}

    abstract public function frete(int $qtd = 1): float;

    public function total(int $qtd = 1): float
    {
        return $this->preco * $qtd + $this->frete($qtd);
    }

    public function temEstoque(int $qtd = 1): bool
    {
        return $this->estoque >= $qtd;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getPreco(): float
    {
        return $this->preco;
    }

    public function getEstoque(): int
    {
        return $this->estoque;
    }
}
