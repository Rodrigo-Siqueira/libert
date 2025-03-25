<?php

if (!empty($_REQUEST['action'])) {

    # conexão com banco de dados
    $dns = array("HOST" => 'localhost', "USUARIO" => 'root', "SENHA" => '', "BANCODADOS" => 'merceariaLibert');
    $conectar = mysqli_connect($dns['HOST'], $dns['USUARIO'], $dns['SENHA'], $dns['BANCODADOS']);

    if ($_REQUEST['action'] == 'edit') {
        $id = $_GET['id'];
        $resultado = mysqli_query($conectar, "SELECT * FROM produtos WHERE id = '{$id}'");

        $produto = mysqli_fetch_assoc($resultado);
        
    } elseif ($_REQUEST['action'] == 'salvar') {

        if (empty($_POST['id'])) {
            $produto = $_POST;

            $sql = "INSERT INTO produtos (
                        descricao, 
                        codigo_barras, 
                        preco_caixa, 
                        preco_unitario, 
                        preco_venda,
                        quantidade_por_caixa, 
                        status, 
                        margem_lucro)
                    VALUES (
                        '{$produto['descricao']}',
                        '{$produto['codigo_barras']}',
                        '{$produto['preco_caixa']}',
                        '{$produto['preco_unitario']}',
                        '{$produto['preco_venda']}',
                        '{$produto['quantidade_por_caixa']}',
                        '{$produto['status']}',
                        '{$produto['margem_lucro']}')";

            $resultado = mysqli_query($conectar, $sql);
        } else {

            $sql = "UPDATE produtos SET 
                        descricao =            '{$produto['descricao']}',
                        codigo_barras =        '{$produto['codigo_barras']}',
                        preco_caixa =          '{$produto['preco_caixa']}',
                        preco_unitario =       '{$produto['preco_unitario']}',
                        preco_venda =          '{$produto['preco_venda']}',
                        quantidade_por_caixa = '{$produto['quantidade_por_caixa']}',
                        status =               '{$produto['status']}',
                        margem_lucro =         '{$produto['margem_lucro']}'
                    WHERE id =   '{$produto['id']}'";

            $resultado = mysqli_query($conectar, $sql);
        }

        print ($resultado) ? 'Registro salvo com sucesso.' : mysqli_error($conectar);
        mysqli_close($conectar);
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