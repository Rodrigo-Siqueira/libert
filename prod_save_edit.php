<?php

$produto = $_POST;

#var_dump($produto);

if ($produto['id']) {

    $dns = array("HOST" => 'localhost', "USUARIO" => 'root', "SENHA" => '', "BANCODADOS" => 'libertDoces');
    $conectar = mysqli_connect($dns['HOST'], $dns['USUARIO'], $dns['SENHA'], $dns['BANCODADOS']);

    $sql = "UPDATE produtos SET 
                        descricao =          '{$produto['descricao']}',
                        codBarras =          '{$produto['codBarras']}',
                        precoCompra =        '{$produto['precoCompra']}',
                        precoVenda =         '{$produto['precoVenda']}',
                        estoque =            '{$produto['estoqueFuturo']}',
                        quantidadePorCaixa = '{$produto['qtdeNaCaixa']}',
                        quantidadeDeCaixa =  '{$produto['qtdeDeCaixa']}',
                        validade =           '{$produto['dataValidade']}', 
                        dataRecebimento =    '{$produto['dataRecebimento']}',
                        status =             '{$produto['status']}',
                        margemLucro =        '{$produto['margemVenda']}'
                        WHERE id =           '{$produto['id']}'";

    $resultado = mysqli_query($conectar, $sql);

    if ($resultado) {
        print 'Produto e estoque alterados com sucesso!';
    } else {
        print "Erro editar o produto: " . mysqli_error($conectar);
    }

    mysqli_close($conectar);
}