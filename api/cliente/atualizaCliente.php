<?php 
    require_once '../conexao.php';

    $id = $_POST['idCliente'];
    $nome = $_POST['nomeCliente'];

    $sqlUpdate = "UPDATE clientes SET nome = :NOME WHERE id = :ID";

    $stmtUpdate = $conexao->prepare($sqlUpdate);

    $stmtUpdate->bindParam(':ID', $id);
    $stmtUpdate->bindParam(':NOME', $nome);

    if ($stmtUpdate->execute()) {
        echo json_encode(array("UPCliente" => "ATUALIZADO"));
    } else {
        echo json_encode(array("UPCliente" => "ERRO"));
    }
?>