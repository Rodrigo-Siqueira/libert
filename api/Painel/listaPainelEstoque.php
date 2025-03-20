<?php

include_once '../conexao.php';

try {
    $sqlValorEstoque = "SELECT SUM(precoVenda * estoque)  AS valor_estoque_total FROM produtos";

    $stmtValorEstoque = $conexao->prepare($sqlValorEstoque);
    $stmtValorEstoque->execute();

    $valorEstoque = array();

    while ($dado = $stmtValorEstoque->fetch(PDO::FETCH_OBJ)) {
        $valorEstoque[] = array("VALORTOTALESTOQUE" => $dado->valor_estoque_total);
    }

    echo json_encode($valorEstoque);

} catch (Exception $e) {
   $valorEstoque[] = array("VALORTOTALESTOQUE" => "ERRO");
    echo json_encode($valorEstoque);
}

