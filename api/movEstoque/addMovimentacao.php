<?php

    include_once '../conexao.php';

    $idProduto = $_POST['idProduto'];
    $qtdeDeCaixa = $_POST['qtdeDeCaixa'];
    $qtdePorCaixa = $_POST['qtdePorCaixa'];
    $tipoMovimentacao = $_POST['tipoMovimentacao']; // 'entrada' ou 'saida'
    $qtdeUnidade = $qtdeDeCaixa * $qtdePorCaixa;


    #echo "$idProduto, $qtdePorCaixa, $qtdeDeCaixa, $tipoMovimentacao";

    if ($tipoMovimentacao === "Entrada") {
        $sqlInsert = "INSERT INTO movimentacao_estoque (id_produto, quantidadeUnidade, quantidadeCaixa, tipo_movimentacao) VALUES (:IDPRODUTO, :QTDEUNIDADE, :QTDEDECAIXA, :MOVIMENTACAO)";

        $stmtInsert = $conexao->prepare($sqlInsert);
        $stmtInsert->bindParam(':IDPRODUTO', $idProduto);
        $stmtInsert->bindParam(':QTDEUNIDADE', $qtdeUnidade);
        $stmtInsert->bindParam(':QTDEDECAIXA', $qtdeDeCaixa);
        $stmtInsert->bindParam(':MOVIMENTACAO', $tipoMovimentacao);

        if ($stmtInsert->execute()) {
            echo json_encode(array("CADMovimentacao" => "OK"));
        } else {
            echo json_encode(array("CADMovimentacao" => "ERRO"));
        }

    } else {
                
        
    
    }
?>