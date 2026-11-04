<?php
namespace App\DAO;

use App\Model\Pedido;
use App\Model\Produto;
use PDO;

class PedidoDAO
{
    public function __construct(private PDO $pdo) {}

    public function criar(Pedido $pedido): int
    {
        $this->pdo->beginTransaction();

        try {
            $this->pdo->exec('INSERT INTO pedidos (id) VALUES (NULL)');
            $pedidoId = (int) $this->pdo->lastInsertId();
            $stmt = $this->pdo->prepare(
                'INSERT INTO pedido_itens
                 (pedido_id, produto_id, quantidade, preco_unitario)
                 VALUES (?, ?, ?, ?)'
            );
            $estoqueStmt = $this->pdo->prepare(
                'UPDATE produtos SET estoque = estoque - ?
                 WHERE id = ? AND estoque >= ?'
            );

            foreach ($pedido->getItens() as $item) {
                /** @var Produto $produto */
                $produto = $item['produto'];
                $quantidade = $item['quantidade'];
                $produtoId = $produto->getId();

                $estoqueStmt->execute([$quantidade, $produtoId, $quantidade]);
                if ($estoqueStmt->rowCount() !== 1) {
                    throw new \RuntimeException('Estoque insuficiente para o produto #' . $produtoId);
                }

                $stmt->execute([
                    $pedidoId,
                    $produtoId,
                    $quantidade,
                    $produto->getPreco(),
                ]);
            }

            $this->pdo->commit();
            return $pedidoId;
        } catch (\Throwable $erro) {
            $this->pdo->rollBack();
            throw $erro;
        }
    }
}
