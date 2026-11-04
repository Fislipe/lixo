<?php
require __DIR__ . '/../autoload.php';
use App\Database\Conexao;

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = trim($_POST['nome'] ?? '');
  $preco = (float)($_POST['preco'] ?? 0);
  $estoque = (int)($_POST['estoque'] ?? 0);
  $imagem = null;

  if ($nome === '' || $preco < 0 || $estoque < 0) {
    $erro = 'Preencha os dados corretamente.';
  } elseif (!empty($_FILES['imagem']['name'])) {
    $arquivo = $_FILES['imagem'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($arquivo['tmp_name']);
    $extensoes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if ($arquivo['error'] !== UPLOAD_ERR_OK || $arquivo['size'] > 2 * 1024 * 1024 || !isset($extensoes[$mime])) {
      $erro = 'A imagem deve ser JPG, PNG ou WebP e ter no máximo 2 MB.';
    } else {
      $nomeArquivo = bin2hex(random_bytes(8)) . '.' . $extensoes[$mime];
      $destino = __DIR__ . '/../uploads/' . $nomeArquivo;
      if (!is_dir(__DIR__ . '/../uploads')) {
        mkdir(__DIR__ . '/../uploads', 0775, true);
      }
      if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
        $erro = 'Não foi possível salvar a imagem.';
      } else {
        $imagem = 'uploads/' . $nomeArquivo;
      }
    }
  }

  if ($erro === '') {
    $stmt = Conexao::get()->prepare('INSERT INTO produtos (nome, preco, estoque, imagem) VALUES (:nome, :preco, :estoque, :imagem)');
    $stmt->execute([':nome' => $nome, ':preco' => $preco, ':estoque' => $estoque, ':imagem' => $imagem]);
    header('Location: index.php');
    exit;
  }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Novo produto</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    form { max-width: 500px; }
    label { display: block; margin-top: 12px; font-weight: bold; }
    input { box-sizing: border-box; width: 100%; padding: 9px; margin-top: 5px; }
    button { margin-top: 16px; padding: 9px 14px; }
    .erro { color: #b91c1c; }
  </style>
</head>
<body>
  <h1>Novo produto</h1>
  <?php if ($erro): ?><p class="erro"><?= htmlspecialchars($erro) ?></p><?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <label>Nome</label><input name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
    <label>Imagem</label><input type="file" name="imagem" accept="image/jpeg,image/png,image/webp">
    <label>Preço</label><input name="preco" type="number" min="0" step="0.01" value="<?= htmlspecialchars($_POST['preco'] ?? '') ?>" required>
    <label>Estoque</label><input name="estoque" type="number" min="0" value="<?= htmlspecialchars($_POST['estoque'] ?? '') ?>" required>
    <button type="submit">Salvar produto</button>
    <a href="index.php">Cancelar</a>
  </form>
</body>
</html>
