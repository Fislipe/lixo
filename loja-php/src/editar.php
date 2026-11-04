<?php
require __DIR__ . '/autoload.php';

use App\DAO\ProdutoDAO;
use App\Database\Conexao;
use App\Model\ProdutoDigital;
use App\Model\ProdutoFisico;

$dao = new ProdutoDAO(Conexao::get());
$id = (int) ($_GET['id'] ?? 0);
$produto = $dao->buscar($id);

if (!$produto) {
    http_response_code(404);
    exit('Produto não encontrado');
}

$erro = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nome = trim($_POST['nome']);
        $preco = (float) $_POST['preco'];
        $estoque = (int) $_POST['estoque'];
        $atualizado = $_POST['tipo'] === 'digital'
            ? new ProdutoDigital($id, $nome, $preco, $estoque, trim($_POST['link']))
            : new ProdutoFisico($id, $nome, $preco, $estoque, (float) $_POST['peso']);

        $dao->atualizar($atualizado);
        header('Location: produtos.php');
        exit;
    } catch (Throwable $e) {
        $erro = $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Editar produto</title></head>
<body>
  <h1>Editar produto</h1>
  <?php if ($erro): ?>
    <p style="color:red"><?= htmlspecialchars($erro) ?></p>
  <?php endif; ?>
  <form method="post">
    <label>Nome <input name="nome" required value="<?= htmlspecialchars($_POST['nome'] ?? $produto->getNome(), ENT_QUOTES, 'UTF-8') ?>"></label><br><br>
    <?php $tipoAtual = $produto instanceof ProdutoDigital ? 'digital' : 'fisico'; ?>
    <label>Tipo
      <select name="tipo">
        <option value="fisico" <?= ($_POST['tipo'] ?? $tipoAtual) === 'fisico' ? 'selected' : '' ?>>Físico</option>
        <option value="digital" <?= ($_POST['tipo'] ?? $tipoAtual) === 'digital' ? 'selected' : '' ?>>Digital</option>
      </select>
    </label><br><br>
    <label>Peso <input name="peso" type="number" step="0.001" value="<?= htmlspecialchars($_POST['peso'] ?? ($produto instanceof ProdutoFisico ? $produto->getPesoKg() : '')) ?>"></label><br><br>
    <label>Link <input name="link" type="text" value="<?= htmlspecialchars($_POST['link'] ?? ($produto instanceof ProdutoDigital ? $produto->getLinkDownload() : '')) ?>"></label><br><br>
    <label>Preço <input name="preco" type="number" step="0.01" required value="<?= htmlspecialchars($_POST['preco'] ?? $produto->getPreco()) ?>"></label><br><br>
    <label>Estoque <input name="estoque" type="number" required value="<?= htmlspecialchars($_POST['estoque'] ?? $produto->getEstoque()) ?>"></label><br><br>
    <button type="submit">Salvar</button>
    <a href="produtos.php">Cancelar</a>
  </form>
</body>
</html>
