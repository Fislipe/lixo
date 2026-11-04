<?php
namespace App\Model;

class Pedido
{
    public function __construct(
        private ?int $id,
        private array $itens = [],
        private ?string $criadoEm = null
    ) {}

    public function adicionar(Produto $produto, int $quantidade): void
    {
        $this->itens[] = ['produto' => $produto, 'quantidade' => $quantidade];
    }

    public function getItens(): array
    {
        return $this->itens;
    }

    public function total(): float
    {
        $total = 0.0;
        foreach ($this->itens as $item) {
            $total += $item['produto']->getPreco() * $item['quantidade']
                + $item['produto']->frete($item['quantidade']);
        }
        return $total;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
