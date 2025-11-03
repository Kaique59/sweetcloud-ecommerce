// Espera o DOM carregar pra garantir que os elementos existem
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("modal-mostrarAlertaa");
  const mensagem = document.getElementById("modal-mostrarAlertaa-msg");
  const fechar = document.getElementById("modal-mostrarAlertaa-fechar");
  const botaoOk = document.getElementById("modal-ok-btn");

  // Se algo não for encontrado, já avisa no console
  if (!modal || !mensagem || !fechar || !botaoOk) {
    console.error("Algum elemento do modal não foi encontrado.");
    return;
  }

  // Função global para mostrar o modal com a mensagem
  window.mostrarmostrarAlertaa = function(msg) {
    mensagem.textContent = msg;
    modal.style.display = "flex";
  };

  // Função auxiliar pra fechar o modal
  const fecharModal = () => {
    modal.style.display = "none";
  };

  // Fechar no botão X
  fechar.addEventListener("click", fecharModal);

  // Fechar no botão OK
  botaoOk.addEventListener("click", fecharModal);

  // Fechar ao clicar fora do conteúdo
  window.addEventListener("click", (e) => {
    if (e.target === modal) {
      fecharModal();
    }
  });
});
