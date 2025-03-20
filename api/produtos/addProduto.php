<?php

include_once '../conexao.php';

$status = $_POST['status'];
$descricao = $_POST['descricao'];
$ean = $_POST['ean'];
$precoCompra = $_POST['precoCompra'];
$margemVenda = $_POST['margemVenda'];
$precoVenda = $_POST['precoVenda'];
$qtdeNaCaixa = $_POST['qtdeNaCaixa'];
$qtdeDeCaixa = $_POST['qtdeDeCaixa'];
$estoque = $_POST['estoque'];
$validade = implode("-", array_reverse(explode("/", $_POST['validade'])));
$dataRecebimento = implode("-", array_reverse(explode("/", $_POST['dataRecebimento'])));

#echo "$status,$descricao, $ean, $precoCompra, $margemVenda, $precoVenda, $qtdeNaCaixa, $qtdeDeCaixa, $estoque, $validade, $dataRecebimento";

$sqlVerifica = "SELECT * FROM produtos WHERE codBarras = :EAN";

$stmtVerfica = $conexao->prepare($sqlVerifica);
$stmtVerfica->bindParam(':EAN', $ean);
$stmtVerfica->execute();

if ($stmtVerfica->rowCount() > 0) {
    echo json_encode(array("CADProduto" => "EXISTE"));
} else {

    $sqlInsert = "INSERT INTO produtos (descricao, codBarras, precoCompra, precoVenda, estoque, quantidadePorCaixa, quantidadeDeCaixa, validade, dataRecebimento, status, margemLucro) VALUES (:DESCRICAO, :EAN, :PRECOCOMPRA, :PRECOVENDA, :ESTOQUE, :QTDEPORCAIXA, :QTDEDECAIXA, :VALIDADE, :DATARECEBIMENTO, :STATUS, :MARGEMLUCRO)";

    $stmtInsert = $conexao->prepare($sqlInsert);

    $stmtInsert->bindParam(':DESCRICAO', $descricao);
    $stmtInsert->bindParam(':EAN', $ean);
    $stmtInsert->bindParam(':PRECOCOMPRA', $precoCompra);
    $stmtInsert->bindParam(':PRECOVENDA', $precoVenda);
    $stmtInsert->bindParam(':ESTOQUE', $estoque);
    $stmtInsert->bindParam(':QTDEPORCAIXA', $qtdeNaCaixa);
    $stmtInsert->bindParam(':QTDEDECAIXA', $qtdeDeCaixa);
    $stmtInsert->bindParam(':VALIDADE', $validade);
    $stmtInsert->bindParam(':DATARECEBIMENTO', $dataRecebimento);
    $stmtInsert->bindParam(':STATUS', $status);
    $stmtInsert->bindParam(':MARGEMLUCRO', $margemVenda);

    if ($stmtInsert->execute()) {
        echo json_encode(array("CADProduto" => "OK"));
    } else {
        echo json_encode(array("CADProduto" => "ERRO"));
    }
}