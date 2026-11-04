<?php
require __DIR__ . '/autoload.php';

use App\DAO\ProdutoDAO;
use App\Database\Conexao;
use App\Model\ProdutoDigital;
use App\Model\ProdutoFisico;

$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nome = trim($_POST['nome']);
        $preco = (float) $_POST['preco'];
        $estoque = (int) $_POST['estoque'];
        $produto = $_POST['tipo'] === 'digital'
            ? new ProdutoDigital(null, $nome, $preco, $estoque, trim($_POST['link']))
            : new ProdutoFisico(null, $nome, $preco, $estoque, (float) $_POST['peso']);

        (new ProdutoDAO(Conexao::get()))->inserir($produto);

        header('Location: produtos.php');
        exit;
    } catch (Throwable $e) {
        $erro = $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Novo produto</title></head>
<body>
  <h1>Novo produto</h1>
  <?php if ($erro): ?>
    <p style="color:red"><?= htmlspecialchars($erro) ?></p>
  <?php endif; ?>
  <form method="post">
    <label>Nome <input name="nome" required value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"></label><br><br>
    <label>Tipo
      <select name="tipo">
        <option value="fisico" <?= ($_POST['tipo'] ?? '') === 'fisico' ? 'selected' : '' ?>>Físico</option>
        <option value="digital" <?= ($_POST['tipo'] ?? '') === 'digital' ? 'selected' : '' ?>>Digital</option>
      </select>
    </label><br><br>
    <label>Peso <input name="peso" type="number" step="0.001" value="<?= htmlspecialchars($_POST['peso'] ?? '') ?>"></label><br><br>
    <label>Link <input name="link" type="text" value="<?= htmlspecialchars($_POST['link'] ?? '') ?>"></label><br><br>
    <label>Preço <input name="preco" type="number" step="0.01" required value="<?= htmlspecialchars($_POST['preco'] ?? '') ?>"></label><br><br>
    <label>Estoque <input name="estoque" type="number" required value="<?= htmlspecialchars($_POST['estoque'] ?? '') ?>"></label><br><br>
    <button type="submit">Salvar</button>
    <a href="produtos.php">Cancelar</a>
  </form>
</body>
</html>
