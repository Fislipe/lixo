<?php
$frutas = ["banana", "maçã", "uva"];

foreach ($frutas as $i => $fruta) {
    echo " $i - " . strtoupper($fruta) . "<br>";
}

$produto = ["nome" => "camiseta", "preco" => 49.90];
echo $produto["nome"];
$frutas[] = "manga";