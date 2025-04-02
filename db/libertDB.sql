CREATE DATABASE IF NOT EXISTS merceariaLibert;
USE merceariaLibert;

-- Tabela de Usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL, -- Melhor usar hash de senha depois
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(150) NOT NULL,
    codigo_barras CHAR(13) NOT NULL UNIQUE, -- Código de barras único
    preco_caixa DECIMAL(10,2) NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    preco_venda DECIMAL(10,2) NOT NULL,
    quantidade_por_caixa INT DEFAULT 1,
    status ENUM('Ativo', 'Inativo', 'Excluido') NOT NULL,
    margem_lucro DECIMAL(5,2) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Nova Tabela para Lotes
CREATE TABLE lotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    compra_id INT NOT NULL, 
    data_validade DATE,     
    data_recebimento DATE , 
    quantidade INT NOT NULL DEFAULT 0,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,
    FOREIGN KEY (compra_id) REFERENCES compras(id) ON DELETE CASCADE
);

-- Tabela de Compras (Registro de compras)
CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,                
    valor_total DECIMAL(10, 2) NOT NULL,
    data_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Itens Comprados em Cada Compra
CREATE TABLE compra_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compra_id INT NOT NULL,
    produto_id INT NOT NULL,              
    quantidade_caixas INT NOT NULL,       
    preco_caixa DECIMAL(10, 2) NOT NULL,  
    custo_total DECIMAL(10, 2) NOT NULL,  
    FOREIGN KEY (compra_id) REFERENCES compras(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

-- Tabela de Estoque (Armazena a quantidade real de cada produto)
CREATE TABLE estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 0,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

-- Tabela de Ajuste de Estoque
CREATE TABLE ajuste_estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo INT NOT NULL,
    descricao VARCHAR (150) NOT NULL
);

-- Tabela de Movimentação de Estoque
CREATE TABLE movimentacao_estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    ajuste_id INT NOT NULL,
    tipo ENUM('entrada', 'saida') NOT NULL,
    quantidade INT NOT NULL,
    data_movimentacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,    
    FOREIGN KEY (ajuste_id) REFERENCES ajuste_estoque(id)
);

-- Ideia de atualização de Compra
DELIMITER //
CREATE TRIGGER after_compra_item_insert
AFTER INSERT ON compra_itens
FOR EACH ROW
BEGIN
    -- Inserir ou atualizar o estoque
    INSERT INTO estoque (produto_id, quantidade)
    VALUES (NEW.produto_id, (NEW.quantidade_caixas * (SELECT quantidade_por_caixa FROM produtos WHERE id = NEW.produto_id)))
    ON DUPLICATE KEY UPDATE quantidade = quantidade + (NEW.quantidade_caixas * (SELECT quantidade_por_caixa FROM produtos WHERE id = NEW.produto_id));

    -- Registrar movimentação de estoque
    INSERT INTO movimentacao_estoque (produto_id, ajuste_id, tipo, quantidade)
    VALUES (NEW.produto_id, (SELECT id FROM ajuste_estoque WHERE descricao = 'Compra'), 'entrada', NEW.quantidade_caixas * (SELECT quantidade_por_caixa FROM produtos WHERE id = NEW.produto_id));
END;
//
DELIMITER ;

-- Tabela de Vendas
CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valor_total DECIMAL(10, 2) NOT NULL,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Itens vendidos em cada venda
CREATE TABLE venda_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    descontoAplicado DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (venda_id) REFERENCES vendas(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

-- Criando a Tabela para Histórico de Vendas Canceladas
CREATE TABLE vendas_canceladas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    descontoAplicado DECIMAL(5,2) DEFAULT 0.00,
    data_cancelamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (venda_id) REFERENCES vendas(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);


-- Trigger para registrar saída de estoque ao vender
DELIMITER //
CREATE TRIGGER after_venda_item_insert
AFTER INSERT ON venda_itens
FOR EACH ROW
BEGIN
    UPDATE estoque SET quantidade = quantidade - NEW.quantidade
    WHERE produto_id = NEW.produto_id;
    
    INSERT INTO movimentacao_estoque (produto_id, ajuste_id, tipo, quantidade)
    VALUES (NEW.produto_id, (SELECT id FROM ajuste_estoque WHERE descricao = 'Venda'), 'saida', NEW.quantidade);
END;//
DELIMITER ;

DELIMITER //
CREATE TRIGGER after_venda_item_delete
AFTER DELETE ON venda_itens
FOR EACH ROW
BEGIN
    -- Restaurar estoque
    UPDATE estoque 
    SET quantidade = quantidade + OLD.quantidade
    WHERE produto_id = OLD.produto_id;

    -- Registrar movimentação
    IF (SELECT COUNT(*) FROM ajuste_estoque WHERE descricao = 'venda cancelada') > 0 THEN
        INSERT INTO movimentacao_estoque (produto_id, ajuste_id, tipo, quantidade)
        VALUES (OLD.produto_id, (SELECT id FROM ajuste_estoque WHERE descricao = 'venda cancelada'), 'entrada', OLD.quantidade);
    END IF;

    -- Salvar no histórico de vendas canceladas
    INSERT INTO vendas_canceladas (venda_id, produto_id, quantidade, preco_unitario, descontoAplicado)
    VALUES (OLD.venda_id, OLD.produto_id, OLD.quantidade, OLD.preco_unitario, OLD.descontoAplicado);
END;
//
DELIMITER ;