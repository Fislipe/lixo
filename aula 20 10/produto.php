```php
<?php

abstract class Produto {
    public function __construct(protected string $nome, protected float $preco) {}

    abstract public function frete(): float;

    public function total(): float {
        return $this->preco + $this->frete();
    }

    public function descricao(): string {
        return "{$this->nome}: R$ " . number_format($this->preco, 2, ',', '.');
    }
}

class ProdutoFisico extends Produto {
    public function __construct(string $nome, float $preco, protected float $pesoKg) {
        parent::__construct($nome, $preco);
    }

    public function frete(): float {
        return $this->pesoKg * 5;
    }
}

class ProdutoDigital extends Produto {
    public function __construct(string $nome, float $preco, private string $link) {
        parent::__construct($nome, $preco);
    }

    public function descricao(): string {
        return parent::descricao() . " (download)";
    }

    public function frete(): float {
        return 0;
    }
}

class ProdutoComDesconto extends ProdutoFisico {
    public function total(): float {
        return parent::total() * 0.9;
    }
}
```