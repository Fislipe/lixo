<?php
namespace App\Support;

class CarrinhoSessao {
  public function __construct() { if (session_status() === PHP_SESSION_NONE) session_start(); $_SESSION['carrinho'] ??= []; }
  public function adicionar(int $id, int $qtd = 1): void {
    $_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + $qtd;
  }
  public function remover(int $id): void { unset($_SESSION['carrinho'][$id]); }
  public function itens(): array { return $_SESSION['carrinho']; }
  public function limpar(): void { $_SESSION['carrinho'] = []; }
}