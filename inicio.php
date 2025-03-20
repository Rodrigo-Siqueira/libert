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
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="material-icons">dashboard</i> Painel geral</a>
            <a href=" #" class="w3-bar-item w3-button w3-padding"><i class="material-icons">point_of_sale</i> Venda de produto</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="material-icons">storage</i> Cadastro de produtos</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="material-icons">edit_document</i> Editar produtos</a>
            <a href=" #" class="w3-bar-item w3-button w3-padding"><i class="material-icons">sell</i> lista de vendas</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="material-icons">inventory_2</i> Entrada de estoque</a>
        </div>
    </nav>
    <!-- Efeito de sobreposição ao abrir a barra lateral em telas pequenas -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- Conteúdos -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">
        <!-- Cabeçalho -->
        <header class="w3-container" style="padding-top:22px">
            <h5><strong><i class="material-icons">dashboard</i> Painel geral</strong></h5>
        </header>

        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-third w3-panel">
                <div class="w3-container w3-blue w3-padding-16 w3-card-4">
                    <div class="w3-left"><i class="material-icons w3-xxxlarge">payments</i></div>
                    <div class="w3-container">
                        <h3 style="font-size: 24px;"><strong>R$123,00</strong></h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Venda do dia</h4>
                </div>
            </div>
            <div class="w3-third w3-panel">
                <div class="w3-container w3-green w3-padding-16 w3-card-4">
                    <div class="w3-left"><i class="material-icons w3-xxxlarge">paid</i></div>
                    <div class="w3-clear"></div>
                    <div class="w3-container">
                        <h3 style="font-size: 24px;"><strong>R$123,00</strong></h3>
                    </div>
                    <h4>Venda do mês</h4>
                </div>
            </div>
            <div class="w3-third w3-panel">
                <div class="w3-container w3-text-white w3-padding-16 w3-card-4" style="background-color: #ffc107ff;">
                    <div class="w3-left"><i class="material-icons w3-xxxlarge">pallet</i></div>
                    <div class="w3-container">
                        <h3 style="font-size: 24px;"><strong>R$123,00</strong></h3>
                    </div>
                    <div class=" w3-clear"></div>
                    <h4>Produtos em estoque</h4>
                </div>
            </div>
        </div>

        <!-- Rodapé -->
        <footer class="w3-container w3-padding-16 w3-teal">
            <h4>Sistema Libert</h4>
            <p>Feito utilisando template do <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
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
