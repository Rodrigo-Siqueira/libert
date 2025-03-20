<?php
    include_once '../conexao.php';

    $id = $_POST['idForn'];
    $nome = $_POST['nomeForn'];
    $contato = $_POST['contatoForn'];
    $cidade = $_POST['cidadeForn'];

    $sqlUpdate = "UPDATE fornecedores SET nome = :NOME, contato = :CONTATO, cidade = :CIDADE WHERE id = :ID";

    $stmtUpdate = $conexao->prepare($sqlUpdate);

    $stmtUpdate->bindParam(':ID', $id);
    $stmtUpdate->bindParam(':NOME', $nome);
    $stmtUpdate->bindParam(':CONTATO', $contato);
    $stmtUpdate->bindParam(':CIDADE', $cidade);

    if ($stmtUpdate->execute()) {
        echo json_encode(array("UPFornecedor" => "ATUALIZADO"));
    } else {
        echo json_encode(array("UPFornecedor" => "ERRO"));
    }
?>