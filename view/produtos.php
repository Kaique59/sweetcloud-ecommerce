<?php
// Cabeçalho e conexão
include_once("../includes/header.php");
include_once("../conexao.php"); // $pdo precisa estar criado aqui
include_once("./modal-generico.php");

// Inicializa a consulta SQL
$sql = "SELECT * FROM Produto";
$params = []; // Array para armazenar parâmetros da consulta

// Verifica se a categoria foi passada via GET
if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    // Adiciona a condição WHERE para filtrar por categoria
    $sql .= " WHERE categoria = :categoria";
    $params[':categoria'] = $categoria;
}

// Prepara e executa a consulta
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../css/style.css">

<section class="produtos">
  <h2>Nosso Catálogo</h2>

  <div class="grid-produtos">
    <?php if ($produtos): ?>
      <?php foreach ($produtos as $produto): ?>
        <div class="card-produto">
          <div class="img-produto">
            <img
              src="<?= htmlspecialchars($produto['imagem']) ?>"
              alt="<?= htmlspecialchars($produto['nome']) ?>">

          </div>

          <p class="nome-produto"><?= htmlspecialchars($produto['nome']) ?></p>
          <p class="preco-produto">
            R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
          </p>

          <button
            class="btn-vermais"
            data-id_produto="<?= htmlspecialchars($produto['id_produto']) ?>"
            data-img="<?= htmlspecialchars($produto['imagem']) ?>"
            data-nome="<?= htmlspecialchars($produto['nome']) ?>"
            data-desc="<?= htmlspecialchars($produto['descricao']) ?>"
            data-preco="<?= number_format($produto['preco'], 2, ',', '.') ?>">
            Ver mais
          </button>

        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Nenhum produto encontrado.</p>
    <?php endif; ?>
  </div>
</section>

<div id="modal" class="modal-overlay">
  <div class="modal-produto">
    <span class="fechar-modal" id="btn-fechar">&times;</span>

    <div class="modal-body">
      <div class="modal_img">
        <img id="modal-img" src="" alt="">
      </div>

      <div class="modal_itens">
        <p id="modal-nome" class="nomeModal">NOME DO ITEM</p>
        <p id="modal-descricao" class="DcrModal">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquam blandit est.
        </p>
        <p id="modal-preco" class="modalPreco"></p>

        <div class="quantidade">
          <button id="btn-menos">−</button>
          <span id="quantidade-valor">1</span>
          <button id="btn-mais">+</button>
        </div>

        <button id="btn-adicionar" class="btn-adicionar">
          Adicionar ao carrinho
        </button>
      </div>
    </div>
  </div>
</div>


<script src="../js/modal.js"></script>
<script src="../js/modal-alerta.js"></script>

<?php
include_once("contato.php");
include_once("../includes/footer.php");
?>