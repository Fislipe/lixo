<?php
require __DIR__ . '/autoload.php';

use App\DAO\ProdutoDAO;
use App\Database\Conexao;
use App\Support\CarrinhoSessao;

$carrinho = new CarrinhoSessao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);

    if ($acao === 'remover') {
        $carrinho->remover($id);
    } elseif ($acao === 'atualizar') {
        $quantidade = (int) ($_POST['quantidade'] ?? 1);
        if ($quantidade > 0) {
            $_SESSION['carrinho'][$id] = $quantidade;
        }
    } elseif ($acao === 'limpar') {
        $carrinho->limpar();
    }

    header('Location: carrinho.php');
    exit;
}

$dao = new ProdutoDAO(Conexao::get());
$itens = [];
$total = 0.0;
foreach ($carrinho->itens() as $id => $quantidade) {
    $produto = $dao->buscar((int) $id);
    if (!$produto) {
        $carrinho->remover((int) $id);
        continue;
    }

    $subtotal = $produto->getPreco() * $quantidade + $produto->frete($quantidade);
    $total += $subtotal;
    $itens[] = ['produto' => $produto, 'quantidade' => $quantidade, 'subtotal' => $subtotal];
}
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Carrinho</title></head>
<body>
  <h1>Carrinho</h1>
  <p><a href="produtos.php">Continuar comprando</a></p>
  <?php if (!$itens): ?>
    <p>O carrinho está vazio.</p>
  <?php else: ?>
    <table border="1" cellpadding="5">
      <tr><th>Produto</th><th>Preço</th><th>Quantidade</th><th>Subtotal</th><th>Ação</th></tr>
      <?php foreach ($itens as $item): $produto = $item['produto']; ?>
        <tr>
          <td><?= htmlspecialchars($produto->getNome()) ?></td>
          <td>R$ <?= number_format($produto->getPreco(), 2, ',', '.') ?></td>
          <td>
            <form method="post" style="display:inline">
              <input type="hidden" name="acao" value="atualizar">
              <input type="hidden" name="id" value="<?= $produto->getId() ?>">
              <input type="number" name="quantidade" value="<?= $item['quantidade'] ?>" min="1" max="<?= $produto->getEstoque() ?>">
              <button>Atualizar</button>
            </form>
          </td>
          <td>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
          <td>
            <form method="post">
              <input type="hidden" name="acao" value="remover">
              <input type="hidden" name="id" value="<?= $produto->getId() ?>">
              <button>Remover</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
    <p><strong>Total: R$ <?= number_format($total, 2, ',', '.') ?></strong></p>
    <form method="post" style="display:inline">
      <input type="hidden" name="acao" value="limpar"><button>Limpar carrinho</button>
    </form>
    <a href="checkout.php"><button type="button">Finalizar pedido</button></a>
  <?php endif; ?>
</body>
</html>
