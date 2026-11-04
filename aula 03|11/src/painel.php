<?php

session_start();
if (!isset($_SESSION['usuario'])){
    header('Location: login.php'); exit;
}

echo "Olá, ". $_SESSION['usuario']['nome'];
echo ' <a href="sair.php">Sair</a>';