<?php
session_start();

// Alternar visibilidade do campo de observações
if (isset($_POST['toggle_observacoes'])) {
  $_SESSION['mostrar_observacoes'] = isset($_SESSION['mostrar_observacoes']) ? !$_SESSION['mostrar_observacoes'] : true;
}

include_once("../includes/header.php");
include_once("./modal-generico.php");

include_once("../conexao.php"); // ou ajuste o caminho correto

$id_cliente = isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : null;
$enderecos = [];

if ($id_cliente) {
  $stmt = $pdo->prepare("SELECT  rua, numero, bairro, cidade, estado, cep FROM Cliente WHERE id_cliente = ?");
  $stmt->execute([$id_cliente]);
  $enderecos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<link rel="stylesheet" href="../css/carrinho.css">

<section class="carrinho-container">

  <div class="itens-carrinho-container">
    <div class="itens-carrinho"></div>

    <div class="observacoes-container">
      <form method="post" class="observacoes-form">
        <input type="hidden" name="toggle_observacoes" value="1">
        <button type="submit" class="observacoes-btn">Observações</button>
      </form>

      <!-- Substitua apenas este bloco do seu código -->
      <?php if (!empty($_SESSION['mostrar_observacoes'])) { ?>
        <div class="observacoes-box">
          <form id="formObservacoes">
            <textarea placeholder="Digite aqui..." name="mensagem" required></textarea>
            <button type="submit" class="observacoes-btn" id="btnEnviarObservacao">Enviar</button>
          </form>
        </div>
      <?php } ?>

      <!-- Modal de confirmação de envio -->
      <div id="modalMensagemEnviada" class="modal-overlay" style="display:none;">
        <div class="modal-content" style="max-width: 400px; text-align: center;">
          <button class="modal-close" onclick="fecharModalMensagem()">&times;</button>
          <p style="margin: 20px 0;">Sua mensagem foi enviada!</p>
          <button class="continuar-btn" onclick="fecharModalMensagem()">OK</button>
        </div>
      </div>

      <script>
        document.getElementById("formObservacoes")?.addEventListener("submit", function(e) {
          e.preventDefault();

          // Aqui você pode adicionar lógica de envio (AJAX etc.)

          // Exibe o modal de confirmação
          document.getElementById("modalMensagemEnviada").style.display = "flex";
        });

        function fecharModalMensagem() {
          // Fecha o modal
          document.getElementById("modalMensagemEnviada").style.display = "none";

          // Oculta o botão de enviar
          const btnEnviar = document.getElementById("btnEnviarObservacao");
          if (btnEnviar) {
            btnEnviar.style.display = "none";
          }
        }
      </script>

    </div>
  </div>

  <div class="divisoria"></div>

  <aside class="resumo-carrinho">
    <div class="logo-sweetcloud">
      <img src="../img/SweetCloud_BTN.png" alt="SweetCloud Logo">
    </div>

    <div class="opcoes-entrega">
      <button class="opcao-btn" id="btnLoja">Retirar na loja</button>
      <p class="ou">ou</p>
      <button class="opcao-btn" id="btnOnline">Entrega em casa</button>
    </div>

    <div class="cupom-desconto">
      <p>Cupom de Desconto</p>

      <div class="cupom-input-wrapper">
        <input type="text" placeholder="Digite aqui…" class="cupom-input">
        <button class="cupom-enviar" aria-label="Aplicar cupom"></button>
      </div>
    </div>

    <div class="total-geral">
      <strong>Total:</strong>
      <span id="total-valor">R$ 0,00</span>
    </div>
  </aside>
</section>

<!-- Modal Loja -->
<div class="modal-overlay" id="modalLoja">
  <div class="modal-content">
    <button class="modal-close" id="fecharModal">&times;</button>
    <img src="../img/SweetCloud_BTN.png" alt="Logo SweetCloud" class="modal-logo">

    <h3 class="modal-titulo">Pedido para Retirada</h3>
    <div class="modal-resumo">
      <p>Subtotal : <span id="modal-subtotal">R$ 000,00</span></p>
      <p>Taxa de entrega : <span id="modal-entrega">R$ 000,00</span></p>
      <p>Desconto : <span id="modal-desconto">R$ 000,00</span></p>
      <p class="total-pedido">Total do pedido : <span id="modal-total">R$ 000,00</span></p>
    </div>

    <div class="modal-endereco">
      <p>04864-090<br>Bairro-Balneário São José<br>Cidade-São Paulo<br>Estado-SP</p>
      <button class="observacoes-btn">Observações</button>
    </div>

    <div class="modal-pagamento">
      <h4>Formas de pagamento</h4>
      <button class="opcao-btn" data-pagamento="pix">PIX</button>
      <button class="opcao-btn" data-pagamento="loja">Pagamento na Loja</button>
    </div>

    <button class="continuar-btn" id="confirmarRetirada">Confirmar Pedido</button>

    <div class="modal-contato">
      <p>Precisa entrar em contato?<br>
        <strong>Basta clicar no ícone do Whatsapp</strong>
      </p>
      <img src="https://cdn-icons-png.flaticon.com/512/3670/3670051.png" alt="Whatsapp" width="40">
    </div>
  </div>
</div>

<script src="../js/carrinho.js"></script>

<!-- MODAL ENTREGA ONLINE -->
<div class="modal-overlay" id="modalOnline">
  <div class="modal-content">
    <button class="modal-close" id="fecharModalOnline">&times;</button>

    <img src="../img/SweetCloud_BTN.png" alt="Logo SweetCloud" class="modal-logo">

    <h3 class="modal-titulo">Entrega em Casa</h3>

    <div class="modal-resumo">
      <p>Subtotal : <span id="online-subtotal">R$ 000,00</span></p>
      <p>Taxa de entrega : <span id="online-entrega">R$ 000,00</span></p>
      <p>Desconto : <span id="online-desconto">R$ 000,00</span></p>
      <p class="total-pedido">Total do pedido : <span id="online-total">R$ 000,00</span></p>
    </div>

    <div class="modal-endereco-online">
      <label for="enderecos" class="label-endereco">Escolha um endereço cadastrado</label>
      <select id="enderecos" class="input-endereco">
        <option value="">Selecione</option>
        <?php foreach ($enderecos as $end) {
          $enderecoFormatado = "{$end['rua']}, {$end['numero']} - {$end['bairro']} - {$end['cidade']}/{$end['estado']} - CEP: {$end['cep']}";
          echo "<option value='{$end['id_cliente']}'>{$enderecoFormatado}</option>";
        } ?>
        <option value="novo">Adicionar novo endereço</option>
      </select>
    </div>

    <div class="modal-pagamento">
      <h4>Formas de pagamento</h4>
      <button class="opcao-btn">PIX</button>
    </div>
    <button class="continuar-btn" id="confirmarEntrega">Confirmar Pedido</button>

    <div class="modal-contato">
      <p>Precisa entrar em contato?<br>
        <strong>Basta clicar no ícone do Whatsapp</strong>
      </p>
      <img src="https://cdn-icons-png.flaticon.com/512/3670/3670051.png" alt="Whatsapp" width="40">
    </div>
  </div>
</div>

<script src="../js/modal-alerta.js"></script>
<script type="module" src="../js/modalLoja.js"></script>
<script type="module" src="../js/modalonline.js"></script>

<?php
include 'contato.php';
include_once("../includes/footer.php");
?>