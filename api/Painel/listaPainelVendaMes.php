<?php

include_once '../conexao.php';

try {
    $sqlVendaMes = "SELECT SUM(valor_total) AS Venda_mes_total 
	FROM vendas 
	WHERE month(data_venda) = month(curdate()) 
		AND year(data_venda) = year(curdate())";

    $stmtVendaMes = $conexao->prepare($sqlVendaMes);
    $stmtVendaMes->execute();
    
    $vendaMes = array();

    while ($dado = $stmtVendaMes->fetch(PDO::FETCH_OBJ)) {
        $vendaMes[] = array("VENDAMES" => $dado->Venda_mes_total);
    }

    echo json_encode($vendaMes);
} catch (Exception $e) {
    echo json_encode($vendaMes[] = array("VENDAMES" => "ERRO"));
}