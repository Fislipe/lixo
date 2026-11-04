<?php
require __DIR__ . '/autoload.php';

use App\DAO\PedidoDAO;
use App\DAO\ProdutoDAO;
use App\Database\Conexao;
use App\Model\Pedido;
use App\Support\CarrinhoSessao;

$carrinho = new CarrinhoSessao();
$mensagem = null;
$pedidoId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = Conexao::get();
        $produtoDAO = new ProdutoDAO($pdo);
        $pedido = new Pedido(null);

        foreach ($carrinho->itens() as $id => $quantidade) {
            $produto = $produtoDAO->buscar((int) $id);
            if (!$produto) {
                throw new RuntimeException('Produto não encontrado.');
            }
            if ($quantidade > $produto->getEstoque()) {
                throw new RuntimeException('Estoque insuficiente para ' . $produto->getNome() . '.');
            }
            $pedido->adicionar($produto, $quantidade);
        }

        if (!$pedido->getItens()) {
            throw new RuntimeException('O carrinho está vazio.');
        }

        $pedidoId = (new PedidoDAO($pdo))->criar($pedido);
        $carrinho->limpar();
        $mensagem = "Pedido #{$pedidoId} criado com sucesso!";
    } catch (Throwable $erro) {
        $mensagem = 'Erro: ' . $erro->getMessage();
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Finalizar pedido</title></head>
<body>
  <h1>Finalizar pedido</h1>
  <?php if ($mensagem): ?>
    <p><?= htmlspecialchars($mensagem) ?></p>
  <?php endif; ?>
  <?php if (!$pedidoId): ?>
    <?php if ($carrinho->itens()): ?>
      <form method="post">
        <button type="submit">Confirmar pedido</button>
        <a href="carrinho.php">Voltar ao carrinho</a>
      </form>
    <?php else: ?>
      <p>O carrinho está vazio.</p>
    <?php endif; ?>
  <?php else: ?>
    <p><a href="produtos.php">Voltar aos produtos</a></p>
  <?php endif; ?>
</body>
</html>
