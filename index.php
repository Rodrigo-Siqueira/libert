<?php
require_once 'includes/header.php';

# Obtém a página solicitada, se não houver, carrega 'dashboard'
$page = isset($_GET['page']) ? $_GET['page'] : 'lista_prod';
$viewPath = "{$page}.php";

# Verifica se a página existe antes de incluir
if (file_exists($viewPath)) {
    require_once $viewPath;
} else {
    print "<div style='height: 500px;'></div>";
}

require_once 'includes/footer.php';
