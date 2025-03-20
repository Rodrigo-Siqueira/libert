<?php 
    require_once '../conexao.php';

    $sqlListar = "SELECT * FROM clientes";
    
    $stmtListar = $conexao->prepare($sqlListar);
    $stmtListar->execute();

    $clientes = array();

    while ($dados = $stmtListar->fetch(PDO::FETCH_OBJ)) {
        $clientes[] = array("ID" => $dados->id, "NOME" => $dados->nome);
    }

    echo json_encode($clientes);

?>