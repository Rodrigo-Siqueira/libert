<?php
include_once '../conexao.php';

$vendaTotal = $_POST['vendaTotal'];
$idProdutos = explode(',', str_replace(['[', ']', '"'], '', $_POST['idProduto']));
$qtdeProdVendidas = explode(',', str_replace(['[', ']', '"'], '', $_POST['qtdeProduto']));
$precUnProdutos = explode(',', str_replace(['[', ']', '"'], '', $_POST['precUnProduto']));
$descProdutos = explode(',', str_replace(['[', ']', '"'], '', $_POST['descProduto']));

try {
    // Verifica se os arrays têm o mesmo tamanho
    if (!empty($idProdutos)) {

        // Adiciona a venda
        $sqlInsert = "INSERT INTO vendas (valor_total) VALUES (:VALORTOTAL)";
        $stmtInsert = $conexao->prepare($sqlInsert);
        $stmtInsert->bindValue(':VALORTOTAL', $vendaTotal);
        $stmtInsert->execute();

        $idVenda = $conexao->lastInsertId();

        // Adiciona os itens
        $sqlInsertItens = "INSERT INTO vendas_itens (id_venda, id_produto, quantidade, preco_unitario, descontoAplicado) 
                       VALUES (:IDVENDA, :IDPRODUTO, :QUANTIDADE, :PRECOUNITARIO, :DESCONTO)";

        $sqlUpdateEstoque = "UPDATE produtos SET estoque = estoque - :QUANTIDADE WHERE id = :IDPRODUTO";

        $stmtInsertItens = $conexao->prepare($sqlInsertItens);
        $stmtUpdateEstoque = $conexao->prepare($sqlUpdateEstoque);

        for ($i = 0; $i < count($idProdutos); $i++) {
            $stmtInsertItens->bindValue(':IDVENDA', $idVenda, PDO::PARAM_INT);
            $stmtInsertItens->bindValue(':IDPRODUTO', $idProdutos[$i], PDO::PARAM_INT);
            $stmtInsertItens->bindValue(':QUANTIDADE', $qtdeProdVendidas[$i], PDO::PARAM_INT);
            $stmtInsertItens->bindValue(':PRECOUNITARIO', $precUnProdutos[$i], PDO::PARAM_STR);
            $stmtInsertItens->bindValue(':DESCONTO', $descProdutos[$i], PDO::PARAM_STR);
            $stmtInsertItens->execute();

            // Atualiza o estoque
            $stmtUpdateEstoque->bindValue(':IDPRODUTO', $idProdutos[$i], PDO::PARAM_INT);
            $stmtUpdateEstoque->bindValue(':QUANTIDADE', $qtdeProdVendidas[$i], PDO::PARAM_INT);
            $stmtUpdateEstoque->execute();
        }
        
        echo json_encode(array("ADDVenda" => "OK"));
    } else {
        echo json_encode(array("ADDVenda" => "VAZIO"));
    }
    
} catch (Exception $e) {
    echo json_encode(array("ADDVenda" => "ERRO"));
}


// Verifica se os arrays têm o mesmo tamanho
if (count($idProdutos) > 0 && count($idProdutos) == count($qtdeProdVendidas) && count($idProdutos) == count($precUnProdutos) && count($idProdutos) == count($descProdutos)) {

    
    echo json_encode(array("ADDVenda" => "OK"));
} else {
    echo json_encode(array("ADDVenda" => "ERRO_VALIDADE"));
}