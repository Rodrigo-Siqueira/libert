<?php
    require_once '../conexao.php';
    #variaveis
    $nome = $_POST['nomeCliente'];

    #verifica se tem cliente
    $sqlVerifica = "SELECT * FROM clientes WHERE nome = :NOME";
    $stmtVerifica = $conexao->prepare($sqlVerifica);

    $stmtVerifica->bindParam(':NOME', $nome);
    $stmtVerifica->execute();

    #Pega a resposta da consulta do banco e faz as verificações
    if ($stmtVerifica->rowCount() > 0) {
        echo json_encode(array("CadCliente" => "EXISTE"));
    } else {
        $sqlInsert = "INSERT INTO clientes (nome) VALUES (:NOME)";
        $stmtInsert = $conexao->prepare($sqlInsert);

        $stmtInsert->bindParam(':NOME', $nome);

        if ($stmtInsert->execute()) {
            echo json_encode(array("CadCliente" => "OK"));
        } else {
            echo json_encode(array("CadCliente" => "ERRO"));
        }
    }
?>