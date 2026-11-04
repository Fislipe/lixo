<?php
namespace App\DAO;
use App\Model\{Produto, ProdutoFisico, ProdutoDigital};
use PDO;

class ProdutoDAO {
  public function __construct(private PDO $pdo) {}

  public function inserir(Produto $p): int {
    $st = $this->pdo->prepare('INSERT INTO produtos (nome,preco,estoque,tipo,peso_kg,link_download) VALUES (:n,:p,:e,:t,:w,:l)');
    $st->execute([':n'=>$p->getNome(), ':p'=>$p->getPreco(), ':e'=>$p->getEstoque(),
      ':t' => $p instanceof ProdutoDigital ? 'digital' : 'fisico',
      ':w' => $p instanceof ProdutoFisico ? $p->getPesoKg() : null,
      ':l' => $p instanceof ProdutoDigital ? $p->getLink() : null]);
    return (int)$this->pdo->lastInsertId();
  }

  public function listar(): array { return array_map([$this, 'hidratar'], $this->pdo->query('SELECT * FROM produtos ORDER BY id DESC')->fetchAll()); }

  public function hidratar(array $r): Produto {   // linha -> objeto do tipo certo (público: o PedidoDAO reutiliza)
    return $r['tipo'] === 'digital'
      ? new ProdutoDigital($r['id'], $r['nome'], (float)$r['preco'], (int)$r['estoque'], (string)$r['link_download'])
      : new ProdutoFisico($r['id'], $r['nome'], (float)$r['preco'], (int)$r['estoque'], (float)$r['peso_kg']);
  }

  public function buscar(int $id): ?Produto {
    $st = $this->pdo->prepare('SELECT * FROM produtos WHERE id = :id');
    $st->execute([':id' => $id]);
    $r = $st->fetch();
    return $r ? $this->hidratar($r) : null;
  }

  public function atualizar(Produto $p): bool {
    $st = $this->pdo->prepare('UPDATE produtos SET nome=:n, preco=:p, estoque=:e, peso_kg=:w, link_download=:l WHERE id=:id');
    return $st->execute([
        ':n'=>$p->getNome(), ':p'=>$p->getPreco(),
        ':e'=>$p->getEstoque(),
        ':w' => $p instanceof ProdutoFisico ? $p->getPesoKg() : null,
        ':l' => $p instanceof ProdutoDigital ? $p->getLink() : null, ':id'=>$p->getId()]);
  }

  public function excluir(int $id): bool {
    return $this->pdo->prepare('DELETE FROM produtos WHERE id = :id')->execute([':id' => $id]);
  }

}
