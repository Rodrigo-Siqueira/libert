<?php

# cria conexão com o banco de dados
$dns = array("HOST" => 'localhost', "USUARIO" => 'root', "SENHA" => '', "BANCODADOS" => 'merceariaLibert');
$conectar = mysqli_connect($dns['HOST'], $dns['USUARIO'], $dns['SENHA'], $dns['BANCODADOS']);

$sql = "SELECT id, 
            descricao,  
            codigo_barras,
            preco_venda,
            status
        FROM produtos";

$resultado = mysqli_query($conectar, $sql);

# Variavel que vai acumular os produtos
$itens = ''; 

while ($linha = mysqli_fetch_assoc($resultado)) {
    $item = file_get_contents('html/item.html');
    $item = str_replace('{id}', $linha['id'], $item);
    $item = str_replace('{descricao}', $linha['descricao'], $item);
    $item = str_replace('{codigo_barras}', $linha['codigo_barras'], $item);
    $item = str_replace('{preco_venda}', $linha['preco_venda'], $item);
    $item = str_replace('{status}', $linha['status'], $item);

    $itens .= $item;
}

$lista = file_get_contents('html/lista_prod.html');
$lista = str_replace('{itens}', $itens, $lista);

print $lista;
