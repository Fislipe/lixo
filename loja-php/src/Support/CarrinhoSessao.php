<?php
namespace App\Support;

class CarrinhoSessao
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['carrinho'] ??= [];
    }

    public function adicionar(int $id, int $quantidade = 1): void
    {
        $quantidade = max(1, $quantidade);
        $_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + $quantidade;
    }

    public function remover(int $id): void
    {
        unset($_SESSION['carrinho'][$id]);
    }

    public function itens(): array
    {
        return $_SESSION['carrinho'];
    }

    public function limpar(): void
    {
        $_SESSION['carrinho'] = [];
    }
}
