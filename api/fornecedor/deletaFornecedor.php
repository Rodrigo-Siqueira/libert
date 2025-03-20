<?php
    include_once '../conexao.php';

    $id = $_POST['idForn'];

    $sqlDelete = "DELETE FROM fornecedores WHERE id = :ID";
    $stmtDelete = $conexao->prepare($sqlDelete);

    $stmtDelete->bindParam(':ID', $id);


if ($stmtDelete->execute()) {
    echo json_encode(array("DELForn" => "EXCLUIDO"));
} else {
    echo json_encode(array("DELForn" => "ERRO"));
}
?>