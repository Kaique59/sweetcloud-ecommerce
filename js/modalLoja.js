import { enviarPedido } from './pedido.js';

document.getElementById("btnLoja").addEventListener("click", () => {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];

  if (carrinho.length === 0) {
    mostrarmostrarAlertaa("Seu carrinho está vazio. Adicione itens antes de continuar.");
    return;
  }

  const modal = document.getElementById("modalLoja");
  modal.style.display = "flex";

  let subtotal = 0;

  carrinho.forEach(item => {
    const preco = typeof item.preco === 'string'
      ? parseFloat(item.preco.replace(',', '.'))
      : item.preco;
    subtotal += preco * item.qtd;
  });

  const taxaEntrega = 0;
  const desconto = 0;
  const total = subtotal + taxaEntrega - desconto;

  const formatarBRL = valor => valor.toLocaleString('pt-BR', {
    style: 'currency',
    currency: 'BRL'
  });

  document.getElementById("modal-subtotal").textContent = formatarBRL(subtotal);
  document.getElementById("modal-entrega").textContent = formatarBRL(taxaEntrega);
  document.getElementById("modal-desconto").textContent = formatarBRL(desconto);
  document.getElementById("modal-total").textContent = formatarBRL(total);
});

window.addEventListener("click", (e) => {
  const modal = document.getElementById("modalLoja");
  if (e.target === modal || e.target.id === "fecharModal") {
    modal.style.display = "none";
  }
});

document.getElementById("confirmarRetirada").addEventListener("click", async () => {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  if (carrinho.length === 0) {
    alert("Seu carrinho está vazio. Adicione itens antes de confirmar o pedido.");
    return;
  }

  mostrarmostrarAlertaa("Pedido para retirada confirmado! Obrigada :)");

  await enviarPedido("Pagamento na Loja", 0);
  localStorage.removeItem("carrinho");

  window.location.href = "historico.php?atualizado=" + new Date().getTime();
});
