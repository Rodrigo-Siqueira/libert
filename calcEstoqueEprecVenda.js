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
    let precoCompra = parseFloat(document.getElementById("precoCompra").value) || 0;
    let qtdeNaCaixa = parseFloat(document.getElementById("qtdeNaCaixa").value) || 1;

    let precoUn = precoCompra / qtdeNaCaixa;
    document.getElementById("precoUnCompra").value = precoUn.toFixed(2);

    calculaPrecoVenda();
}

function calculaPrecoVenda() {
    let precoUnCompra = parseFloat(document.getElementById("precoUnCompra").value) || 0;
    let margemVenda = parseFloat(document.getElementById("margemVenda").value) || 0;

    // Cálculo correto do preço de venda com margem
    let precoVenda = precoUnCompra / (1 - (margemVenda / 100));

    document.getElementById("precoVenda").value = precoVenda.toFixed(2);
}

