document.addEventListener("DOMContentLoaded", () => {
    const modalOverlay = document.getElementById("modal");
    const btnFechar = document.getElementById("btn-fechar");

    const modalImg = document.getElementById("modal-img");
    const modalNome = document.getElementById("modal-nome");
    const modalDescricao = document.getElementById("modal-descricao");
    const modalPreco = document.getElementById("modal-preco");

    const quantidadeValor = document.getElementById("quantidade-valor");
    const btnMais = document.getElementById("btn-mais");
    const btnMenos = document.getElementById("btn-menos");
    const btnAdicionar = document.getElementById("btn-adicionar");

    let precoUnitario = 0;
    let idProdutoSelecionado = null; // ID real do produto no banco

    // Abrir modal e preencher com dados
    document.querySelectorAll(".btn-vermais").forEach((botao) => {
        botao.addEventListener("click", () => {
            idProdutoSelecionado = botao.dataset.id_produto; // Captura o id_produto real

            modalImg.src = botao.dataset.img;
            modalImg.alt = botao.dataset.nome;
            modalNome.textContent = botao.dataset.nome;
            modalDescricao.textContent = botao.dataset.desc;

            precoUnitario = parseFloat(botao.dataset.preco);
            quantidadeValor.textContent = "1";
            atualizarPreco(1);

            modalOverlay.classList.add("is-open");
        });
    });

    // Fechar modal
    btnFechar.addEventListener("click", () =>
        modalOverlay.classList.remove("is-open")
    );

    modalOverlay.addEventListener("click", (e) => {
        if (e.target === modalOverlay) modalOverlay.classList.remove("is-open");
    });

    // Botões de quantidade
    btnMais.addEventListener("click", () => {
        const novaQtd = +quantidadeValor.textContent + 1;
        quantidadeValor.textContent = novaQtd;
        atualizarPreco(novaQtd);
    });

    btnMenos.addEventListener("click", () => {
        let novaQtd = +quantidadeValor.textContent;
        if (novaQtd > 1) {
            novaQtd--;
            quantidadeValor.textContent = novaQtd;
            atualizarPreco(novaQtd);
        }
    });

    // Adicionar ao carrinho
    btnAdicionar.addEventListener("click", () => {
        const item = {
            id_produto: idProdutoSelecionado, // aqui vem o id do banco!
            img: modalImg.src,
            nome: modalNome.textContent,
            desc: modalDescricao.textContent,
            preco: precoUnitario,
            qtd: +quantidadeValor.textContent
        };

        const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
        const existe = carrinho.find(p => p.id_produto === item.id_produto);

        if (existe) {
            existe.qtd += item.qtd;
        } else {
            carrinho.push(item);
        }

        localStorage.setItem("carrinho", JSON.stringify(carrinho));
        atualizarBadgeCarrinho();
        modalOverlay.classList.remove("is-open");

        // --- ADIÇÃO DO ALERTA AQUI ---
        // Verifica se a função mostrarmostrarAlertaa está disponível
        if (typeof mostrarmostrarAlertaa === 'function') {
            mostrarmostrarAlertaa(`"${item.nome}" adicionado ao carrinho!`, 3000); // Exibe o alerta por 3 segundos
        } else {
            console.error("Função 'mostrarmostrarAlertaa' não está definida. Verifique a inclusão do script do modal genérico.");
        }
        // --- FIM DA ADIÇÃO DO ALERTA ---
    });

    function atualizarPreco(qtd) {
        const total = precoUnitario * qtd;
        modalPreco.textContent = `R$ ${total.toFixed(2).replace(".", ",")}`;
    }
});