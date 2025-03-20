<?php
    include_once '../conexao.php';

    $ean = $_POST['ean'];

    $sqlListar = "SELECT * FROM produtos WHERE codBarras = :EAN";

    $stmtListar = $conexao->prepare($sqlListar);
    $stmtListar->bindParam(':EAN', $ean);
    $stmtListar->execute();

    $produtos = array();

    if ($stmtListar->rowCount() > 0) {
        while ($dados = $stmtListar->fetch(PDO::FETCH_OBJ)) {
            $produtos[] = array("ID" => $dados->id, "DESCRICAO" => $dados->descricao, "EAN" => $dados->codBarras, "PRECOCOMPRA" => $dados->precoCompra, "PRECOVENDA" => $dados->precoVenda, "ESTOQUE" => $dados->estoque, "QTDEPORCAIXA" => $dados->quantidadePorCaixa, "QTDEDECAIXA" => $dados->quantidadeDeCaixa, "VALIDADE" => implode("/", array_reverse(explode("-", $dados->validade))), "DATARECEBIMENTO" => implode("/", array_reverse(explode("-", $dados->dataRecebimento))), "STATUS" => $dados->status, "MARGEMVENDA" => $dados->margemLucro);
        }
        
    } else {
        $produtos[] = array("EANerro" => "ERRO");
    }
echo json_encode($produtos);

?>