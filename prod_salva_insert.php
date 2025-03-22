<?php
# Cria variaveis para conexão com DB
$dns = array("HOST" => 'localhost', "USUARIO" => 'root', "SENHA" => '', "BANCODADOS" => 'libertDoces');
$conectar = mysqli_connect($dns['HOST'], $dns['USUARIO'], $dns['SENHA'], $dns['BANCODADOS'],);

#Cria a variavel produto
$produto = $_POST;

#var_dump($produto);


$resultado = mysqli_query($conectar, "SELECT codBarras FROM produtos WHERE codBarras = '{$produto['codBarras']}'");

if (mysqli_num_rows($resultado) > 0) {
    print 'Produto já existe';
} else {
    $sql = "INSERT INTO produtos (descricao, 
                        codBarras, 
                        precoCompra, 
                        precoVenda, 
                        estoque,
                        quantidadePorCaixa, 
                        quantidadeDeCaixa, 
                        validade, 
                        dataRecebimento, 
                        status, 
                        margemLucro)
                    VALUES ('{$produto['descricao']}',
                        '{$produto['codBarras']}',
                        '{$produto['precoCompra']}',
                        '{$produto['precoVenda']}',
                        '{$produto['estoqueFuturo']}',
                        '{$produto['qtdeNaCaixa']}',
                        '{$produto['qtdeDeCaixa']}',
                        '{$produto['dataValidade']}',
                        '{$produto['dataRecebimento']}',
                        '{$produto['status']}',
                        '{$produto['margemVenda']}')";

    $resultado = mysqli_query($conectar, $sql);

    if ($resultado) {
        print 'Produto incluido com sucesso!';
    } else {
        print "Erro ao inserir produto: " . mysqli_error($conectar);
    }
    
    mysqli_close($conectar);
}

