<?php
    include_once '../conexao.php';

    $sqlListar = "SELECT * FROM fornecedores";

    $stmtListar = $conexao->prepare($sqlListar);
    $stmtListar->execute();

    $fornecedores = array();

    while ($dados = $stmtListar->fetch(PDO::FETCH_OBJ)) {
        $fornecedores[] = array("ID" => $dados->id, "NOME" => $dados->nome, "CONTATO" => $dados->contato, "CIDADE"=> $dados->cidade);
    }

    echo json_encode($fornecedores);
    
?>