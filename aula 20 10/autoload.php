<?php

spl_autoload_register(function (string $classe) {
  $prefixo = 'App\\';
  if (strncmp($classe, $prefixo, strlen($prefixo)) !== 0) return;
  $arquivo = _DIR_ . '/' . str_replace('\\', '/', substr($classe, strlen($prefixo))) . '.php';
  if (is_file($arquivo)) require $arquivo;
});