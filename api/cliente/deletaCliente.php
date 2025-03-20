<?php
    require_once '../conexao.php';

    $id = $_POST['idCliente'];

    $sqlDelete = "DELETE FROM clientes WHERE id = :ID";

    $stmtDelete = $conexao->prepare($sqlDelete);

    $stmtDelete->bindParam(':ID', $id);


    if ($stmtDelete->execute()) {
        echo json_encode(array("DELCliente" => "EXCLUIDO"));
    } else {
        echo json_encode(array("DELCliente" => "ERRO"));
    }
?>
