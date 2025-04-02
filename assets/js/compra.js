let listaCompras = [];
let totalCompra = 0;

function adicionarItem() {
    const selectProduto = document.getElementById("produto");
    const qtdeDeCaixa = document.getElementById("quantidade_de_caixa").value;
    const qtdePorCaixa = document.getElementById("quantidade_por_caixa").value;
    const precoCaixa = document.getElementById("preco_caixa").value;
    const precoUn = document.getElementById("preco_unitario").value;
    const margemLucro = document.getElementById("margem_lucro").value;
    const precoVenda = document.getElementById("preco_venda").value;
    const dataRecebimento = document.getElementById("data_recebimento").value;
    const dataValidade = document.getElementById("data_validade").value;
    const custoTotal = document.getElementById("custo_total").value;
    


    const produtoId = selectProduto.value;
    const produtoNome = selectProduto.options[selectProduto.selectedIndex].text;
    
    totalCompra += parseFloat(custoTotal);

   

    // Adiciona ao carrinho
    listaCompras.push({
        id: produtoId,
        nome: produtoNome,
        quantidade_de_caixa: parseInt(qtdeDeCaixa),
        quantidade_por_caixa: parseInt(qtdePorCaixa),
        preco_caixa: parseFloat(precoCaixa).toFixed(2),
        preco_unitario: parseFloat(precoUn).toFixed(2),
        margem_lucro: parseFloat(margemLucro).toFixed(2),
        preco_venda: parseFloat(precoVenda).toFixed(2),
        dataRecebimento: dataRecebimento,
        dataValidade: dataValidade,
        custo_total: parseFloat(custoTotal).toFixed(2)

    });

    atualizarLista();
}

function atualizarLista() {
    const tabela = document.querySelector("#lista-compras tbody");
    tabela.innerHTML = "";
    totalCompra = 0; // Resetar o total antes de somar novamente

    listaCompras.forEach((item, index) => {
        totalCompra += parseFloat(item.custo_total); // Agora dentro do loop

        tabela.innerHTML += `
            <tr>
                <td>${item.nome}</td>
                <td>${item.quantidade_de_caixa}</td>
                <td>${item.preco_caixa}</td>
                <td>${item.custo_total}</td>
                <td><button class="w3-button w3-teal" onclick="removerItem(${index})">Remover</button></td>
            </tr>
        `;
    });
    document.getElementById("totalCompra").value = totalCompra.toFixed(2);
    document.getElementById("total-compra").textContent = totalCompra.toFixed(2);
    document.getElementById("itens_compra").value = JSON.stringify(listaCompras);
}

function removerItem(index) {
    listaCompras.splice(index, 1);
    atualizarLista();
}