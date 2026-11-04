<?php

require __DIR__ . '/autoload.php';
use App\DAO\ProdutoDAO;
use App\Database\Conexao;

$dao = new ProdutoDAO(Conexao::get());
$diretorio = __DIR__ . '/storage';
if (!is_dir($diretorio)) {
  mkdir($diretorio, 0775, true);
}

$caminhoCsv = $diretorio . '/produtos.csv';
$f = fopen($caminhoCsv, 'w');
fputcsv($f, ['id', 'nome', 'preco'], ',', '"', '\\');
foreach ($dao->listar() as $p) {
  fputcsv($f, [$p->getId(), $p->getNome(), $p->getPreco()], ',', '"', '\\');
}
fclose($f);

$f = fopen($caminhoCsv, 'r');
if (!$f) {
  exit('Não foi possível abrir o arquivo CSV.');
}
fgetcsv($f, null, ',', '"', '\\');
while (($linha = fgetcsv($f, null, ',', '"', '\\')) !== false) {
  echo htmlspecialchars($linha[1]) . ' custa R$ ' . htmlspecialchars($linha[2]) . '<br>';
}
fclose($f);
