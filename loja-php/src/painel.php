<?php

session_start();
if(!isset($_SESSION['usuario'])) {
    header('Location: login.php'); exit;
}

echo "ola, " . $_SESSION['usuario']['nome'];
echo "<a href='logout.php'>Sair</a>";
