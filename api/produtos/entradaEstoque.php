<?php
include_once '../conexao.php';

$id = $_POST['idProduto'];
$precoCompra = $_POST['precoCompra'];
$margemVenda = $_POST['margemVenda'];
$precoVenda = $_POST['precoVenda'];
$qtdeNaCaixa = $_POST['qtdeNaCaixa'];
$qtdeDeCaixa = $_POST['qtdeDeCaixa'];
$estoque = $_POST['estoque'];
$validade = implode("-", array_reverse(explode("/", $_POST['validade'])));
$dataRecebimento = implode("-", array_reverse(explode("/", $_POST['dataRecebimento'])));

$sqlUpdate = "UPDATE produtos SET   precoCompra = :PRECOCOMPRA, 
                                    precoVenda = :PRECOVENDA, 
                                    estoque = :ESTOQUE, 
                                    quantidadePorCaixa = :QTDEPORCAIXA, 
                                    quantidadeDeCaixa = :QTDEDECAIXA, 
                                    validade = :VALIDADE, 
                                    dataRecebimento = :DATARECEBIMENTO,
                                    margemLucro = :MARGEMLUCRO
                                    WHERE id = :ID";

$stmtUpdate = $conexao->prepare($sqlUpdate);

$stmtUpdate->bindParam(':ID', $id);
$stmtUpdate->bindParam(':PRECOCOMPRA', $precoCompra);
$stmtUpdate->bindParam(':PRECOVENDA', $precoVenda);
$stmtUpdate->bindParam(':ESTOQUE', $estoque);
$stmtUpdate->bindParam(':QTDEPORCAIXA', $qtdeNaCaixa);
$stmtUpdate->bindParam(':QTDEDECAIXA', $qtdeDeCaixa);
$stmtUpdate->bindParam(':VALIDADE', $validade);
$stmtUpdate->bindParam(':DATARECEBIMENTO', $dataRecebimento);
$stmtUpdate->bindParam(':MARGEMLUCRO', $margemVenda);

if ($stmtUpdate->execute()) {
    echo json_encode(array("UPEstoque" => "ATUALIZADO"));
} else {
    echo json_encode(array("UPEstoque" => "ERRO"));
}