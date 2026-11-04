CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(80) NOT NULL
);

CREATE TABLE produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  descricao TEXT,
  preco DECIMAL(10,2) NOT NULL,
  estoque INT NOT NULL DEFAULT 0,
  categoria_id INT,
  tipo ENUM('fisico', 'digital') NOT NULL DEFAULT 'fisico',
  imagem VARCHAR(255) NULL,
  peso_kg DECIMAL(10,2) NULL,
  link_download VARCHAR(255) NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

INSERT INTO produtos (id, nome, preco, estoque, tipo, imagem, peso_kg, link_download) VALUES
  (2, 'camisa', 10.00, 10, 'fisico', 'https://picsum.photos/50', 0.25, NULL);