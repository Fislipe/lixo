<?php
require __DIR__ . '/autoload.php';

use App\DAO\ProdutoDAO;
use App\Database\Conexao;

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    (new ProdutoDAO(Conexao::get()))->excluir($id);
}

header('Location: produtos.php');
exit;
