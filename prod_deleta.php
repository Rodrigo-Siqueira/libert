<?php

$produto = $_GET;

if ($produto['id']) {

    $dns = array("HOST" => 'localhost', "USUARIO" => 'root', "SENHA" => '', "BANCODADOS" => 'libertDoces');
    $conectar = mysqli_connect($dns['HOST'], $dns['USUARIO'], $dns['SENHA'], $dns['BANCODADOS']);

    $resultado = mysqli_query($conectar, "DELETE FROM produtos WHERE id = '{$produto['id']}'");

    if ($resultado) {
        print 'Produto excluido com sucesso!';
    } else {
        print 'Houve um erro ao excluir o produto' . mysqli_error($conectar);
    }

    mysqli_close($conectar);
}