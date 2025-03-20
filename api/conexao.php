<?php

    $dsn = "mysql:host=localhost;dbname=libertDoces;charset=utf8";
    $usuario = "root";
    $senha = "";

    try {
        $conexao = new PDO($dsn, $usuario, $senha);
        #echo "sucesso";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
        exit;
    }
?>
