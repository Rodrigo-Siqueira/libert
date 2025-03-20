<?php  
    include_once '../conexao.php';

    $id = $_POST['idProduto'];

    $sqlDelete = "DELETE FROM produtos WHERE id = :ID";
    $stmtDelete = $conexao->prepare($sqlDelete);

    $stmtDelete->bindParam(':ID', $id);


if ($stmtDelete->execute()) {
    echo json_encode(array("DELProduto" => "EXCLUIDO"));
} else {
    echo json_encode(array("DELProduto" => "ERRO"));
}
?>