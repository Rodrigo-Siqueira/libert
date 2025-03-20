<?php

include_once '../conexao.php';

try {
    $sqlVendaDia = "SELECT COALESCE(SUM(valor_total), 0) AS Venda_diaria_total 
                    FROM vendas 
                    WHERE date(data_venda) = curdate()";

    $stmtVendaDia = $conexao->prepare($sqlVendaDia);
    $stmtVendaDia->execute();

    $vendaDia = array();

    while ($dado = $stmtVendaDia->fetch(PDO::FETCH_OBJ)) {
        $vendaDia[] = array("VENDADIA" => $dado->Venda_diaria_total);
    }

    echo json_encode($vendaDia);
} catch (Exception $e) {
    echo json_encode($vendaDia[] = array("VENDADIA" => "ERRO"));
}