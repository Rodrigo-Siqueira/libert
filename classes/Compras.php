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

    public static function save($compra) {
        $conectar = self::getConnection();

        if (empty($compra['id'])) {
            $sql = "";
        } else {

            $sql = "";
        }

        $stmt = $conectar->prepare($sql);

        if (!empty($compra['id'])) {
            $stmt->bindParam(':id', $compra['id']);
        }

        $stmt->bindParam(':descricao',            $compra['descricao']);
        $stmt->bindParam(':codigo_barras',        $compra['codigo_barras']);
        $stmt->bindParam(':preco_caixa',          $compra['preco_caixa']);
        $stmt->bindParam(':preco_unitario',       $compra['preco_unitario']);
        $stmt->bindParam(':preco_venda',          $compra['preco_venda']);
        $stmt->bindParam(':quantidade_por_caixa', $compra['quantidade_por_caixa']);
        $stmt->bindParam(':status',               $compra['status']);
        $stmt->bindParam(':margem_lucro',         $compra['margem_lucro']);
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

        $sql = "";

        $stmt  = $conectar->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
