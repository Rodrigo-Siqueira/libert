<?php
include_once '../conexao.php';

$id = $_POST['idProduto'];
$status = $_POST['status'];
$descricao = $_POST['descricao'];
$ean = $_POST['ean'];
$validade = implode("-", array_reverse(explode("/", $_POST['validade'])));
$dataRecebimento = implode("-", array_reverse(explode("/", $_POST['dataRecebimento'])));


    $sqlUpdate = "UPDATE produtos SET   descricao = :DESCRICAO, 
                                    codBarras = :EAN,
                                    validade = :VALIDADE, 
                                    dataRecebimento = :DATARECEBIMENTO, 
                                    status = :STATUS
                                    WHERE id = :ID";

    $stmtUpdate = $conexao->prepare($sqlUpdate);

    $stmtUpdate->bindParam(':ID', $id);
    $stmtUpdate->bindParam(':DESCRICAO', $descricao);
    $stmtUpdate->bindParam(':EAN', $ean);
    $stmtUpdate->bindParam(':VALIDADE', $validade);
    $stmtUpdate->bindParam(':DATARECEBIMENTO', $dataRecebimento);
    $stmtUpdate->bindParam(':STATUS', $status);

    if ($stmtUpdate->execute()) {
        echo json_encode(array("UPProduto" => "ATUALIZADO"));
    } else {
        echo json_encode(array("UPProduto" => "ERRO"));
    }

?>