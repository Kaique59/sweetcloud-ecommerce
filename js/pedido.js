export async function enviarPedido(metodoPagamento, taxaEntrega = 0) {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  if (carrinho.length === 0) {
    mostrarmostrarAlertaa("Seu carrinho está vazio!");
    return;
  }

  // Calcular subtotal
  let subtotal = 0;
  carrinho.forEach(item => {
    const preco = typeof item.preco === 'string' ? parseFloat(item.preco.replace(',', '.')) : item.preco;
    subtotal += preco * item.qtd;
  });

  const valorTotal = subtotal + taxaEntrega;

  // Pega o id_cliente da sessão PHP, ou envie via variável JS
  const id_cliente = window.id_cliente || 1; // Ajuste conforme sua lógica

  const dados = {
    carrinho,
    metodo_pagamento: metodoPagamento,
    valor_total: valorTotal
  };

  try {
    const response = await fetch('../controllers/salvar_pedido.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dados)
    });
    const resultado = await response.json();

    if (resultado.success) {
      mmostrarmostrarAlertaa("Pedido confirmado! ID: " + resultado.id_pedido);
      localStorage.removeItem("carrinho");
      window.location.href = "historico.php";
    } else {
      mostrarmostrarAlertaa("Erro ao salvar pedido: " + resultado.error);
    }
  } catch (error) {
    mostrarmostrarAlertaa("Erro na comunicação com o servidor.");
    console.error(error);
  }
}
