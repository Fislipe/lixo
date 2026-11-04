<?php

interface Pagavel {
    public function pagar(float $valor): bool;
}

class Pix implements Pagavel {
    public function pagar(float $valor): bool {
        echo "Pagando R$ " . number_format($valor, 2, ',', '.') . " via Pix<br>";
        return true;
    }
}

class Cartao implements Pagavel {
    public function pagar(float $valor): bool {
        echo "Pagando R$ " . number_format($valor, 2, ',', '.') . " via Cartão<br>";
        return true;
    }
}

class Dinheiro implements Pagavel {
    public function pagar(float $valor): bool {
        echo "Pagando R$ " . number_format($valor, 2, ',', '.') . " em Dinheiro<br>";
        return true;
    }
}

class Boleto implements Pagavel {
    public function pagar(float $valor): bool {
        $codigo = (string) rand(1000000000, 9999999999);

        echo "Código de barras fictício: {$codigo}<br>";
        echo "Valor do boleto: R$ " . number_format($valor, 2, ',', '.') . "<br>";

        return true;
    }
}
