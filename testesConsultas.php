<?php
# cria conexão com o banco de dados

$dns = array("HOST" => 'localhost', "USUARIO" => 'root', "SENHA" => '', "BANCODADOS" => 'libertDoces');
$conectar = mysqli_connect($dns['HOST'], $dns['USUARIO'], $dns['SENHA'], $dns['BANCODADOS']);

$sql = "SELECT id AS codProduto, 
            descricao,  
            codBarras,
            precoVenda,
            estoque,
            validade,
            status
        FROM produtos";

$resultado = mysqli_query($conectar, $sql);

