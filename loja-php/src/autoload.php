<?php

spl_autoload_register(function (string $classe): void {
    $prefixo = 'App\\';
    if (strncmp($classe, $prefixo, strlen($prefixo)) !== 0) {
        return;
    }

    $caminhoRelativo = substr($classe, strlen($prefixo));
    $arquivo = __DIR__ . '/' . str_replace('\\', '/', $caminhoRelativo) . '.php';

    if (is_file($arquivo)) {
        require_once $arquivo;
    }
});