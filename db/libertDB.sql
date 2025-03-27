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
    compra_id INT NOT NULL, -- Relacionamento com a compra
    data_validade DATE,
    data_recebimento DATE DEFAULT CURRENT_DATE,
    quantidade INT NOT NULL DEFAULT 0,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,
    FOREIGN KEY (compra_id) REFERENCES compras(id) ON DELETE CASCADE
);

-- Tabela de Compras (Registro de compras)
CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    quantidade_caixas INT NOT NULL,
    preco_caixa DECIMAL(10,2) NOT NULL,
    custo_total DECIMAL(10,2) NOT NULL, 
    data_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

-- Tabela de Estoque (Armazena a quantidade real de cada produto)
CREATE TABLE estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 0,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

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
    descontoAplicado DECIMAL(5,2) DEFAULT 0.00,
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

-- Tabela de Movimentação de Estoque
CREATE TABLE movimentacao_estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tipo ENUM('entrada', 'saida', 'ajuste') NOT NULL,
    quantidade INT NOT NULL,
    motivo ENUM('Compra', 'Venda', 'Furto', 'Ajuste Manual', 'Outro') NOT NULL,
    data_movimentacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

-- Ideia de atualização de Compra
DELIMITER //
CREATE TRIGGER after_compra_insert
AFTER INSERT ON compras
FOR EACH ROW
BEGIN
    -- Insere se não existir ou atualiza se já existir
    INSERT INTO estoque (produto_id, quantidade)
    VALUES (NEW.produto_id, (NEW.quantidade_caixas * (SELECT quantidade_por_caixa FROM produtos WHERE id = NEW.produto_id)))
    ON DUPLICATE KEY UPDATE quantidade = quantidade + (NEW.quantidade_caixas * (SELECT quantidade_por_caixa FROM produtos WHERE id = NEW.produto_id));

    -- Registra a movimentação
    INSERT INTO movimentacao_estoque (produto_id, tipo, quantidade, motivo)
    VALUES (NEW.produto_id, 'entrada', NEW.quantidade_caixas * (SELECT quantidade_por_caixa FROM produtos WHERE id = NEW.produto_id), 'Compra');
END;
//
DELIMITER ;


-- Trigger para registrar saída de estoque ao vender
DELIMITER //
CREATE TRIGGER after_venda_item_insert
AFTER INSERT ON venda_itens
FOR EACH ROW
BEGIN
    UPDATE estoque SET quantidade = quantidade - NEW.quantidade
    WHERE produto_id = NEW.produto_id;
    
    INSERT INTO movimentacao_estoque (produto_id, tipo, quantidade, motivo)
    VALUES (NEW.produto_id, 'saida', NEW.quantidade, 'Venda');
END;//
DELIMITER ;

-- Atualizando o Trigger para Cancelamento de Vendas
DELIMITER //
CREATE TRIGGER after_venda_item_delete
AFTER DELETE ON venda_itens
FOR EACH ROW
BEGIN
    -- Restaurar o estoque
    UPDATE estoque 
    SET quantidade = quantidade + OLD.quantidade
    WHERE produto_id = OLD.produto_id;

    -- Registrar no histórico de movimentação de estoque
    INSERT INTO movimentacao_estoque (produto_id, tipo, quantidade, motivo)
    VALUES (OLD.produto_id, 'entrada', OLD.quantidade, 'Ajuste Manual');

    -- Salvar no histórico de vendas canceladas
    INSERT INTO vendas_canceladas (venda_id, produto_id, quantidade, preco_unitario, descontoAplicado)
    VALUES (OLD.venda_id, OLD.produto_id, OLD.quantidade, OLD.preco_unitario, OLD.descontoAplicado);
END;
//
DELIMITER ;