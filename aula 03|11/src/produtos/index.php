<?php
require __DIR__ . '/../autoload.php';
use App\Database\Conexao;

$produtos = Conexao::get()->query('SELECT id, nome, preco, estoque, imagem FROM produtos ORDER BY id')->fetchAll();
?>
<table border="1">
  <tr>
    <td>id</td>
    <td>foto</td>
    <td>nome</td>
    <td>preço</td>
    <td>estoque</td>
    <td>ações</td>
  </tr>
  <?php foreach ($produtos as $produto): ?>
  <tr>
    <td><?= (int)$produto['id'] ?></td>
    <td>
      <?php if (!empty($produto['imagem'])): ?>
      <img src="<?= htmlspecialchars($produto['imagem']) ?>" width="50" height="50" alt="<?= htmlspecialchars($produto['nome']) ?>">
      <?php endif; ?>
    </td>
    <td><?= htmlspecialchars($produto['nome']) ?></td>
    <td><?= number_format((float)$produto['preco'], 2, ',', '.') ?></td>
    <td><?= (int)$produto['estoque'] ?></td>
    <td>
      <a href="editar.php?id=<?= (int)$produto['id'] ?>">editar</a>
      <a href="excluir.php?id=<?= (int)$produto['id'] ?>">excluir</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
