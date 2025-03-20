<?php 
    include_once '../conexao.php';

    $nome = $_POST['nomeForn'];
    $contato = $_POST['contatoForn'];
    $cidade = $_POST['cidadeForn'];


    $sqlVerifica = "SELECT * FROM fornecedores WHERE nome = :NOME";

    $stmtVerifica = $conexao->prepare($sqlVerifica);
    
    $stmtVerifica->bindParam(':NOME', $nome);
    $stmtVerifica->execute();

    #Pega a resposta da consulta do banco e faz as verificações
    if ($stmtVerifica->rowCount() > 0) {
        echo json_encode(array("CADForn" => "EXISTE"));
    } else {
        $sqlInsert = "INSERT INTO fornecedores (nome, contato, cidade) VALUES (:NOME, :CONTATO, :CIDADE)";
        $stmtInsert = $conexao->prepare($sqlInsert);

        $stmtInsert->bindParam(':NOME', $nome);
        $stmtInsert->bindParam(':CONTATO', $contato);
        $stmtInsert->bindParam(':CIDADE', $cidade);


        if ($stmtInsert->execute()) {
            echo json_encode(array("CADForn" => "OK"));
        } else {
            echo json_encode(array("CADForn" => "ERRO"));
        }
    }

?>