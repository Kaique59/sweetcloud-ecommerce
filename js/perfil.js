document.addEventListener('DOMContentLoaded', function () {
  const userProfileToggle = document.getElementById('userProfileToggle');
  const userDropdownMenu = document.getElementById('userDropdownMenu');

  if (userProfileToggle && userDropdownMenu) {
    userProfileToggle.addEventListener('click', function (event) {
      // Impede que o clique feche o dropdown imediatamente se for um link (deslogado)
      event.stopPropagation();
      userDropdownMenu.classList.toggle('show');
    });

    // Fecha o dropdown se clicar fora dele
    document.addEventListener('click', function (event) {
      if (!userProfileToggle.contains(event.target) && !userDropdownMenu.contains(event.target)) {
        userDropdownMenu.classList.remove('show');
      }
    });
  }
});

function atualizarBadgeCarrinho() {
  const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
  const count = carrinho.reduce((acc, item) => acc + item.qtd, 0);
  const badge = document.getElementById("cartCount");
  if (!badge) return;
  if (count > 0) {
    badge.textContent = count;
    badge.style.display = "inline-block";
  } else {
    badge.style.display = "none";
  }
}

// Chama ao carregar a página
document.addEventListener("DOMContentLoaded", atualizarBadgeCarrinho);

// Escuta mudanças do localStorage em outras abas
window.addEventListener("storage", (event) => {
  if (event.key === "carrinho") {
    atualizarBadgeCarrinho();
  }
});



// Novo script para o menu mobile
document.addEventListener('DOMContentLoaded', () => {
  const mobileMenu = document.getElementById('mobile-menu');
  const navMenu = document.querySelector('.nav-menu');

  if (mobileMenu && navMenu) {
    mobileMenu.addEventListener('click', () => {
      navMenu.classList.toggle('active');
      mobileMenu.classList.toggle('active');
    });
  }
});