<?php

interface Pagavel {
    public function pagar(float $valor): bool;
}

class Pix implements Pagavel {
    public function pagar(float $valor):bool {
        echo "Pix de R$ $valor";
        return true;
    }
}

class Cartao implements Pagavel {
    public function pagar(float $valor):bool {
        echo "Cartao de R$ $valor";
        return true;
    }
}