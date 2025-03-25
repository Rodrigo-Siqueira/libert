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
</head>

<?php
# cria conexão com o banco de dados

$dns = array("HOST" => 'localhost', "USUARIO" => 'root', "SENHA" => '', "BANCODADOS" => 'libertDoces');
$conectar = mysqli_connect($dns['HOST'], $dns['USUARIO'], $dns['SENHA'], $dns['BANCODADOS']);

$sql = "SELECT id AS codProduto, 
            descricao,
            precoVenda
        FROM produtos";

$resultado = mysqli_query($conectar, $sql)

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

            <!-- Listagem de Vendas -->
            <div class="w3-container w3-white w3-card-4 w3-margin">
                <h2>Venda</h2>

                <!-- Lista de itens da venda -->
                <div class="w3-container w3-light-gray w3-card-4 w3-margin">
                    <div class="w3-responsive">
                        <table class="w3-table-all w3-section">
                            <tr class="w3-teal">
                                <th>Item</th>
                                <th>Quantidade</th>
                                <th>Descrição</th>
                                <th>Preço UN</th>
                                <th>Desc.</th>
                                <th>Total Venda</th>
                            </tr>

                            <?php
                            #Aqui deve ir todos os produtos adicionados ao carrinho
                            ?>
                        </table>

                    </div>
                </div>

                <!-- Adiciona o produto variveis necessarias para a venda -->
                <div class="w3-container w3-light-gray w3-card-4 w3-margin">
                    <form class="w3-container" action="">

                        <div class="w3-row-padding w3-section">
                            <label class="w3-text-teal" for="status">Selecione o produto</label>
                            <select class="w3-select w3-border" name="option">
                                <option value="" disabled selected>Selecione o produto para venda</option>
                                <?php
                                while ($linha = mysqli_fetch_assoc($resultado)) {
                                    print "<option value='{$linha['codProduto']}' data-desc='{$linha['descricao']}' data-preco='{$linha['precoVenda']}'>{$linha['descricao']}</option>\n";
                                }
                                ?>
                            </select>
                            <script>
                                document.getElementById("produtoSelect").addEventListener("change", function() {
                                    // Obtém a opção selecionada
                                    let selectedOption = this.options[this.selectedIndex];

                                    // Preenche os campos com os dados do produto selecionado
                                    document.getElementById("codProduto").value = selectedOption.value;
                                    document.getElementById("precoVenda").value = selectedOption.getAttribute("data-preco");
                                });
                            </script>
                        </div>

                        <div class="w3-row-padding w3-section">
                            <div class="w3-quarter">
                                <label class="w3-text-teal" for="codProduto">Cód</label>
                                <input class="w3-input w3-border" type="text" name="codProduto" id="codProduto"  readonly>
                            </div>
                            <div class="w3-quarter">
                                <label class="w3-text-teal" for="precoVenda">Preço UN</label>
                                <input class="w3-input w3-border" type="text" name="precoVenda" id="precoVenda"  readonly>
                            </div>
                            <div class="w3-quarter">
                                <label class="w3-text-teal" for="QtdeVenda">Quantidade</label>
                                <input class="w3-input w3-border" type="number" name="QtdeVenda" id="QtdeVenda" value="">
                            </div>
                            <div class="w3-quarter">
                                <label class="w3-text-teal" for="desconto">Desconto</label>
                                <input class="w3-input w3-border" type="number" name="desconto" id="desconto" value="">
                            </div>
                        </div>
                        <div class="w3-section">
                            <button class="w3-btn w3-section w3-teal"><i class="material-icons">add_shopping_cart</i><b>Adicionar item</b></button>
                        </div>

                    </form>
                </div>
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