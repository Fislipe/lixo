<?php
namespace App\DAO;

use App\Database\Conexao;
use App\Model\Produto;
use App\Model\ProdutoDigital;
use App\Model\ProdutoFisico;
use PDO;

class ProdutoDAO
{
    public function __construct(private PDO $pdo) {}

    public function inserir(Produto $produto): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO produtos (nome, preco, estoque, tipo, peso_kg, link_download)
             VALUES (:nome, :preco, :estoque, :tipo, :peso, :link)'
        );
        $stmt->execute([
            ':nome' => $produto->getNome(),
            ':preco' => $produto->getPreco(),
            ':estoque' => $produto->getEstoque(),
            ':tipo' => $produto instanceof ProdutoDigital ? 'digital' : 'fisico',
            ':peso' => $produto instanceof ProdutoFisico ? $produto->getPesoKg() : null,
            ':link' => $produto instanceof ProdutoDigital ? $produto->getLinkDownload() : null,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function listar(): array
    {
        $linhas = $this->pdo
            ->query('SELECT * FROM produtos ORDER BY id DESC')
            ->fetchAll();

        return array_map(fn(array $linha) => $this->hidratar($linha), $linhas);
    }

    public function buscar(int $id): ?Produto
    {
        $stmt = $this->pdo->prepare('SELECT * FROM produtos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $linha = $stmt->fetch();

        return $linha ? $this->hidratar($linha) : null;
    }

    public function atualizar(Produto $produto): bool
    {
        if ($produto->getId() === null) {
            return false;
        }

        $stmt = $this->pdo->prepare(
            'UPDATE produtos
             SET nome = :nome, preco = :preco, estoque = :estoque,
                 tipo = :tipo, peso_kg = :peso, link_download = :link
             WHERE id = :id'
        );

        return $stmt->execute([
            ':nome' => $produto->getNome(),
            ':preco' => $produto->getPreco(),
            ':estoque' => $produto->getEstoque(),
            ':tipo' => $produto instanceof ProdutoDigital ? 'digital' : 'fisico',
            ':peso' => $produto instanceof ProdutoFisico ? $produto->getPesoKg() : null,
            ':link' => $produto instanceof ProdutoDigital ? $produto->getLinkDownload() : null,
            ':id' => $produto->getId(),
        ]);
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM produtos WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    public function hidratar(array $linha): Produto
    {
        if (($linha['tipo'] ?? 'fisico') === 'digital') {
            return new ProdutoDigital(
                (int) $linha['id'],
                $linha['nome'],
                (float) $linha['preco'],
                (int) $linha['estoque'],
                (string) ($linha['link_download'] ?? '')
            );
        }

        return new ProdutoFisico(
            (int) $linha['id'],
            $linha['nome'],
            (float) $linha['preco'],
            (int) $linha['estoque'],
            (float) ($linha['peso_kg'] ?? 0)
        );
    }

    public static function criar(): self
    {
        return new self(Conexao::get());
    }
}
