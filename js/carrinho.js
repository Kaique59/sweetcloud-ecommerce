/*  Desenha / atualiza o carrinho usando o localStorage
    — 100 % dinâmico, sem recarregar a página                    */

document.addEventListener("DOMContentLoaded", () => {
  const wrap       = document.querySelector(".itens-carrinho");
  const totalSpan  = document.getElementById("total-valor");
  const carrinho   = JSON.parse(localStorage.getItem("carrinho")) || [];
  console.log(JSON.parse(localStorage.getItem("carrinho")));

  const observacoesContainer = document.querySelector(".observacoes-container");
  if (carrinho.length === 0) {
    observacoesContainer.style.display = "none";
  } else {
    observacoesContainer.style.display = "block";
  }


  /* ————————————————— helpers ————————————————— */
  const formatBRL = (n) =>
    `R$ ${n.toFixed(2).replace(".", ",")}`.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

  const salvar = () =>
    localStorage.setItem("carrinho", JSON.stringify(carrinho));

  const calcularTotal = () => {
    const total = carrinho.reduce((acc, p) => acc + p.preco * p.qtd, 0);
    totalSpan.textContent = formatBRL(total);
  };

  /* ——————————————— renderiza todo o carrinho ——————————————— */
  function render() {
    wrap.innerHTML = "";

    if (!carrinho.length) {
      wrap.innerHTML =
        '<p class="vazio">Seu carrinho está vazio</p>';
      calcularTotal();
      return;
    }

    carrinho.forEach((item, idx) => {
      wrap.insertAdjacentHTML(
        "beforeend",
        `
         <div class="item-card" data-idx="${idx}">
          <div class="item-imagem">
            <img src="${item.img}" alt="${item.nome}">
          </div>

          <div class="item-info">
            <div class="item-header">
              <h3 class="item-nome">${item.nome}</h3>
              <button class="item-excluir" title="Remover item">&times;</button>
            </div>
            <p class="item-descricao">${item.desc}</p>

            <p class="item-preco">
              <span class="valor-linha">${formatBRL(item.preco * item.qtd)}</span>
            </p>

            <div class="item-quantidade-compra">
              <div class="item-quantidade">
                <button class="quantidade-btn menos">−</button>
                <span  class="quantidade-valor">${item.qtd}</span>
                <button class="quantidade-btn mais">+</button>
              </div>
            </div>
          </div>
          </div>
        `
      );
    });

    calcularTotal();
  }

  render();                                   // primeira carga

  /* ———————— delegação: + / − / excluir ———————— */
  wrap.addEventListener("click", (e) => {
    const card = e.target.closest(".item-card");
    if (!card) return;

    const i        = +card.dataset.idx;
    const qtdSpan  = card.querySelector(".quantidade-valor");
    const precoLin = card.querySelector(".valor-linha");

    if (e.target.classList.contains("mais")) {
      carrinho[i].qtd++;
    }

    if (e.target.classList.contains("menos")) {
      carrinho[i].qtd = Math.max(1, carrinho[i].qtd - 1);
    }

    if (e.target.classList.contains("item-excluir")) {
      carrinho.splice(i, 1);
    }

    salvar();

    if (e.target.classList.contains("item-excluir")) {
      render();                               // re-render geral
    } else {
      // só quantidade mudou
      qtdSpan.textContent  = carrinho[i].qtd;
      precoLin.textContent = formatBRL(
        carrinho[i].preco * carrinho[i].qtd
      );
      calcularTotal();
    }
  });
});
