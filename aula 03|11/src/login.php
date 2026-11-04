<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $senha = $_POST['senha'] ?? '';

  if ($email === 'admin@loja.com' && $senha === '123456') {
    session_regenerate_id(true);   // evita fixação de sessão
    $_SESSION['usuario'] = ['nome' => 'Admin', 'email' => $email];
    header('Location: painel.php'); exit;
  }
  $erro = 'Credenciais inválidas';
}
?>
<form method="post"> <input name="email"> <input name="senha" type="password"> <button>Entrar</button> </form>
