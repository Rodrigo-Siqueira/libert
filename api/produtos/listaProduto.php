<?php
include_once '../conexao.php';

$sqlListar = "SELECT * FROM produtos";

$stmtListar = $conexao->prepare($sqlListar);
$stmtListar->execute();

$produtos = array();

while ($dados = $stmtListar->fetch(PDO::FETCH_OBJ)) {
    $produtos[] = array("ID" => $dados->id, "DESCRICAO" => $dados->descricao, "EAN" => $dados->codBarras, "PRECOCOMPRA" => $dados->precoCompra, "PRECOVENDA" => $dados->precoVenda, "ESTOQUE" => $dados->estoque, "QTDEPORCAIXA" => $dados->quantidadePorCaixa, "QTDEDECAIXA" => $dados->quantidadeDeCaixa, "VALIDADE" => implode("/", array_reverse(explode("-", $dados->validade))), "DATARECEBIMENTO" => implode("/", array_reverse(explode("-", $dados->dataRecebimento))), "STATUS" => $dados->status, "MARGEMVENDA" => $dados->margemLucro);
}

echo json_encode($produtos);
