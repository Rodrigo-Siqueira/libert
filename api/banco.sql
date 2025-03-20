CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL, -- Melhor usar hash de senha depois
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    descricao VARCHAR(150) NOT NULL,
    codBarras CHAR(13) NOT NULL UNIQUE, -- Código de barras único
    precoCompra DECIMAL(10,2),
    precoVenda DECIMAL(10,2) NOT NULL,
    estoque INT DEFAULT 0, -- Controle de estoque simplificado
    quantidadePorCaixa INT DEFAULT 1,
    quantidadeDeCaixa INT DEFAULT 1,
    validade DATE,
    dataRecebimento DATE,
    status ENUM('ativo', 'inativo') NOT NULL,
    margemLucro DECIMAL(5,2)
);

CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    valor_total DECIMAL(10, 2) NOT NULL
);

CREATE TABLE vendas_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_venda INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    descontoAplicado DECIMAL(5,2) DEFAULT 0.00,
    FOREIGN KEY (id_venda) REFERENCES vendas(id),
    FOREIGN KEY (id_produto) REFERENCES produtos(id)
);


-- Total em R$ de produtos em estoque

SELECT SUM(precoVenda * estoque)  AS valor_estoque_total FROM produtos;


-- Total em R$ de Vendas no dia

SELECT SUM(valor_total) AS Venda_diaria_total 
	FROM vendas 
    WHERE date(data_venda) = curdate();


-- Total em R$ de Vendas no Mês

SELECT SUM(valor_total) AS Venda_mes_total 
	FROM vendas 
	WHERE month(data_venda) = month(curdate()) 
		AND year(data_venda) = year(curdate());

















