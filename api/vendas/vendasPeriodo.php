<?php

include_once '../conexao.php';

$dataInicio = $_POST['dataInicio'] == "Data Inicial" ? "" : implode("-", array_reverse(explode("/", $_POST['dataInicio'])));
$dataFim = $_POST['dataFim'] == "Data Final" ? "" : implode("-", array_reverse(explode("/", $_POST['dataFim'])));


try {

    if (empty($dataInicio) OR empty($dataFim)) {
        $sqlVendas = "SELECT id AS cod_venda, date(data_venda) AS data, valor_total FROM vendas ORDER BY data_venda DESC";

        $stmtVendas = $conexao->prepare($sqlVendas);
        $stmtVendas->execute();

        $listaVendas = array();

        while ($dado = $stmtVendas->fetch(PDO::FETCH_OBJ)) {
            $listaVendas[] = array("CODVENDA" => $dado->cod_venda, "DATAVENDA" => implode("/", array_reverse(explode("-", $dado->data))), "VALORVENDA" => $dado->valor_total);
        }

        
    } else {
        $sqlVendas = "SELECT id AS cod_venda, date(data_venda) AS data, valor_total 
              FROM vendas 
              WHERE date(data_venda) BETWEEN :dataInicio AND :dataFim 
              ORDER BY data_venda DESC";

        $stmtVendas = $conexao->prepare($sqlVendas);
        $stmtVendas->bindValue(':dataInicio', $dataInicio);
        $stmtVendas->bindValue(':dataFim', $dataFim);
        $stmtVendas->execute();

        $listaVendas = array();

        while ($dado = $stmtVendas->fetch(PDO::FETCH_OBJ)) {
            $listaVendas[] = array("CODVENDA" => $dado->cod_venda, "DATAVENDA" => implode("/", array_reverse(explode("-", $dado->data))), "VALORVENDA" => $dado->valor_total);
        }
    }

    if (empty($listaVendas)) {
        $listaVendas[] = array("DATAVENDA" => "Nenhuma venda encontrada no período selecionado.", "VALORVENDA" => 0.00);
    }

    echo json_encode($listaVendas);
} catch (Exception $e) {
    $listaVendas[] = array("VENDA" => "ERRO");
    echo json_encode($listaVendas);
}