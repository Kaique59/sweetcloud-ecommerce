// modalonline.js
import { enviarPedido } from './pedido.js';

document.getElementById("btnOnline").addEventListener("click", () => {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];

  if (carrinho.length === 0) {
    mostrarmostrarAlertaa("Seu carrinho está vazio. Adicione itens antes de continuar.");
    return;
  }
  const modal = document.getElementById("modalOnline");
  modal.style.display = "flex";
  let subtotal = 0;

  carrinho.forEach(item => {
    const preco = typeof item.preco === 'string'
      ? parseFloat(item.preco.replace(',', '.'))
      : item.preco;
    subtotal += preco * item.qtd;
  });

  // Aqui futuramente pode ter lógica de entrega por CEP
  const taxaEntrega = 5.99; // Exemplo de taxa fixa para entrega
  const desconto = 0;
  const total = subtotal + taxaEntrega - desconto;

  const formatarBRL = valor => valor.toLocaleString("pt-BR", {
    style: "currency",
    currency: "BRL"
  });

  document.getElementById("online-subtotal").textContent = formatarBRL(subtotal);
  document.getElementById("online-entrega").textContent = formatarBRL(taxaEntrega);
  document.getElementById("online-desconto").textContent = formatarBRL(desconto);
  document.getElementById("online-total").textContent = formatarBRL(total);
});

window.addEventListener("click", (e) => {
  const modal = document.getElementById("modalOnline");
  if (e.target === modal || e.target.id === "fecharModalOnline") {
    modal.style.display = "none";
  }
});

// Confirmar entrega
document.getElementById("confirmarEntrega").addEventListener("click", () => {

  if (carrinho.length === 0) {
    alert("Seu carrinho está vazio! Adicione produtos antes de confirmar o pedido.");
    return; // Não continua se o carrinho estiver vazio
  }
  // Aqui também salvaria em "historico"
  mostrarmostrarAlertaa("Pedido para entrega confirmado! Obrigada :)");
  enviarPedido("PIX", 5.99); // taxa de entrega fixa, por exemplo
  localStorage.removeItem("carrinho"); // Zera o carrinho
  window.location.href = "historico.php";
});
