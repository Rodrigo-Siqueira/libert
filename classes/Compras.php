<?php

class Compras {
    private static $conectar;

    public static function getConnection() {

        if (empty(self::$conectar)) {
            $conexao = parse_ini_file('config/merceariaLibert.ini');
            $host = $conexao['host'];
            $name = $conexao['name'];
            $user = $conexao['user'];
            $pass = $conexao['pass'];

            self::$conectar =  new PDO("mysql:dbname={$name};host={$host}", $user, $pass);
            self::$conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conectar;
    }

    public static function save($listaCompra) {
        $conectar = self::getConnection();

        $sql = "INSERT INTO compras (valor_total) VALUES (:valor_total)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':valor_total', $listaCompra['totalCompra']);
        $stmt->execute();

        $id_compra = $conectar->lastInsertId();

        $itensLista = json_decode($listaCompra['itens_compra'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Erro ao decodificar JSON: " . json_last_error_msg());
        }

        foreach ($itensLista as $value) {
            $updateProduto = "UPDATE produtos SET
                                preco_caixa          = :preco_caixa,
                                preco_unitario       = :preco_unitario,
                                preco_venda          = :preco_venda,
                                quantidade_por_caixa = :quantidade_por_caixa,
                                margem_lucro         = :margem_lucro
                            WHERE id = :produto_id";

            $stmt = $conectar->prepare($updateProduto);
            $stmt->bindParam(':produto_id',           $value['id']);
            $stmt->bindParam(':preco_caixa',          $value['preco_caixa']);
            $stmt->bindParam(':preco_unitario',       $value['preco_unitario']);
            $stmt->bindParam(':preco_venda',          $value['preco_venda']);
            $stmt->bindParam(':quantidade_por_caixa', $value['quantidade_por_caixa']);
            $stmt->bindParam(':margem_lucro',         $value['margem_lucro']);
            $stmt->execute();

            $sql = "INSERT INTO compra_itens (compra_id, produto_id, quantidade_caixas, preco_caixa, custo_total) VALUES (:compra_id, :produto_id, :quantidade_caixas, :preco_caixa, :custo_total)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':compra_id',            $id_compra);
            $stmt->bindParam(':produto_id',           $value['id']);
            $stmt->bindParam(':quantidade_caixas',    $value['quantidade_de_caixa']);
            $stmt->bindParam(':preco_caixa',          $value['preco_caixa']);
            $stmt->bindParam(':custo_total',          $value['custo_total']);
            $stmt->execute();

            $quantidade = $value['quantidade_de_caixa'] * $value['quantidade_por_caixa'];
            $lote = "INSERT INTO lotes (produto_id, compra_id, data_validade, data_recebimento, quantidade) VALUES (:produto_id, :compra_id, :data_validade, :data_recebimento, :quantidade)";
            
            $stmt = $conectar->prepare($lote);
            $stmt->bindParam(':compra_id',        $id_compra);
            $stmt->bindParam(':produto_id',       $value['id']);
            $stmt->bindParam(':data_validade',    $value['dataValidade']);
            $stmt->bindParam(':data_recebimento', $value['dataRecebimento']);
            $stmt->bindParam(':quantidade',      $quantidade);
            $stmt->execute();
        }
    }

    public static function all() {
        $conectar = self::getConnection();

        $sql = "SELECT ci.compra_id AS codigo, 
                       GROUP_CONCAT(p.descricao SEPARATOR ', ') AS produtos, 
                       c.valor_total AS total, 
                       DATE(c.data_compra) AS data 
                FROM compras AS c
                JOIN compra_itens AS ci ON ci.compra_id = c.id
                JOIN produtos AS p ON p.id = ci.produto_id
                GROUP BY c.id DESC";

        $stmt  = $conectar->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
