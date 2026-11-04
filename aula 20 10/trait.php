<?php

trait Loggable{
    public function log(string $msg): void {
        echo "[". static::class . "] $msg<br>";
    }
}

class Pedido {use Loggable;}
class Cliente {use Loggable;}

(new Pedido())->log("Pedido criado");
(new Cliente())->log("Cliente cadastrado");








