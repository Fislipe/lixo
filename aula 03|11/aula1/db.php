<?php

try {
    $pdo = new PDO(
        "mysql:host=db;dbname=loja;charset=utf8mb4",
        "root", "root"
    );
    echo "Conectou";
} catch (PDOException $e){
    echo "Erro: " . $e->getMessage();
}