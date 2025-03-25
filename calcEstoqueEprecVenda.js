function calculaEstoque() {
    let qtdeDeCaixa = parseFloat(document.getElementById("qtdeDeCaixa").value) || 0;
    let qtdeNaCaixa = parseFloat(document.getElementById("qtdeNaCaixa").value) || 0;
    let estoqueAtual = parseFloat(document.getElementById("estoqueAtual").value) || 0;

    let estoqueFuturo = estoqueAtual + (qtdeDeCaixa * qtdeNaCaixa);
    document.getElementById("estoqueFuturo").value = estoqueFuturo.toFixed(2);

    if (estoqueAtual == 0) {
        document.getElementById("estoqueAtual").value = 0;
    }
    
    calculaPrecoUn();
}

function calculaPrecoUn() {
    let precoCompra = parseFloat(document.getElementById("preco_caixa").value) || 0;
    let qtdePorCaixa = parseFloat(document.getElementById("quantidade_por_caixa").value) || 1;

    let precoUn = precoCompra / qtdePorCaixa;
    document.getElementById("preco_unitario").value = precoUn.toFixed(2);

    calculaPrecoVenda();
}

function calculaPrecoVenda() {
    let precoUnCompra = parseFloat(document.getElementById("preco_unitario").value) || 0;
    let margemVenda = parseFloat(document.getElementById("margem_lucro").value) || 0;

    // Cálculo correto do preço de venda com margem
    let precoVenda = precoUnCompra / (1 - (margemVenda / 100));

    document.getElementById("preco_venda").value = precoVenda.toFixed(2);
}

