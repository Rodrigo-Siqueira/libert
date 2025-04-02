<?php
require_once 'classes/Produto.php';
require_once 'classes/Compras.php';

function listaComprasEfet() {
    try {
        $compras = Compras::all();
    } catch (Exception $e) {
        print $e->getMessage();
    }

    $itens = '';

    foreach ($compras as $compra) {
        $item = file_get_contents('html/item_compras.html');
        $item = str_replace('{id}',          $compra['codigo'], $item);
        $item = str_replace('{descricao}',   $compra['produtos'], $item);
        $item = str_replace('{valor_total}', $compra['total'], $item);
        $item = str_replace('{data}',        implode("/", array_reverse(explode("-", $compra['data']))), $item);

        $itens .= $item;
    }

    $listaCompras = file_get_contents('html/lista_compras.html');
    $listaCompras = str_replace('{itens}', $itens, $listaCompras);

    print $listaCompras;
}

try {
    $produtos = Produto::all();
} catch (Exception $e) {
    print $e->getMessage();
}

if (!empty($_REQUEST['action'])) {

    try {

        if ($_REQUEST['action'] == 'edit') {

            $id = $_GET['id'];
            
        } elseif ($_REQUEST['action'] == 'salvar') {

            $listaCompra = $_POST;
            if ($listaCompra['itens_compra'] == '') {
                print '<script>alert("Adicione um item a lista"); window.location.href = "index.php?page=compra_form";</script>';
            } else {
                Compras::save($listaCompra);
                print '<script>
                            alert("Compra adicionada com sucesso!");
                            window.location.href = "index.php"; 
                        </script>';
            }
        }
    } catch (Exception $e) {
        print $e->getMessage();
    }
} else {
    
    $itens = '';

    foreach ($produtos as $produto) {

        $itens .= "<option  value='{$produto['id']}'>{$produto['descricao']}</option>\n";
    }

    # Senão houver uma requisição action 
    $listaCompra = [];
    $listaCompra['id'] = '';
    $listaCompra['data_recebimento'] = '';
    $listaCompra['data_validade'] = '';
    $listaCompra['produto'] = $itens;
    $listaCompra['quantidade_de_caixa'] = '';
    $listaCompra['quantidade_por_caixa'] = '';
    $listaCompra['preco_caixa'] = '';
    $listaCompra['preco_unitario'] = '';
    $listaCompra['preco_venda'] = '';
    $listaCompra['margem_lucro'] = '';
    $listaCompra['custo_total'] = '';
}

$form = file_get_contents('html/compra_form.html');
$form = str_replace('{id}',                   $listaCompra['id'], $form);
$form = str_replace('{data_recebimento}',     $listaCompra['data_recebimento'], $form);
$form = str_replace('{data_validade}',        $listaCompra['data_validade'], $form);
$form = str_replace('{produto}',              $listaCompra['produto'], $form);
$form = str_replace('{quantidade_de_caixa}',  $listaCompra['quantidade_de_caixa'], $form);
$form = str_replace('{quantidade_por_caixa}', $listaCompra['quantidade_por_caixa'], $form);
$form = str_replace('{preco_caixa}',          $listaCompra['preco_caixa'], $form);
$form = str_replace('{preco_unitario}',       $listaCompra['preco_unitario'], $form);
$form = str_replace('{preco_venda}',          $listaCompra['preco_venda'], $form);
$form = str_replace('{margem_lucro}',         $listaCompra['margem_lucro'], $form);
$form = str_replace('{custo_total}',          $listaCompra['custo_total'], $form);

print $form;
$compras = listaComprasEfet();