<?php

class Produto {
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

    public static function save($produto) {
        $conectar = self::getConnection();

        if (empty($produto['id'])) {
            $sql = "INSERT INTO produtos (
                        descricao, 
                        codigo_barras, 
                        preco_caixa, 
                        preco_unitario, 
                        preco_venda,
                        quantidade_por_caixa, 
                        status, 
                        margem_lucro)
                    VALUES (
                        :descricao,
                        :codigo_barras,
                        :preco_caixa,
                        :preco_unitario,
                        :preco_venda,
                        :quantidade_por_caixa,
                        :status,
                        :margem_lucro)";
        } else {

            $sql = "UPDATE produtos SET 
                        descricao =            :descricao,
                        codigo_barras =        :codigo_barras,
                        preco_caixa =          :preco_caixa,
                        preco_unitario =       :preco_unitario,
                        preco_venda =          :preco_venda,
                        quantidade_por_caixa = :quantidade_por_caixa,
                        status =               :status,
                        margem_lucro =         :margem_lucro
                    WHERE id =   :id";
        }

        $stmt = $conectar->prepare($sql);

        if (!empty($produto['id'])) {
            $stmt->bindParam(':id', $produto['id']);
        }

        $stmt->bindParam(':descricao',            $produto['descricao']);
        $stmt->bindParam(':codigo_barras',        $produto['codigo_barras']);
        $stmt->bindParam(':preco_caixa',          $produto['preco_caixa']);
        $stmt->bindParam(':preco_unitario',       $produto['preco_unitario']);
        $stmt->bindParam(':preco_venda',          $produto['preco_venda']);
        $stmt->bindParam(':quantidade_por_caixa', $produto['quantidade_por_caixa']);
        $stmt->bindParam(':status',               $produto['status']);
        $stmt->bindParam(':margem_lucro',         $produto['margem_lucro']);
        $stmt->execute();
    }

    public static function find($id) {
        $conectar = self::getConnection();

        $sql =  "SELECT * FROM produtos WHERE id = :id";

        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function all() {
        $conectar = self::getConnection();

        $sql = "SELECT id, 
            descricao,  
            codigo_barras,
            preco_venda,
            status
        FROM produtos";

        $stmt  = $conectar->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}