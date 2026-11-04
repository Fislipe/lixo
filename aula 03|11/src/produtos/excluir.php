<?php
require __DIR__ . '/../autoload.php'; 
use App\Database\Conexao;

$pdo = Conexao::get();
$pdo->prepare('DELETE FROM produtos WHERE id = :id')->execute([':id' => (int)$_GET['id']]);
header('Location: index.php');
