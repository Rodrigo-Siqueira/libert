<?php

require_once 'classes/Produto.php';

if (!empty($_REQUEST['action'])) {

    try {

        if ($_REQUEST['action'] == 'edit') {

            $id = $_GET['id'];
            $produto = Produto::find($id);
        } elseif ($_REQUEST['action'] == 'salvar') {

            $produto = $_POST;
            Produto::save($produto);

            print '<script>alert("Produto salvo com sucesso!");</script>';
        }
    } catch (Exception $e) {
        print $e->getMessage();
    }

} else {

    # Senão houver uma requisição action 
    $produto = [];
    $produto['id'] = '';
    $produto['descricao'] = '';
    $produto['codigo_barras'] = '';
    $produto['preco_caixa'] = '';
    $produto['preco_unitario'] = '';
    $produto['preco_venda'] = '';
    $produto['quantidade_por_caixa'] = '';
    $produto['status'] = 'Ativo';
    $produto['margem_lucro'] = '';
}

# Criar o select do status dinamicamente
$statusOptions = [];
$statusOptions['Ativo'] = '';
$statusOptions['Inativo'] = '';
$statusOptions['Excluido'] = '';

if (isset($produto['status']) && array_key_exists($produto['status'], $statusOptions)) {
    $statusOptions[$produto['status']] = 'selected';
}

// Substituir diretamente no HTML
$statusHtml = '
    <option value="Ativo" ' . $statusOptions['Ativo'] . '>Ativo</option>
    <option value="Inativo" ' . $statusOptions['Inativo'] . '>Inativo</option>
    <option value="Excluido" ' . $statusOptions['Excluido'] . '>Excluido</option>';

# Mostra todos os valores dinâmicamente no template
$form = file_get_contents('html/prod_form.html');
$form = str_replace('{id}', $produto['id'], $form);
$form = str_replace('{descricao}', $produto['descricao'], $form);
$form = str_replace('{codigo_barras}', $produto['codigo_barras'], $form);
$form = str_replace('{preco_caixa}', $produto['preco_caixa'], $form);
$form = str_replace('{preco_unitario}', $produto['preco_unitario'], $form);
$form = str_replace('{preco_venda}', $produto['preco_venda'], $form);
$form = str_replace('{quantidade_por_caixa}', $produto['quantidade_por_caixa'], $form);
$form = str_replace('{margem_lucro}', $produto['margem_lucro'], $form);
$form = str_replace('{status_options}', $statusHtml, $form);



print $form;