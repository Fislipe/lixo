#db/schema.sql
CREATE TABLE IF NOT EXISTS categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(80) NOT NULL
);

CREATE TABLE IF NOT EXISTS produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  descricao TEXT,
  preco DECIMAL(10,2) NOT NULL,
  estoque INT NOT NULL DEFAULT 0,
  tipo ENUM('fisico', 'digital') NOT NULL DEFAULT 'fisico',
  peso_kg DECIMAL(10,2) DEFAULT NULL,
  link_download VARCHAR(500) DEFAULT NULL,
  categoria_id INT,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

INSERT INTO produtos (nome, preco, estoque)
SELECT 'Notebook', 2500.00, 5
WHERE NOT EXISTS (SELECT 1 FROM produtos WHERE nome = 'Notebook');

INSERT INTO produtos (nome, preco, estoque)
SELECT 'Camiseta', 59.90, 10
WHERE NOT EXISTS (SELECT 1 FROM produtos WHERE nome = 'Camiseta');

CREATE TABLE IF NOT EXISTS pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pedido_itens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT NOT NULL,
  produto_id INT NOT NULL,
  quantidade INT NOT NULL,
  preco_unitario DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
  FOREIGN KEY (produto_id) REFERENCES produtos(id)
);
