<!doctype html>
<html lang="pt-BR">
<body>
<form method="post" enctype="multipart/form-data">
  <input type="file" name="foto" accept="image/jpeg,image/png,image/webp">
  <button type="submit">Enviar</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $f = $_FILES['foto'] ?? null;
  if (!$f || $f['error'] !== UPLOAD_ERR_OK) {
    exit('Falha no upload');
  }
  if ($f['size'] > 2 * 1024 * 1024) {
    exit('Máximo 2 MB');
  }

  $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
  $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? null;
  if (!$ext) {
    exit('Formato não permitido');
  }

  $diretorio = __DIR__ . '/uploads';
  if (!is_dir($diretorio) && !mkdir($diretorio, 0775, true)) {
    exit('Não foi possível criar a pasta de uploads');
  }

  $novoNome = bin2hex(random_bytes(8)) . '.' . $ext;
  $destino = $diretorio . '/' . $novoNome;
  if (!move_uploaded_file($f['tmp_name'], $destino)) {
    exit('Erro ao salvar');
  }

  echo "<p>Enviado: <a href='uploads/$novoNome'>uploads/$novoNome</a></p>";
}
?>
</body>
</html>