<?php
include_once '../conexao.php';

$sqlListar = "SELECT 
    p.descricao, 
    quantidadeUnidade, 
    tipo_movimentacao, 
    DATE_FORMAT(data_movimentacao, '%d/%m/%Y %H:%i:%s') AS dataAtual
FROM 
    movimentacao_estoque 
INNER JOIN 
    produtos p ON p.id = movimentacao_estoque.id_produto 
GROUP BY 
    data_movimentacao 
ORDER BY 
    data_movimentacao DESC";

$stmtListar = $conexao->prepare($sqlListar);
$stmtListar->execute();

$movimentacao = array();

while ($dados = $stmtListar->fetch(PDO::FETCH_OBJ)) {
    $movimentacao[] = array("PRODUTO" => $dados->descricao, "QTDETOTAL" => $dados->quantidadeUnidade, "TIPOMOV" => $dados->tipo_movimentacao, "DATA" => $dados->dataAtual);
}

echo json_encode($movimentacao);
?>