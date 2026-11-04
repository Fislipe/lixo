<?php
require __DIR__ . '/autoload.php';

use App\DAO\ProdutoDAO;
use App\Database\Conexao;

$produtos = (new ProdutoDAO(Conexao::get()))->listar();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Produtos</title>
</head>
<body>
  <h1>Produtos</h1>
  <p><a href="novo.php">+ Novo produto</a> | <a href="index.php">Voltar</a></p>
  <table border="1" cellpadding="5">
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Preço</th>
      <th>Estoque</th>
      <th>Ações</th>
    </tr>
    <?php foreach ($produtos as $produto): ?>
      <tr>
        <td><?= $produto->getId() ?></td>
        <td><?= htmlspecialchars($produto->getNome(), ENT_QUOTES, 'UTF-8') ?></td>
        <td>R$ <?= number_format($produto->getPreco(), 2, ',', '.') ?></td>
        <td><?= $produto->getEstoque() ?></td>
        <td>
          <a href="adicionar.php?id=<?= $produto->getId() ?>">Adicionar ao carrinho</a>
          <a href="editar.php?id=<?= $produto->getId() ?>">Editar</a>
          <a href="excluir.php?id=<?= $produto->getId() ?>" onclick="return confirm('Excluir este produto?')">Excluir</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
