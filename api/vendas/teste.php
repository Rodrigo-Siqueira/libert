<?php

include_once '../conexao.php';

$idVenda = 18;

$sqlVendaItem = "SELECT
    p.descricao AS produto, 
    quantidade, 
    preco_unitario, 
    descontoAplicado 
FROM vendas_itens
INNER JOIN produtos p ON id_produto = p.id
WHERE id_venda = :IDVENDA";

$stmtVendaItem = $conexao->prepare($sqlVendaItem);
$stmtVendaItem->bindValue(':IDVENDA', $idVenda);
$stmtVendaItem->execute();

$listaVendas = array();

while ($dado = $stmtVendaItem->fetch(PDO::FETCH_OBJ)) {
    $vendaItem[] = array("PRODUTO" => $dado->produto, "QUANTIDADE" => $dado->quantidade, "PRECOUN" => $dado->preco_unitario, "DESCONTO" => $dado->descontoAplicado);
}

if (empty($vendaItem)) {
    $vendaItem[] = array("PRODUTO" => "Venda sem produtos", "QUANTIDADE" => 0.00, "PRECOUN" => 0.00, "DESCONTO" => 0.00);
}

# Exibindo o JSON
echo json_encode($vendaItem);
