<?php

require_once 'classes/Produto.php';

try {
    $produtos = Produto::all();
} catch (Exception $e) {
    print $e->getMessage();
}

# Variavel que vai acumular os produtos
$itens = '';

foreach ($produtos as $produto) {
    $item = file_get_contents('html/item.html');
    $item = str_replace('{id}', $produto['id'], $item);
    $item = str_replace('{descricao}', $produto['descricao'], $item);
    $item = str_replace('{codigo_barras}', $produto['codigo_barras'], $item);
    $item = str_replace('{preco_venda}', $produto['preco_venda'], $item);
    $item = str_replace('{status}', $produto['status'], $item);

    $itens .= $item;
}

$lista = file_get_contents('html/lista_prod.html');
$lista = str_replace('{itens}', $itens, $lista);

print $lista;
