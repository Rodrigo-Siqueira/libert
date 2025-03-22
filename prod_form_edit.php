<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="w3css/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        .material-icons {
            vertical-align: -20%
        }

        html,
        body,
        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: "Open Sans", sans-serif;
        }
    </style>
    <title>Libert doces</title>
    <script src="calcEstoqueEprecVenda.js"></script>
</head>

<?php
if (!empty($_GET['id'])) {

    $dns = array("HOST" => 'localhost', "USUARIO" => 'root', "SENHA" => '', "BANCODADOS" => 'libertDoces');
    $conectar = mysqli_connect($dns['HOST'], $dns['USUARIO'], $dns['SENHA'], $dns['BANCODADOS']);

    $id = $_GET['id'];

    $resultado = mysqli_query($conectar, "SELECT * FROM produtos WHERE id = '{$id}'");

    $linha = mysqli_fetch_assoc($resultado);

    $id = $linha['id'];
    $descricao = $linha['descricao'];
    $codBarras = $linha['codBarras'];
    $precoCompra = $linha['precoCompra'];
    $precoVenda = $linha['precoVenda'];
    $estoque = $linha['estoque'];
    $quantidadePorCaixa = $linha['quantidadePorCaixa'];
    $quantidadeDeCaixa = $linha['quantidadeDeCaixa'];
    $validade = $linha['validade'];
    $dataRecebimento = $linha['dataRecebimento'];
    $status = $linha['status'];
    $margemLucro = $linha['margemLucro'];
}

?>

<body class="w3-light-grey">

    <!-- Top container -->
    <div class="w3-bar w3-top w3-teal w3-large" style="z-index:4">
        <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="material-icons w3-xxlarge">menu</i></button>
        <span class="w3-bar-item w3-right">Libert Doces</span>
    </div>
    <!-- Sidebar/menu -->
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
        <div class="w3-container w3-row">
            <div class="w3-col s12">

            </div>
            <div class="w3-col s12">
                <img src="LIBERT.png" alt="img/libert Logo">

            </div>
        </div>
        <hr>
        <div class="w3-bar-block">
            <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-teal w3-hover-white" onclick="w3_close()" title="close menu">Fechar Menu <i class="material-icons">close</i></a>
            <a href="inicio.php" class="w3-bar-item w3-button w3-padding"><i class="material-icons">dashboard</i> Painel geral</a>
            <a href=" #" class="w3-bar-item w3-button w3-padding"><i class="material-icons">point_of_sale</i> Venda de produto</a>
            <a href="prod_form_insert.php" class="w3-bar-item w3-button w3-padding"><i class="material-icons">storage</i> Cadastro de produtos</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="material-icons">edit_document</i> Editar produtos</a>
            <a href=" #" class="w3-bar-item w3-button w3-padding"><i class="material-icons">sell</i> lista de vendas</a>
            <a href="lista_prod.php" class="w3-bar-item w3-button w3-padding"><i class="material-icons">view_list</i> lista produtos</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="material-icons">inventory_2</i> Entrada de estoque</a>
        </div>
    </nav>
    <!-- Efeito de sobreposição ao abrir a barra lateral em telas pequenas -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- Conteúdos -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">

        <!-- Main -->
        <div class="w3-row-padding w3-margin-bottom">

            <!-- Formulário para inclusão de produto -->
            <div class="w3-card-4 w3-white w3-margin">
                <div class="w3-container w3-teal">
                    <h2 class="w3-center">Cadastro de produtos</h2>
                </div>
                <form class="w3-container" enctype="multipart/form-data" method="post" action="prod_save_edit.php">
                    <!-- Código e status -->
                    <div class="w3-row-padding w3-section">
                        <div class="w3-half">
                            <label class="w3-text-teal" for="codigo">Código</label>
                            <input class="w3-input w3-border" type="text" name="id" value=" <?= $id ?>" readonly>
                        </div>
                        <div class="w3-half">
                            <label class="w3-text-teal" for="status">Status</label>
                            <select class="w3-select w3-border" name="status">
                                <option value=" <?= $status ?>" selected>Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Descrição e código de barras -->
                    <div class="w3-row-padding w3-section">
                        <div class="w3-half">
                            <label class="w3-text-teal" for="descricao">Descrição</label>
                            <input class="w3-input w3-border" type="text" name="descricao" value="<?= $descricao ?>">
                        </div>
                        <div class="w3-half">
                            <label class="w3-text-teal" for="codBarras">Código de barras</label>
                            <input class="w3-input w3-border" type="text" name="codBarras" value="<?= $codBarras ?>">
                        </div>
                    </div>

                    <!-- Estoque -->
                    <div class="w3-row-padding w3-section">
                        <div class="w3-half">
                            <label class="w3-text-teal" for="qtdeDeCaixa">Quantidade de caixa</label>
                            <input class="w3-input w3-border" oninput="calculaEstoque()" type="number" name="qtdeDeCaixa" id="qtdeDeCaixa" value="<?= $quantidadeDeCaixa ?>">
                        </div>
                        <div class="w3-half">
                            <label class="w3-text-teal" for="qtdeNaCaixa">Quantidade na caixa</label>
                            <input class="w3-input w3-border" oninput="calculaEstoque()" type="number" name="qtdeNaCaixa" id="qtdeNaCaixa" value="<?= $quantidadePorCaixa ?>">
                        </div>
                    </div>

                    <div class="w3-row-padding w3-section">
                        <div class="w3-half">
                            <label class="w3-text-teal" for="estoqueAtual">Estoque atual</label>
                            <input class="w3-input w3-border" oninput="calculaEstoque()" type="number" name="estoqueAtual" id="estoqueAtual" value="<?= $estoque ?>">
                        </div>
                        <div class="w3-half">
                            <label class="w3-text-teal" for="estoqueFuturo">Estoque futuro</label>
                            <input class="w3-input w3-border" type="number" name="estoqueFuturo" id="estoqueFuturo" readonly>
                        </div>
                    </div>

                    <!-- Precificação -->
                    <div class="w3-row-padding w3-section">
                        <div class="w3-half">
                            <label class="w3-text-teal" for="precoCompra">Preço de compra</label>
                            <input class="w3-input w3-border" oninput="calculaPrecoUn()" type="number" step="0.01" name="precoCompra" id="precoCompra" value="<?= $precoCompra ?>">
                        </div>
                        <div class="w3-half">
                            <label class="w3-text-teal" for="precoUnCompra">Preço Un.</label>
                            <input class="w3-input w3-border" type="number" step="0.01" name="precoUnCompra" id="precoUnCompra" readonly>
                        </div>
                    </div>

                    <div class="w3-row-padding w3-section">
                        <div class="w3-half">
                            <label class="w3-text-teal" for="margemVenda">Margem para venda (%)</label>
                            <input class="w3-input w3-border" oninput="calculaPrecoVenda()" type="number" step="0.01" name="margemVenda" id="margemVenda" value="<?= $margemLucro ?>">
                        </div>
                        <div class="w3-half">
                            <label class="w3-text-teal" for="precoVenda">Preço de venda</label>
                            <input class="w3-input w3-border" type="number" step="0.01" name="precoVenda" id="precoVenda" value="<?= $precoVenda ?>" readonly>
                        </div>
                    </div>

                    <div class="w3-row-padding w3-section">
                        <div class="w3-half">
                            <label class="w3-text-teal" for="dataValidade">Data de validade</label>
                            <input class="w3-input w3-border" type="date" name="dataValidade" value="<?= $validade ?>">
                        </div>
                        <div class="w3-half">
                            <label class="w3-text-teal" for="dataRecebimento">Data de recebimento</label>
                            <input class="w3-input w3-border" type="date" name="dataRecebimento" value="<?= $dataRecebimento ?>">
                        </div>
                    </div>

                    <div class="w3-container">
                        <input class="w3-btn w3-section w3-teal" type="submit" value="Enviar">
                    </div>
                </form>
            </div>

        </div>

        <!-- Rodapé -->
        <footer class="w3-container w3-padding-16 w3-teal">
            <h4>Sistema Libert</h4>
            <p>Feito utilizando template do <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </footer>
    </div>

    <script>
        // Aparece a Sidebar
        var mySidebar = document.getElementById("mySidebar");

        // Aparece o efeito de sobreposição da DIV
        var overlayBg = document.getElementById("myOverlay");

        // Alterne entre mostrar e ocultar a barra lateral e adicione efeito de sobreposição
        function w3_open() {
            if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
                overlayBg.style.display = "none";
            } else {
                mySidebar.style.display = 'block';
                overlayBg.style.display = "block";
            }
        }

        // Feche a barra lateral com o botão Fechar
        function w3_close() {
            mySidebar.style.display = "none";
            overlayBg.style.display = "none";
        }
    </script>

</body>

</html>