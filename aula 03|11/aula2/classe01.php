<?php

class Produto {
   const IMPOSTO = 0.1;
   private static int $total = 0; //compartilhar entre os objetos

   public function __construct(public string $nome) {
        self::$total++;
   }

   public static function quantidade(): int {
        return self::$total;
   }

}

new Produto("Camiseta"); new Produto("Boné");

echo Produto::quantidade(). " produtos <br>";
echo "Imposto " . Produto::IMPOSTO;




